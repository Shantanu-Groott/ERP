<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Mark;

class CertificateController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        $attendanceStats = ['total' => 0, 'present' => 0, 'percentage' => 0];
        $marks = [];
        $totalObtained = 0;
        $totalMax = 0;

        if ($student) {
            $attendanceStats = Attendance::getStudentStats($student['id']);
            $marks = Mark::getByStudent($student['id']);
            foreach ($marks as $m) {
                $totalObtained += (float)$m['marks_obtained'];
                $totalMax += (float)($m['max_marks'] ?? $m['total_marks'] ?? 100);
            }
        }

        $overallPct = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 1) : 0;

        View::render('student.certificate', [
            'title' => 'Official Academic Certificate & Credentials',
            'student' => $student,
            'attendanceStats' => $attendanceStats,
            'overallPercentage' => $overallPct,
            'examCount' => count($marks),
        ], 'student');
    }
}
