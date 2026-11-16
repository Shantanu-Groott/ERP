<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Core\Database;

class NoticeController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        $db = Database::getConnection();
        
        // Fetch announcements for audience 'all' or 'students'
        $stmt = $db->query("
            SELECT a.*, u.full_name as author_name
            FROM announcements a
            JOIN users u ON a.author_id = u.id
            WHERE a.audience IN ('all', 'students')
            ORDER BY a.created_at DESC
        ");
        $notices = $stmt->fetchAll();

        View::render('student.notices', [
            'title' => 'Institute Notices & Bulletins',
            'student' => $student,
            'notices' => $notices,
        ], 'student');
    }
}
