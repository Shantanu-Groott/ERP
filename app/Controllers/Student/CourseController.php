<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Core\Database;

class CourseController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        $db = Database::getConnection();
        $subjects = [];

        if ($student) {
            $stmt = $db->query("
                SELECT s.*, d.name as department_name, d.code as department_code
                FROM subjects s
                JOIN departments d ON s.department_id = d.id
                ORDER BY s.code ASC
            ");
            $subjects = $stmt->fetchAll();
        }

        View::render('student.curriculum', [
            'title' => 'Curriculum & Course Syllabi',
            'student' => $student,
            'subjects' => $subjects,
        ], 'student');
    }
}
