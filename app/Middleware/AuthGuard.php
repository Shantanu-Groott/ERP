<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Response;
use App\Core\Session;
use App\Core\View;

final class AuthGuard
{
    private const REALM_ROLES = [
        'staff'   => ['admin', 'teacher'],
        'student' => ['student'],
    ];

    private const PENDING_ALLOWED = ['/change-password', '/logout'];

    public static function roleMatchesRealm(string $role, string $realm): bool
    {
        return in_array($role, self::REALM_ROLES[$realm] ?? [], true);
    }

    public static function enforce(Response $response, array $roles = []): bool
    {
        if (!Session::has('user_id')) {
            $response->redirect('/login');
            return false;
        }

        $role  = (string)Session::get('user_role', '');
        $realm = (string)Session::get('user_realm', '');

        if (!self::roleMatchesRealm($role, $realm)) {
            Session::invalidate();
            Session::flash('error', 'Please sign in again.');
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

        if ($roles && !in_array($role, $roles, true)) {
            $response->setStatusCode(403);
            View::render('errors.403', [
                'title' => '403 Forbidden',
                'message' => 'You do not have permission to access this area.'
            ]);
            return false;
        }

        return true;
    }
}
