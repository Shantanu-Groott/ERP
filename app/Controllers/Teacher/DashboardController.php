<?php

namespace App\Controllers\Teacher;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\Subject;

class DashboardController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $teacher = Teacher::findByUserId($userId);
        $classes = ClassRoom::all();
        $subjects = Subject::all();

        View::render('teacher.dashboard', [
            'title' => 'Teacher Dashboard',
            'teacher' => $teacher,
            'classes' => $classes,
            'subjects' => $subjects,
        ], 'teacher');
    }
}
