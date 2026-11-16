<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;

class LiveClassController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        View::render('student.live_class', [
            'title' => 'Interactive Virtual Lab & Sandbox Classroom',
            'student' => $student,
        ], 'student');
    }
}
