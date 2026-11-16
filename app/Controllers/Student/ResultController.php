<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Models\Mark;

class ResultController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        $marks = [];
        $totalObtained = 0;
        $totalMax = 0;

        if ($student) {
            $marks = Mark::getByStudent($student['id']);
            foreach ($marks as $m) {
                $totalObtained += (float)$m['marks_obtained'];
                $totalMax += (float)($m['max_marks'] ?? $m['total_marks'] ?? 100);
            }
        }

        $overallPercentage = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 2) : 0;

        View::render('student.results', [
            'title' => 'My Examination Results',
            'student' => $student,
            'marks' => $marks,
            'totalObtained' => $totalObtained,
            'totalMax' => $totalMax,
            'overallPercentage' => $overallPercentage,
        ], 'student');
    }
}
