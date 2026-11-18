<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;

class CertificateController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);
        if (!$student) {
            $student = Student::findById(1);
        }

        // Certificates dataset matching mockup media_1794998380763_f6d448b2.jpg
        $certificates = [
            [
                'id' => 1,
                'title' => 'Course Completion Certificate',
                'description' => 'For successfully completing the Cyber Security course',
                'category' => 'course',
                'category_label' => 'Course Completion',
                'issued_on' => 'Apr 20, 2025',
                'cert_code' => 'KLVT-CS-2025-891',
                'icon_color' => '#2d6a4f',
                'icon_bg' => '#fbf8f0',
                'border_color' => '#f2ede0',
            ],
            [
                'id' => 2,
                'title' => 'Event Participation Certificate',
                'description' => 'For participating in Tech Fest 2025',
                'category' => 'event',
                'category_label' => 'Event Participation',
                'issued_on' => 'Mar 15, 2025',
                'cert_code' => 'KLVT-EVT-2025-442',
                'icon_color' => '#7c3aed',
                'icon_bg' => '#f4f0ff',
                'border_color' => '#ebe5fc',
            ],
            [
                'id' => 3,
                'title' => 'Lab Completion Certificate',
                'description' => 'For completing the Network Security Lab',
                'category' => 'others',
                'category_label' => 'Others',
                'issued_on' => 'Feb 10, 2025',
                'cert_code' => 'KLVT-LAB-2025-108',
                'icon_color' => '#2d6a4f',
                'icon_bg' => '#eaf5ee',
                'border_color' => '#dbe8dd',
            ],
            [
                'id' => 4,
                'title' => 'Ethical Hacking & Penetration Testing',
                'description' => 'For successful completion of advanced vulnerability analysis & lab practicums',
                'category' => 'course',
                'category_label' => 'Course Completion',
                'issued_on' => 'Jan 25, 2025',
                'cert_code' => 'KLVT-EH-2025-302',
                'icon_color' => '#2d6a4f',
                'icon_bg' => '#fbf8f0',
                'border_color' => '#f2ede0',
            ],
            [
                'id' => 5,
                'title' => 'Annual Inter-College Hackathon Finalist',
                'description' => 'For outstanding performance in Cloud Security Architecture Track',
                'category' => 'event',
                'category_label' => 'Event Participation',
                'issued_on' => 'Nov 15, 2026',
                'cert_code' => 'KLVT-HCK-2026-077',
                'icon_color' => '#7c3aed',
                'icon_bg' => '#f4f0ff',
                'border_color' => '#ebe5fc',
            ],
            [
                'id' => 6,
                'title' => 'Database Management Systems Practical Mastery',
                'description' => 'For completing relational design, SQL indexing, and database administration evaluations',
                'category' => 'others',
                'category_label' => 'Others',
                'issued_on' => 'Dec 20, 2024',
                'cert_code' => 'KLVT-DBS-2024-512',
                'icon_color' => '#2d6a4f',
                'icon_bg' => '#eaf5ee',
                'border_color' => '#dbe8dd',
            ],
        ];

        View::render('student.certificate', [
            'title' => 'Certificates - Kalavanta Edutech',
            'headerTitle' => 'Certificates',
            'headerSubtitle' => 'View, verify, and download your earned academic and event credentials',
            'headerIcon' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
            'searchPlaceholder' => 'Search certificates...',
            'student' => $student,
            'certificates' => $certificates,
        ], 'student');
    }
}
