<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Mark;
use App\Models\Fee;

class DashboardController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        $attendanceStats = ['total' => 0, 'present' => 0, 'percentage' => 0];
        $recentMarks = [];
        $fees = [];
        $subjects = [];

        if ($student) {
            $attendanceStats = Attendance::getStudentStats($student['id']);
            $recentMarks = Mark::getByStudent($student['id']);
            $fees = Fee::getByStudent($student['id']);

            $db = \App\Core\Database::getConnection();
            $stmt = $db->prepare("
                SELECT s.*, tu.full_name as instructor_name, t.designation
                FROM teaching_assignments ta
                JOIN subjects s ON ta.subject_id = s.id
                JOIN teachers t ON ta.teacher_id = t.id
                JOIN users tu ON t.user_id = tu.id
                WHERE ta.class_id = :class_id
                ORDER BY s.code ASC
            ");
            $stmt->execute(['class_id' => $student['class_id']]);
            $subjects = $stmt->fetchAll();
        }

        View::render('student.dashboard', [
            'title' => 'Student Dashboard',
            'student' => $student,
            'attendanceStats' => $attendanceStats,
            'recentMarks' => $recentMarks,
            'fees' => $fees,
            'subjects' => $subjects,
        ], 'student');
    }
}
