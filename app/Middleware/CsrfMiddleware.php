<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Core\Csrf;
use App\Core\View;

class CsrfMiddleware
{
    public function handle(Request $request, Response $response): void
    {
        if ($request->isPost()) {
            $token = $request->input('_csrf');
            if (!Csrf::verify(is_string($token) ? $token : null)) {
                $response->setStatusCode(419);
                View::render('errors.500', [
                    'title' => 'Page Expired',
                    'message' => 'CSRF verification failed or session expired. Please refresh and try again.'
                ]);
                exit;
            }
        }
    }
}
