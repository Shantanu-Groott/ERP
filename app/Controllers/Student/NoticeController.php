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
        if (!$student) {
            $student = Student::findById(1);
        }

        $db = Database::getConnection();
        
        // Fetch announcements for audience 'all' or 'students'
        $stmt = $db->query("
            SELECT a.*, u.full_name as author_name
            FROM announcements a
            LEFT JOIN users u ON a.author_id = u.id
            WHERE a.audience IN ('all', 'students')
            ORDER BY a.created_at DESC
        ");
        $rawNotices = $stmt->fetchAll();

        $notices = [];
        foreach ($rawNotices as $n) {
            $titleLower = strtolower($n['title']);
            
            // Clean simple categorization
            if (strpos($titleLower, 'exam') !== false || strpos($titleLower, 'hall ticket') !== false || strpos($titleLower, 'assessment') !== false) {
                $category = 'exam';
                $categoryLabel = 'Examination';
                $badgeBg = '#eaf5ee';
                $badgeColor = '#1c4b32';
                $isUrgent = true;
            } elseif (strpos($titleLower, 'hackathon') !== false || strpos($titleLower, 'internship') !== false || strpos($titleLower, 'recruitment') !== false) {
                $category = 'event';
                $categoryLabel = 'Event & Career';
                $badgeBg = '#f3e8ff';
                $badgeColor = '#6b21a8';
                $isUrgent = false;
            } elseif (strpos($titleLower, 'maintenance') !== false || strpos($titleLower, 'sandbox') !== false) {
                $category = 'system';
                $categoryLabel = 'System';
                $badgeBg = '#fef3c7';
                $badgeColor = '#92400e';
                $isUrgent = false;
            } else {
                $category = 'academic';
                $categoryLabel = 'Academic';
                $badgeBg = '#e0f2fe';
                $badgeColor = '#0369a1';
                $isUrgent = (strpos($titleLower, 'review') !== false || strpos($titleLower, 'guidelines') !== false);
            }

            $dateTs = !empty($n['created_at']) ? strtotime($n['created_at']) : time();

            $notices[] = [
                'id' => $n['id'],
                'title' => $n['title'],
                'body' => $n['body'],
                'created_at' => $n['created_at'],
                'formatted_date' => date('M d, Y', $dateTs),
                'month' => strtoupper(date('M', $dateTs)),
                'day' => date('d', $dateTs),
                'author_name' => $n['author_name'] ?? 'Administration',
                'category' => $category,
                'category_label' => $categoryLabel,
                'badge_bg' => $badgeBg,
                'badge_color' => $badgeColor,
                'is_urgent' => $isUrgent,
            ];
        }

        View::render('student.notices', [
            'title' => 'Notices - Kalavanta Edutech',
            'headerTitle' => 'Notices',
            'headerSubtitle' => 'Important campus announcements and academic notices',
            'headerIcon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
            'searchPlaceholder' => 'Search notices...',
            'student' => $student,
            'notices' => $notices,
        ], 'student');
    }
}
