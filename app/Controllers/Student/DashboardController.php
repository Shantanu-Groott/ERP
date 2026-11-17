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
        $notices = [];

        $db = Database::getConnection();

        // Check if an active live class exists
        try {
            $stmtLive = $db->query("SELECT * FROM live_classes WHERE status = 'live' ORDER BY scheduled_at DESC LIMIT 1");
            $activeLiveClass = $stmtLive->fetch();
        } catch (\Throwable $e) {
            $activeLiveClass = null;
        }

        // Fetch latest institutional announcements & bulletins
        try {
            $stmtNotices = $db->query("
                SELECT a.*, u.full_name as author_name
                FROM announcements a
                LEFT JOIN users u ON a.author_id = u.id
                WHERE a.audience IN ('all', 'students')
                ORDER BY a.created_at DESC
                LIMIT 4
            ");
            $notices = $stmtNotices->fetchAll();
        } catch (\Throwable $e) {
            $notices = [];
        }

        if ($student) {
            $attendanceStats = Attendance::getStudentStats($student['id']);
            $recentMarks = Mark::getByStudent($student['id']);
            $fees = Fee::getByStudent($student['id']);

            $stmt = $db->query("
                SELECT s.*, d.name as department_name, d.code as department_code
                FROM subjects s
                JOIN departments d ON s.department_id = d.id
                ORDER BY s.code ASC
            ");
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
            'notices' => $notices,
        ], 'student');
    }
}
