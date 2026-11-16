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

        if ($student && !empty($student['class_id'])) {
            // Get subjects assigned to this student's class
            $stmt = $db->prepare("
                SELECT s.*, d.name as department_name, d.code as department_code,
                       tu.full_name as instructor_name, t.designation as instructor_title
                FROM teaching_assignments ta
                JOIN subjects s ON ta.subject_id = s.id
                JOIN departments d ON s.department_id = d.id
                JOIN teachers t ON ta.teacher_id = t.id
                JOIN users tu ON t.user_id = tu.id
                WHERE ta.class_id = :class_id
                ORDER BY s.code ASC
            ");
            $stmt->execute(['class_id' => $student['class_id']]);
            $subjects = $stmt->fetchAll();
        }

        View::render('student.curriculum', [
            'title' => 'Curriculum & Course Syllabi',
            'student' => $student,
            'subjects' => $subjects,
        ], 'student');
    }
}
