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

        if ($search !== '') {
            $stmt = $db->prepare("
                SELECT * FROM job_openings 
                WHERE status = 'active' 
                  AND (company_name LIKE :s OR title LIKE :s OR skills LIKE :s OR description LIKE :s)
                ORDER BY id DESC
            ");
            $stmt->execute(['s' => '%' . $search . '%']);
        } else {
            $stmt = $db->query("SELECT * FROM job_openings WHERE status = 'active' ORDER BY id DESC");
        }
        $openings = $stmt->fetchAll();

        View::render('student.openings', [
            'title' => 'Placement Desk & Career Openings',
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
