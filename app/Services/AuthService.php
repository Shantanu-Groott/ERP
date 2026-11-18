<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Core\Session;
use PDO;
use Throwable;

final class AuthService
{
    private const WINDOW_MIN        = 15;   // sliding window for throttling
    private const MAX_PER_IDENTITY  = 5;    // failed tries per (identifier + IP) per window
    private const MAX_PER_IP        = 20;   // failed tries per IP per window
    private const MAX_ACCOUNT_FAILS = 10;   // across all IPs, then the account locks
    private const LOCK_MIN          = 15;

    // One message for every failure, so attackers learn nothing about which accounts exist
    private const GENERIC   = 'Invalid credentials, or the account is unavailable.';
    private const THROTTLED = 'Too many attempts. Please wait a few minutes and try again.';

    /** @return array{success:bool, message?:string, must_change?:bool} */
    public static function attempt(?string $realm, string $identifier, string $password, string $ip): array
    {
        $pdo   = Database::getConnection();
        $id    = mb_strtolower(trim($identifier));
        $table = 'users';

        if (self::throttled($pdo, $id, $ip)) {
            return [
                'success' => false, 
                'message' => 'Too many failed login attempts from this network. For security, please wait a few minutes before trying again.'
            ];
        }

        $user = self::findUser($pdo, $id);

        // Case 1: Account does not exist
        if (!$user) {
            self::record($pdo, $id, $ip, false);
            AuditService::log(null, 'login.failed', 'auth', null, ['ip' => $ip, 'reason' => 'user_not_found']);
            return [
                'success' => false,
                'message' => "No account found with username or email '{$identifier}'. Please verify your spelling or contact your administrator."
            ];
        }

        // Case 2: Account is locked due to too many failed attempts
        if ((bool)$user['is_locked']) {
            self::record($pdo, $id, $ip, false);
            AuditService::log((int)$user['id'], 'login.failed', 'auth', (int)$user['id'], ['ip' => $ip, 'reason' => 'account_locked']);
            $lockedTime = !empty($user['locked_until']) ? date('g:i A', strtotime((string)$user['locked_until'])) : '15 minutes';
            return [
                'success' => false,
                'message' => "This account is temporarily locked due to multiple failed attempts. Please try again after {$lockedTime} or reset your password."
            ];
        }

        // Case 3: Account is inactive or suspended
        if ($user['status'] !== 'active') {
            self::record($pdo, $id, $ip, false);
            AuditService::log((int)$user['id'], 'login.failed', 'auth', (int)$user['id'], ['ip' => $ip, 'reason' => 'account_inactive']);
            $statusName = ucfirst((string)$user['status']);
            return [
                'success' => false,
                'message' => "This account is currently {$statusName} (not active). Please contact the institute administrator to activate your account."
            ];
        }

        // Case 4: Verify password
        $ok = password_verify($password, $user['password_hash']);

        if (!$ok) {
            // If previous lockout expired, restart counter from 1; otherwise increment and lock when threshold reached
            $hasExpiredLock = (!empty($user['locked_until']) && strtotime((string)$user['locked_until']) <= time());
            if ($hasExpiredLock) {
                $pdo->prepare("UPDATE {$table} SET failed_attempts = 1, locked_until = NULL WHERE id = :id")
                    ->execute(['id' => $user['id']]);
                $attemptsSoFar = 1;
            } else {
                $stmtLock = $pdo->prepare(
                    "UPDATE {$table}
                        SET failed_attempts = failed_attempts + 1,
                            locked_until = CASE
                                WHEN failed_attempts >= :max THEN DATE_ADD(NOW(), INTERVAL " . self::LOCK_MIN . " MINUTE)
                                ELSE locked_until
                            END
                      WHERE id = :id"
                );
                $stmtLock->execute(['max' => self::MAX_ACCOUNT_FAILS, 'id' => $user['id']]);
                $attemptsSoFar = (int)$user['failed_attempts'] + 1;
            }

            self::record($pdo, $id, $ip, false);
            AuditService::log((int)$user['id'], 'login.failed', 'auth', (int)$user['id'], ['ip' => $ip, 'reason' => 'invalid_password']);

            $remaining = self::MAX_ACCOUNT_FAILS - $attemptsSoFar;
            $attemptWarning = ($remaining > 0 && $remaining <= 3)
                ? " ({$remaining} attempt" . ($remaining === 1 ? '' : 's') . " left before temporary lockout)"
                : "";

            return [
                'success' => false,
                'message' => "Incorrect password for this account.{$attemptWarning} Please verify your password or use 'Forgot Password'."
            ];
        }

        // Upgrade the hash silently if the cost parameters have changed
        if (password_needs_rehash($user['password_hash'], PASSWORD_ARGON2ID)) {
            $pdo->prepare("UPDATE {$table} SET password_hash = :h WHERE id = :id")
                ->execute(['h' => password_hash($password, PASSWORD_ARGON2ID), 'id' => $user['id']]);
        }

        $pdo->prepare("UPDATE {$table} SET failed_attempts = 0, locked_until = NULL, last_login_at = NOW() WHERE id = :id")
            ->execute(['id' => $user['id']]);

        self::record($pdo, $id, $ip, true);
        Session::login((int)$user['id'], (bool)$user['must_change_password']);
        Session::set('user_name', $user['full_name']);
        Session::set('user_email', $user['email']);
        Session::set('user_username', $user['username']);

        AuditService::log((int)$user['id'], 'login.success', 'auth', (int)$user['id'], ['ip' => $ip]);

        return ['success' => true, 'must_change' => (bool)$user['must_change_password']];
    }

