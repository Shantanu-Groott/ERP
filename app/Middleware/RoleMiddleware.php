<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;

class RoleMiddleware
{
    private array $allowedRoles;

    public function __construct(array|string $roles = [])
    {
        $this->allowedRoles = is_array($roles) ? $roles : func_get_args();
    }

    public function handle(Request $request, Response $response): void
    {
        if (!AuthGuard::enforce($response, $this->allowedRoles)) {
            exit;
        }
    }
}
