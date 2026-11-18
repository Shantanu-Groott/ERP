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

        // Process notices with rich metadata (category, priority, reference number, read time, department)
        $notices = [];
        $counts = [
            'all' => count($rawNotices),
            'important' => 0,
            'exam' => 0,
            'career' => 0,
            'academic' => 0,
            'system' => 0,
        ];

        foreach ($rawNotices as $idx => $n) {
            $titleLower = strtolower($n['title']);
            $bodyLower = strtolower($n['body']);
            
            // Intelligent categorization
            if (strpos($titleLower, 'exam') !== false || strpos($titleLower, 'hall ticket') !== false || strpos($titleLower, 'assessment') !== false) {
                $category = 'exam';
                $categoryLabel = 'Examination';
                $badgeBg = '#eaf5ee';
                $badgeColor = '#1c4b32';
                $icon = 'exam';
                $priority = 'urgent';
            } elseif (strpos($titleLower, 'hackathon') !== false || strpos($titleLower, 'internship') !== false || strpos($titleLower, 'recruitment') !== false || strpos($titleLower, 'career') !== false) {
                $category = 'career';
                $categoryLabel = 'Career & Events';
                $badgeBg = '#f3e8ff';
                $badgeColor = '#6b21a8';
                $icon = 'briefcase';
                $priority = 'high';
            } elseif (strpos($titleLower, 'maintenance') !== false || strpos($titleLower, 'sandbox') !== false || strpos($titleLower, 'cluster') !== false || strpos($titleLower, 'terminal') !== false) {
                $category = 'system';
                $categoryLabel = 'Infrastructure';
                $badgeBg = '#fef3c7';
                $badgeColor = '#92400e';
                $icon = 'server';
                $priority = 'normal';
            } else {
                $category = 'academic';
                $categoryLabel = 'Academic & Syllabus';
                $badgeBg = '#e0f2fe';
                $badgeColor = '#0369a1';
                $icon = 'book';
                $priority = (strpos($titleLower, 'welcome') !== false) ? 'normal' : 'high';
            }

            if ($priority === 'urgent' || $priority === 'high') {
                $counts['important']++;
            }
            if (isset($counts[$category])) {
                $counts[$category]++;
            }

            // Word count / read time
            $wordCount = str_word_count(strip_tags($n['body']));
            $readTime = max(1, ceil($wordCount / 120)) . ' min read';

            // Circular reference number
            $refNo = 'KE-CIR-' . date('Y', strtotime($n['created_at'])) . '-' . str_pad((string)$n['id'], 3, '0', STR_PAD_LEFT);

            // Issuing department
            if ($category === 'exam') {
                $department = 'Office of the Controller of Examinations';
            } elseif ($category === 'career') {
                $department = 'Placement & Corporate Relations Cell';
            } elseif ($category === 'system') {
                $department = 'Cloud Systems & IT Infrastructure Wing';
            } else {
                $department = 'Dean of Academic Affairs';
            }

            $notices[] = [
                'id' => $n['id'],
                'ref_no' => $refNo,
                'title' => $n['title'],
                'body' => $n['body'],
                'created_at' => $n['created_at'],
                'formatted_date' => date('M d, Y', strtotime($n['created_at'])),
                'relative_date' => date('d M', strtotime($n['created_at'])),
                'author_name' => $n['author_name'] ?? 'Academic Secretariat',
                'department' => $department,
                'audience' => $n['audience'],
                'audience_label' => ($n['audience'] === 'all') ? 'Campus Wide' : 'Student Body (All Semesters)',
                'category' => $category,
                'category_label' => $categoryLabel,
                'badge_bg' => $badgeBg,
                'badge_color' => $badgeColor,
                'priority' => $priority,
                'priority_label' => ($priority === 'urgent') ? 'Urgent / Mandatory' : (($priority === 'high') ? 'High Priority' : 'General Circular'),
                'icon' => $icon,
                'read_time' => $readTime,
                'is_featured' => ($idx === 0),
            ];
        }

        View::render('student.notices', [
            'title' => 'Notices & Bulletins - Kalavanta Edutech',
            'headerTitle' => 'Notices & Bulletins',
            'headerSubtitle' => 'Official circulars, examination schedules, and institutional announcements',
            'headerIcon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
            'searchPlaceholder' => 'Search circulars, topics, keywords...',
            'student' => $student,
            'notices' => $notices,
            'counts' => $counts,
        ], 'student');
    }
}