    public static function logout(string $ip): void
    {
        $uid = Session::get('user_id');
        if (is_int($uid)) {
            AuditService::log($uid, 'logout', 'auth', $uid, ['ip' => $ip]);
        }
        Session::invalidate();
    }

    private static function hashIdentifier(string $id): string
    {
        $key = getenv('APP_KEY') ?: 'kalavanta_erp_hmac_secret_2026';
        return hash_hmac('sha256', mb_strtolower(trim($id)), $key);
    }

    private static function findUser(PDO $pdo, string $id): ?array
    {
        $sql = 'SELECT u.id, u.full_name, u.email, u.username, u.password_hash, u.status, u.must_change_password,
                       u.failed_attempts, u.locked_until,
                       (u.locked_until IS NOT NULL AND u.locked_until > NOW()) AS is_locked
                  FROM users u
             LEFT JOIN students s ON s.user_id = u.id
                 WHERE u.email = :a OR u.username = :b OR s.roll_no = :c LIMIT 1';

        $st = $pdo->prepare($sql);
        $st->execute(['a' => $id, 'b' => $id, 'c' => $id]);
        return $st->fetch() ?: null;
    }

    private static function throttled(PDO $pdo, string $id, string $ip): bool
    {
        $idHash = self::hashIdentifier($id);
        $st = $pdo->prepare(
            'SELECT COALESCE(SUM(identifier = :idHash), 0) AS by_identity,
                    COUNT(*) AS by_ip
               FROM login_attempts
              WHERE ip_address = :ip AND success = 0
                AND attempted_at > NOW() - INTERVAL ' . self::WINDOW_MIN . ' MINUTE'
        );
        $st->execute(['idHash' => $idHash, 'ip' => $ip]);
        $row = $st->fetch();

        return (int)($row['by_identity'] ?? 0) >= self::MAX_PER_IDENTITY
            || (int)($row['by_ip'] ?? 0) >= self::MAX_PER_IP;
    }

    private static function record(PDO $pdo, string $id, string $ip, bool $success): void
    {
        $idHash = self::hashIdentifier($id);
        $pdo->prepare('INSERT INTO login_attempts (identifier, ip_address, success) VALUES (:i, :ip, :s)')
            ->execute(['i' => $idHash, 'ip' => $ip, 's' => (int)$success]);

        // Minimize retention to 1 hour to reduce stored attempt metadata
        if (random_int(1, 100) === 1) {
            $pdo->exec('DELETE FROM login_attempts WHERE attempted_at < NOW() - INTERVAL 1 HOUR');
        }
    }

    private static function audit(PDO $pdo, ?int $uid, string $action, string $ip): void
    {
        AuditService::log($uid, $action, 'auth', $uid, ['ip' => $ip]);
    }

    private static function dummyHash(): string
    {
        static $hash = null;
        return $hash ??= (getenv('AUTH_DUMMY_HASH') ?: password_hash('dummy-password-not-used', PASSWORD_ARGON2ID));
    }
}
