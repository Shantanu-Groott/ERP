<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Core\Database;

class LiveClassController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        $db = Database::getConnection();

        // Active / Live Session
        $stmtLive = $db->query("
            SELECT lc.*, s.name as subject_name, s.code as subject_code
            FROM live_classes lc
            LEFT JOIN subjects s ON lc.subject_id = s.id
            WHERE lc.status = 'live'
            ORDER BY lc.scheduled_at DESC
            LIMIT 1
        ");
        $activeSession = $stmtLive->fetch();

        // Upcoming Sessions
        $stmtUpcoming = $db->query("
            SELECT lc.*, s.name as subject_name, s.code as subject_code
            FROM live_classes lc
            LEFT JOIN subjects s ON lc.subject_id = s.id
            WHERE lc.status = 'scheduled'
            ORDER BY lc.scheduled_at ASC
        ");
        $upcomingSessions = $stmtUpcoming->fetchAll();

        // Completed / Past Sessions
        $stmtPast = $db->query("
            SELECT lc.*, s.name as subject_name, s.code as subject_code
            FROM live_classes lc
            LEFT JOIN subjects s ON lc.subject_id = s.id
            WHERE lc.status = 'completed'
            ORDER BY lc.scheduled_at DESC
        ");
        $pastSessions = $stmtPast->fetchAll();

        View::render('student.live_class', [
            'title' => 'Live Class Dashboard & Join Portal',
            'student' => $student,
            'activeSession' => $activeSession,
            'upcomingSessions' => $upcomingSessions,
            'pastSessions' => $pastSessions,
        ], 'student');
    }
}
