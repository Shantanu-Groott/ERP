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
use App\Core\Database;

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
        $activeLiveClass = null;

        $db = Database::getConnection();

        // Check if an active live class exists
        try {
            $stmtLive = $db->query("SELECT * FROM live_classes WHERE status = 'live' ORDER BY scheduled_at DESC LIMIT 1");
            $activeLiveClass = $stmtLive->fetch();
        } catch (\Throwable $e) {
            $activeLiveClass = null;
        }

        if ($student) {
            $attendanceStats = Attendance::getStudentStats($student['id']);
            $recentMarks = Mark::getByStudent($student['id']);
            $fees = Fee::getByStudent($student['id']);

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
            'activeLiveClass' => $activeLiveClass,
        ], 'student');
    }
}
