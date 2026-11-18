<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Core\SecurityHeaders;
use App\Core\Session;
use App\Core\View;
use App\Services\AuthService;
use App\Services\PasswordResetService;

final class AuthController
{
    public function showLogin(Request $request, Response $response): void
    {
        if (Session::has('user_id')) {
            $this->toDashboard($response);
            return;
        }
        $this->render('login');
    }

    public function login(Request $request, Response $response): void
    {
        if (!$this->requirePost($request)) {
            return;
        }

        if (!Csrf::verify($request->input('_csrf'))) {
            $this->back($response, '/login', 'error', 'Your session expired. Please try again.');
            return;
        }

        $identifier = $this->field($request, 'identifier');
        $password   = $this->field($request, 'password', false);

        if ($identifier === '' && $password === '') {
            $this->back($response, '/login', 'error', 'Please enter your username or email and your password.');
            return;
        }

        if ($identifier === '') {
            $this->back($response, '/login', 'error', 'Please enter your username or email address.');
            return;
        }

        if ($password === '') {
            Session::flash('identifier', $identifier);
            $this->back($response, '/login', 'error', 'Please enter your password.');
            return;
        }

        if (mb_strlen($identifier) > 190 || strlen($password) > 1024) {
            $this->back($response, '/login', 'error', 'Input exceeds maximum allowed length.');
            return;
        }

        $result = AuthService::attempt(null, $identifier, $password, self::clientIp());

        if (!$result['success']) {
            Session::flash('identifier', $identifier);
            $this->back($response, '/login', 'error', $result['message']);
            return;
        }

        $this->toDashboard($response);
    }

    public function logout(Request $request, Response $response): void
    {
        if (!$this->requirePost($request)) {
            return;
        }

        if (!Csrf::verify($request->input('_csrf'))) {
            $this->back($response, '/login', 'error', 'Invalid or expired CSRF token.');
            return;
        }

        AuthService::logout(self::clientIp());
        $this->back($response, '/login', 'success', 'You have been signed out.');
    }

    public function forgotPassword(Request $request, Response $response): void
    {
        if (!$request->isPost()) {
            $this->render('forgot');
            return;
        }

        if (!Csrf::verify($request->input('_csrf'))) {
            $this->back($response, '/forgot-password', 'error', 'Your session expired. Please try again.');
            return;
        }

        $identifier = $this->field($request, 'identifier');
        if ($identifier !== '' && mb_strlen($identifier) <= 190) {
            PasswordResetService::request('student', $identifier, self::clientIp());
        }

        $this->back($response, '/login', 'success', 'If the account exists, recovery instructions have been sent.');
    }

    public function showReset(Request $request, Response $response): void
    {
        $token = $this->field($request, 'token');
        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            $this->back($response, '/login', 'error', 'This reset link is invalid or has expired.');
            return;
        }
        $this->render('reset', ['token' => $token]);
    }

    public function reset(Request $request, Response $response): void
    {
        if (!$this->requirePost($request)) {
            return;
        }

        $token = $this->field($request, 'token');
        $retry = '/reset-password?token=' . rawurlencode($token);

        if (!Csrf::verify($request->input('_csrf'))) {
            $this->back($response, '/login', 'error', 'Your session expired. Please request a new link.');
            return;
        }

        $password = $this->field($request, 'password', false);
        $confirm  = $this->field($request, 'password_confirm', false);

        if (!hash_equals($password, $confirm)) {
            $this->back($response, $retry, 'error', 'The two passwords do not match.');
            return;
        }

        $result = PasswordResetService::reset('student', $token, $password);
        $this->back(
            $response,
            $result['success'] ? '/login' : $retry,
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }

    private function render(string $mode, array $extra = []): void
    {
        View::render('auth.login', array_merge([
            'title'      => 'Student Sign In - Kalavanta Edutech ERP',
            'mode'       => $mode,
            'error'      => Session::getFlash('error'),
            'success'    => Session::getFlash('success'),
            'identifier' => Session::getFlash('identifier', ''),
            'csrf'       => Csrf::token(),
            'nonce'      => SecurityHeaders::nonce(),
            'token'      => '',
        ], $extra), 'auth');
    }

    private function back(Response $response, string $to, string $type, string $message): void
    {
        Session::flash($type, $message);
        $response->redirect($to);
    }

    private function toDashboard(Response $response): void
    {
        if (Session::get('_must_change') === true) {
            $response->redirect('/change-password');
            return;
        }

        $response->redirect('/student/dashboard');
    }

    private function requirePost(Request $request): bool
    {
        if ($request->isPost()) {
            return true;
        }
        http_response_code(405);
        header('Allow: POST');
        return false;
    }

    private function field(Request $request, string $key, bool $trim = true): string
    {
        $v = $request->input($key, '');
        if (!is_string($v)) {
            return '';
        }
        return $trim ? trim($v) : $v;
    }

    private static function clientIp(): string
    {
        $peer    = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $trusted = array_filter(array_map('trim', explode(',', (string)getenv('TRUSTED_PROXIES'))));

        if (!$trusted || !in_array($peer, $trusted, true) || empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $peer;
        }

        $chain = array_map('trim', explode(',', (string)$_SERVER['HTTP_X_FORWARDED_FOR']));
        foreach (array_reverse($chain) as $hop) {
            if (!filter_var($hop, FILTER_VALIDATE_IP)) {
                return $peer;
            }
            if (!in_array($hop, $trusted, true)) {
                return $hop;
            }
        }
        return $peer;
    }
}
