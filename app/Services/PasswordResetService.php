<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Services\MailService;
use PDO;
use Throwable;

final class PasswordResetService
{
    private const TOKEN_LIFETIME_HOURS = 2;

    public static function request(string $realm, string $identifier, string $ip): bool
    {
        try {
            $pdo = AuthService::pdo($realm);
            $id = mb_strtolower(trim($identifier));

            $stmt = $pdo->prepare('SELECT id, email, full_name FROM users WHERE (email = :e OR username = :u) AND status = "active" LIMIT 1');
            $stmt->execute(['e' => $id, 'u' => $id]);
            $user = $stmt->fetch();

            if (!$user) {
                return false;
            }

            $rawToken = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $rawToken);

            $ins = $pdo->prepare('
                INSERT INTO password_resets (user_id, token_hash, expires_at)
                VALUES (:uid, :th, DATE_ADD(NOW(), INTERVAL ' . self::TOKEN_LIFETIME_HOURS . ' HOUR))
            ');
            $ins->execute([
                'uid' => $user['id'],
                'th'  => $tokenHash
            ]);

            $url = (getenv('APP_URL') ?: 'http://localhost:8001') . "/reset-password?realm={$realm}&token={$rawToken}";
            MailService::send(
                $user['email'],
                'Password Reset Instructions - Kalavanta Edutech',
                "<p>Hello {$user['full_name']},</p><p>Click below to reset your password:</p><p><a href='{$url}'>{$url}</a></p><p>This link expires in 2 hours.</p>"
            );

            return true;
        } catch (Throwable $e) {
            error_log('Password reset request error: ' . $e->getMessage());
            return false;
        }
    }

    /** @return array{success:bool, message:string} */
    public static function reset(string $realm, string $rawToken, string $newPassword): array
    {
        if (strlen($newPassword) < 8) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters.'];
        }

        try {
            $pdo = AuthService::pdo($realm);
            $tokenHash = hash('sha256', $rawToken);

            $stmt = $pdo->prepare('
                SELECT pr.id, pr.user_id 
                FROM password_resets pr
                WHERE pr.token_hash = :th AND pr.used_at IS NULL AND pr.expires_at > NOW()
                LIMIT 1
            ');
            $stmt->execute(['th' => $tokenHash]);
            $reset = $stmt->fetch();

            if (!$reset) {
                return ['success' => false, 'message' => 'This reset link is invalid or has expired.'];
            }

            $hash = password_hash($newPassword, PASSWORD_ARGON2ID);
            
            $pdo->beginTransaction();
            $upUser = $pdo->prepare('UPDATE users SET password_hash = :h, must_change_password = 0, failed_attempts = 0, locked_until = NULL WHERE id = :uid');
            $upUser->execute(['h' => $hash, 'uid' => $reset['user_id']]);

            $upToken = $pdo->prepare('UPDATE password_resets SET used_at = NOW() WHERE id = :id');
            $upToken->execute(['id' => $reset['id']]);
            $pdo->commit();

            return ['success' => true, 'message' => 'Password successfully updated. You may now sign in.'];
        } catch (Throwable $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Password reset execution error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Unable to reset password. Please try again later.'];
        }
    }
}
