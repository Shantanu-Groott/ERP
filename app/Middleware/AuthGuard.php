<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Response;
use App\Core\Session;

final class AuthGuard
{
    private const PENDING_ALLOWED = ['/change-password', '/logout'];

    public static function enforce(Response $response): bool
    {
        if (!Session::has('user_id')) {
            $response->redirect('/login');
            return false;
        }

        if (Session::get('_must_change') === true) {
            $path = (string)parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
            if (!in_array($path, self::PENDING_ALLOWED, true)) {
                $response->redirect('/change-password');
                return false;
            }
        }

        return true;
    }
}
