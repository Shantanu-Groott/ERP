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

        if ($search !== '') {
            $stmt = $db->prepare("
                SELECT * FROM student_projects 
                WHERE (company_name LIKE :s OR title LIKE :s OR skills LIKE :s OR description LIKE :s)
                ORDER BY id DESC
            ");
            $stmt->execute(['s' => '%' . $search . '%']);
        } else {
            $stmt = $db->query("SELECT * FROM student_projects ORDER BY id DESC");
        }
        $projects = $stmt->fetchAll();

        View::render('student.projects', [
            'title' => 'Industry Projects & Capstones',
            'student' => $student,
            'projects' => $projects,
            'search' => $search,
        ], 'student');
    }
}
