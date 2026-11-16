<?php
declare(strict_types=1);

namespace App\Core;

final class Session
{
    private const IDLE_TTL     = 1800;    // 30 min of inactivity
    private const ABSOLUTE_TTL = 28800;   // 8 h hard limit, even if active

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        // __Host- prefix needs HTTPS; only relax it for local development
        $secure = getenv('APP_ENV') !== 'local';

        ini_set('session.use_strict_mode', '1');      // reject unknown session IDs
        ini_set('session.use_only_cookies', '1');
        ini_set('session.use_trans_sid', '0');
        ini_set('session.sid_length', '48');
        ini_set('session.sid_bits_per_character', '6');

        $path = dirname(__DIR__, 2) . '/storage/sessions';
        if (is_dir($path) && is_writable($path)) {
            session_save_path($path);                 // keep out of shared /tmp (chmod 0700)
        }

        session_name($secure ? '__Host-erp_sid' : 'erp_sid');
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Strict',
        ]);

        session_start();
        self::enforceLifetime();
    }

    private static function enforceLifetime(): void
    {
        $now = time();
        $ua  = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');

        if (isset($_SESSION['_created'])) {
            $expired = ($now - (int)$_SESSION['_created'] > self::ABSOLUTE_TTL)
                || ($now - (int)($_SESSION['_seen'] ?? $now) > self::IDLE_TTL)
                || !hash_equals((string)($_SESSION['_ua'] ?? ''), $ua);

            if ($expired) {
                self::invalidate();
            }
        }

        if (!isset($_SESSION['_created'])) {
            $_SESSION['_created'] = $now;
            $_SESSION['_ua']      = $ua;
        }
        $_SESSION['_seen'] = $now;
    }

    /** Called after successful authentication: new ID (anti-fixation) + new CSRF token. */
    public static function login(int $userId, mixed $arg2 = false, mixed $arg3 = null, bool $mustChange = false): void
    {
        session_regenerate_id(true);
        $mustChangeVal = is_bool($arg2) ? $arg2 : (is_bool($arg3) ? $arg3 : $mustChange);
        $_SESSION['_must_change'] = $mustChangeVal;
        $_SESSION['user_id']      = $userId;
        $_SESSION['_created']     = time();
        $_SESSION['_seen']        = time();
        $_SESSION['_csrf']        = bin2hex(random_bytes(32));
    }

    /** Destroys the session and immediately starts a clean one (so flash messages still work). */
    public static function invalidate(): void
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires'  => time() - 42000,
                'path'     => $p['path'],
                'secure'   => $p['secure'],
                'httponly' => true,
                'samesite' => $p['samesite'],
            ]);
            session_destroy();
        }
        session_start();
        session_regenerate_id(true);
        $_SESSION['_created'] = time();
        $_SESSION['_seen']    = time();
        $_SESSION['_ua']      = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function flash(string $key, mixed $value = null): mixed
    {
        if ($value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return null;
        }
        return self::getFlash($key);
    }

    public static function getFlash(string $key, mixed $default = null): mixed
    {
        $val = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);
        return $val;
    }

    public static function token(): string
    {
        return Csrf::token();
    }

    public static function regenerateToken(): string
    {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        return $_SESSION['_csrf'];
    }

    public static function destroy(): void
    {
        self::invalidate();
    }
}
