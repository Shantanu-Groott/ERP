<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Core\Database;

class CareerController
{
    public function openings(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);
        $search = trim((string)$request->input('q', ''));

        $db = Database::getConnection();

        $sql = "
            SELECT * FROM job_openings 
            WHERE status = 'active'
        ";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (company_name LIKE :s OR title LIKE :s OR skills LIKE :s OR description LIKE :s)";
            $params['s'] = '%' . $search . '%';
        }

        // Prioritize the 3 mockup cards: Cyber Security Intern, Tech Fest Volunteer, Full Stack Developer
        $sql .= "
            ORDER BY 
                CASE 
                    WHEN title LIKE '%Cyber Security Intern%' THEN 1
                    WHEN title LIKE '%Tech Fest Volunteer%' THEN 2
                    WHEN title LIKE '%Full Stack Developer (Fresher)%' THEN 3
                    ELSE 4
                END ASC,
                id DESC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $rawOpenings = $stmt->fetchAll();

        $openings = array_map(function ($op) {
            $titleLower = strtolower($op['title']);
            $typeLower = strtolower($op['employment_type']);

            if (str_contains($titleLower, 'volunteer') || str_contains($typeLower, 'part-time') || str_contains($typeLower, 'part time')) {
                $category = 'part-time';
                $roleLabel = str_contains($titleLower, 'volunteer') ? 'Volunteer' : 'Part-Time';
                $icon = 'users';
            } elseif (str_contains($titleLower, 'intern') || str_contains($typeLower, 'intern')) {
                $category = 'internship';
                $roleLabel = 'Internship';
                $icon = 'laptop';
            } else {
                $category = 'full-time';
                $roleLabel = 'Full-Time';
                $icon = 'desktop';
            }

            $op['category'] = $category;
            $op['role_label'] = $roleLabel;
            $op['icon_type'] = $icon;
            return $op;
        }, $rawOpenings);

        View::render('student.openings', [
            'title' => 'Openings - Kalavanta Edutech',
            'headerTitle' => 'Openings',
            'headerSubtitle' => 'Explore latest opportunities and apply',
            'headerIcon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>',
            'searchPlaceholder' => 'Search openings, companies, skills...',
            'student' => $student,
            'openings' => $openings,
            'search' => $search,
        ], 'student');
    }

    public function projects(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);
        $search = trim((string)$request->input('q', ''));

        $db = Database::getConnection();

        $sql = "SELECT * FROM student_projects WHERE status = 'open' OR status = 'in_progress'";
        $params = [];
        if ($search !== '') {
            $sql .= " AND (company_name LIKE :s OR title LIKE :s OR skills LIKE :s OR description LIKE :s)";
            $params['s'] = '%' . $search . '%';
        }
        $sql .= " ORDER BY id ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $rawProjects = $stmt->fetchAll();

        $projects = array_map(function ($pr) {
            $typeLower = strtolower($pr['project_type'] ?? '');
            $titleLower = strtolower($pr['title'] ?? '');

            if (str_contains($typeLower, 'cyber') || str_contains($titleLower, 'pentest') || str_contains($titleLower, 'security')) {
                $category = 'cybersecurity';
                $catLabel = 'Cybersecurity';
                $icon = 'shield';
            } elseif (str_contains($typeLower, 'cloud') || str_contains($titleLower, 'kubernetes') || str_contains($titleLower, 'devops') || str_contains($typeLower, 'practical')) {
                $category = 'cloud';
                $catLabel = 'Cloud & DevOps';
                $icon = 'cloud';
            } else {
                $category = 'capstone';
                $catLabel = 'Capstone';
                $icon = 'database';
            }

            $pr['category'] = $category;
            $pr['category_label'] = $catLabel;
            $pr['icon_type'] = $icon;
            return $pr;
        }, $rawProjects);

        View::render('student.projects', [
            'title' => 'Projects - Kalavanta Edutech',
            'headerTitle' => 'Projects',
            'headerSubtitle' => 'Explore industry capstones and sponsored lab projects',
            'headerIcon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/><line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="14" x2="15" y2="14"/></svg>',
            'searchPlaceholder' => 'Search projects, tech stack, sponsors...',
            'student' => $student,
            'projects' => $projects,
            'search' => $search,
        ], 'student');
    }
}
