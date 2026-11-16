<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;

class CareerController
{
    public function openings(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        $search = trim((string)$request->input('q', ''));

        // Placement openings curated for Kalavanta Edutech students
        $allOpenings = [
            [
                'company_name' => 'Hostinger Cloud Systems',
                'title' => 'Associate DevOps & Infrastructure Engineer',
                'employment_type' => 'Full Time',
                'location' => 'Bengaluru / Remote',
                'course_codes' => 'CS301, CS302, COMP',
                'deadline' => 'Dec 30, 2026',
                'skills' => 'Linux, Docker, Kubernetes, CI/CD, Nginx',
                'description' => 'Deploying enterprise web workloads, managing high-availability database clusters, and hardening production containers.',
                'application_email' => 'careers@hostinger.com',
            ],
            [
                'company_name' => 'Kalavanta Technologies',
                'title' => 'Junior Full-Stack PHP & React Developer',
                'employment_type' => 'Graduate Trainee',
                'location' => 'Mumbai / Hybrid',
                'course_codes' => 'COMP, IT',
                'deadline' => 'Jan 15, 2027',
                'skills' => 'PHP 8, MySQL, REST APIs, Tailwind CSS, JavaScript',
                'description' => 'Building next-generation educational ERP systems, designing relational database models, and maintaining secure session lifecycles.',
                'application_email' => 'recruitment@kalavanta.edu',
            ],
            [
                'company_name' => 'CyberSec Defense Labs',
                'title' => 'Security Audit & Compliance Analyst',
                'employment_type' => 'Internship (6 Months)',
                'location' => 'Pune / Onsite',
                'course_codes' => 'COMP, CS302',
                'deadline' => 'Dec 20, 2026',
                'skills' => 'Network Forensics, OWASP Top 10, Wireshark, RBAC',
                'description' => 'Conducting automated security scanning, penetration testing against sandboxed clusters, and preparing ISO 27001 reports.',
                'application_email' => 'jobs@cyberseclabs.io',
            ]
        ];

        $openings = $allOpenings;
        if ($search !== '') {
            $needle = strtolower($search);
            $openings = array_filter($allOpenings, function($o) use ($needle) {
                return str_contains(strtolower($o['company_name'] . ' ' . $o['title'] . ' ' . $o['skills']), $needle);
            });
        }

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

        $allProjects = [
            [
                'company_name' => 'FinTrack Global',
                'title' => 'High-Throughput Payment Ledger & Reconciliation Engine',
                'project_type' => 'Capstone Industry Project',
                'location' => 'Remote Collaboration',
                'course_codes' => 'CS301, CS304',
                'engagement' => '12 Weeks (Mentored)',
                'skills' => 'MySQL 8, ACID Transactions, Microservices, REST',
                'description' => 'Design an idempotent payment processing module that reconciles batch bank statements with automated audit trails.',
                'contact_email' => 'capstone@fintrack.io',
            ],
            [
                'company_name' => 'Apex Cloud AI',
                'title' => 'Kubernetes Pod Security & RBAC Enforcement Suite',
                'project_type' => 'Industry Practical Lab',
                'location' => 'Hybrid Sandbox',
                'course_codes' => 'CS302, CS304',
                'engagement' => '8 Weeks (Lab Work)',
                'skills' => 'Kubernetes, YAML, CIS Benchmarks, RBAC',
                'description' => 'Implement admission controller webhooks and automate privilege escalation prevention on multi-tenant clusters.',
                'contact_email' => 'labs@apexcloud.ai',
            ]
        ];

        $projects = $allProjects;
        if ($search !== '') {
            $needle = strtolower($search);
            $projects = array_filter($allProjects, function($p) use ($needle) {
                return str_contains(strtolower($p['company_name'] . ' ' . $p['title'] . ' ' . $p['skills']), $needle);
            });
        }

        View::render('student.projects', [
            'title' => 'Industry Projects & Capstones',
            'student' => $student,
            'projects' => $projects,
            'search' => $search,
        ], 'student');
    }
}
