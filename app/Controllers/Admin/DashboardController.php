<?php

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\Fee;
use App\Services\AuditService;

class DashboardController
{
    public function index(Request $request, Response $response): void
    {
        $stats = [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_classes' => ClassRoom::count(),
            'total_revenue' => Fee::getTotalRevenue(),
        ];

        $recentAudits = AuditService::getRecent(8);

        View::render('admin.dashboard', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'audits' => $recentAudits,
        ], 'admin');
    }
}
