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
                $records = array_filter($allRecords, fn($r) => ($r['status'] ?? '') === $filter);
            } else {
                $records = $allRecords;
            }
        }

        View::render('student.attendance', [
            'title' => 'Class Attendance & Session Archives',
            'student' => $student,
            'records' => $records,
            'stats' => $stats,
            'filter' => $filter,
        ], 'student');
    }
}
