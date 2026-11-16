<?php
declare(strict_types=1);

namespace App\Core;

final class Csrf
{
    public static function token(): string
    {
        Session::start();
        $token = Session::get('_csrf');
        if (!$token || !is_string($token)) {
            $token = bin2hex(random_bytes(32));
            Session::set('_csrf', $token);
        }
        return $token;
    }

    public static function field(): string
    {
        $token = self::token();
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function verify(?string $token): bool
    {
        Session::start();
        $sessionToken = Session::get('_csrf');
        if (!is_string($sessionToken) || !is_string($token) || $token === '') {
            return false;
        }
        return hash_equals($sessionToken, $token);
    }
}
