<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Models\Attendance;

class AttendanceController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        $records = [];
        $stats = ['total' => 0, 'present' => 0, 'absent' => 0, 'late' => 0, 'percentage' => 0];
        $filter = $request->input('filter', 'all');

        if ($student) {
            $allRecords = Attendance::getByStudent($student['id']);
            $stats = Attendance::getStudentStats($student['id']);

            if ($filter !== 'all') {
                $records = array_values(array_filter($allRecords, fn($r) => ($r['status'] ?? '') === $filter));
            } else {
                $records = $allRecords;
            }
        }

        View::render('student.attendance', [
            'title' => 'Attendance - Kalavanta Edutech',
            'headerTitle' => 'Attendance',
            'headerSubtitle' => 'Track your daily class attendance and session archives',
            'headerIcon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
            'searchPlaceholder' => 'Search sessions, classes...',
            'student' => $student,
            'records' => $records,
            'allRecords' => $allRecords ?? [],
            'stats' => $stats,
            'filter' => $filter,
        ], 'student');
    }
}
