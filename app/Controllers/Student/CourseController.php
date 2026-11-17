<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Core\Database;

class CourseController
{
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        $db = Database::getConnection();
        $subjects = [];

        if ($student) {
            $stmt = $db->query("
                SELECT s.*, d.name as department_name, d.code as department_code
                FROM subjects s
                JOIN departments d ON s.department_id = d.id
                ORDER BY s.code ASC
            ");
            $subjects = $stmt->fetchAll();
        }

        // Active Track - default to CYB302 (Ethical Hacking & Pen Testing)
        $track = trim((string)$request->input('track', 'CYB302'));
        
        $activeSubject = null;
        foreach ($subjects as $s) {
            if ($s['code'] === $track) {
                $activeSubject = $s;
                break;
            }
        }
        if (!$activeSubject) {
            // Find CYB302 or fallback to first
            foreach ($subjects as $s) {
                if ($s['code'] === 'CYB302') {
                    $activeSubject = $s;
                    break;
                }
            }
            if (!$activeSubject && !empty($subjects)) {
                $activeSubject = $subjects[0];
            }
        }

        $courseName = $activeSubject['name'] ?? 'Ethical Hacking & Pen Testing';
        if (($activeSubject['code'] ?? '') === 'CYB302') {
            $courseName = 'Ethical Hacking & Pen Testing';
        }

        // Curricula module definition mapped by course code
        $trackModules = [
            'CYB302' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Reconnaissance & OSINT',
                    'progress' => 100,
                    'image' => '/assets/img/curriculum-mod1.png',
                    'action_label' => 'Viewed',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '1.1', 'title' => 'Introduction to Active & Passive Recon', 'status' => 'completed'],
                        ['code' => '1.2', 'title' => 'Utilizing Shodan & Censys', 'status' => 'completed'],
                        ['code' => '1.3', 'title' => 'DNS & Subdomain Enumeration', 'status' => 'completed'],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: Network Scanning & Service Discovery',
                    'progress' => 75,
                    'image' => '/assets/img/curriculum-mod2.png',
                    'action_label' => 'Continue',
                    'action_url' => '/student/live-class',
                    'lessons' => [
                        ['code' => '2.1', 'title' => 'Understanding Packet Tracing & Flags', 'status' => 'completed'],
                        ['code' => '2.2', 'title' => 'Advanced Nmap Configs & NSE', 'status' => 'completed'],
                        ['code' => '2.3', 'title' => 'Active Directory Enumeration', 'status' => 'completed'],
                        ['code' => '2.4', 'title' => 'Lab: Scanning a Virtual Subnet', 'status' => 'in_progress'],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: Gaining Access & Exploitation',
                    'progress' => 40,
                    'image' => '/assets/img/curriculum-mod3.png',
                    'action_label' => 'Continue',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '3.1', 'title' => 'Vulnerability Assessment', 'status' => 'completed'],
                        ['code' => '3.2', 'title' => 'Intro to Metasploit', 'status' => 'completed'],
                        ['code' => '3.3', 'title' => 'System Exploitation', 'status' => 'not_started'],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: Post-Exploitation & Reporting',
                    'progress' => 10,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Start Module',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '4.1', 'title' => 'Privilege Escalation Basics', 'status' => 'completed'],
                        ['code' => '4.2', 'title' => 'Generating the Security Report', 'status' => 'not_started'],
                        ['code' => '4.3', 'title' => 'Practical Capstone Project', 'status' => 'not_started'],
                    ]
                ],
            ],
            'CYB301' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Defense-in-Depth Fundamentals',
                    'progress' => 100,
                    'image' => '/assets/img/course-network.png',
                    'action_label' => 'Viewed',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '1.1', 'title' => 'OSI Layer Hardening & Packet Inspection', 'status' => 'completed'],
                        ['code' => '1.2', 'title' => 'Stateful Firewall Rules & NAT Traversal', 'status' => 'completed'],
                        ['code' => '1.3', 'title' => 'Zero-Trust Network Architecture', 'status' => 'completed'],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: Snort IDS & Traffic Analysis',
                    'progress' => 80,
                    'image' => '/assets/img/curriculum-mod1.png',
                    'action_label' => 'Continue',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '2.1', 'title' => 'Writing Custom Snort Rule Signatures', 'status' => 'completed'],
                        ['code' => '2.2', 'title' => 'Analyzing PCAP Streams with Wireshark', 'status' => 'completed'],
                        ['code' => '2.3', 'title' => 'Lab: Real-Time SYN Flood Mitigation', 'status' => 'in_progress'],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: VPN Tunnels & Endpoint Security',
                    'progress' => 25,
                    'image' => '/assets/img/course-crypto.png',
                    'action_label' => 'Continue',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '3.1', 'title' => 'IPSec, WireGuard & OpenVPN Protocols', 'status' => 'completed'],
                        ['code' => '3.2', 'title' => 'Host-based IDS (OSSEC) Configuration', 'status' => 'not_started'],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: Perimeter Incident Readiness',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Start Module',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '4.1', 'title' => 'Automated Threat Intelligence Feeds', 'status' => 'not_started'],
                        ['code' => '4.2', 'title' => 'Defensive Runbooks & Tabletop Drills', 'status' => 'not_started'],
                    ]
                ],
            ],
            'CYB304' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Incident Triaging & Evidence Preservation',
                    'progress' => 100,
                    'image' => '/assets/img/course-incident.png',
                    'action_label' => 'Viewed',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '1.1', 'title' => 'NIST SP 800-61 Incident Lifecycle', 'status' => 'completed'],
                        ['code' => '1.2', 'title' => 'Forensic Chain of Custody & Image Hashing', 'status' => 'completed'],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: Live Memory & RAM Acquisition',
                    'progress' => 60,
                    'image' => '/assets/img/curriculum-mod2.png',
                    'action_label' => 'Continue',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '2.1', 'title' => 'Volatility 3 Process Triaging', 'status' => 'completed'],
                        ['code' => '2.2', 'title' => 'Detecting Injected DLLs and Hollowed Threads', 'status' => 'in_progress'],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: Disk & File System Analysis',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod3.png',
                    'action_label' => 'Start Module',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '3.1', 'title' => 'NTFS $MFT & USN Journal Carving', 'status' => 'not_started'],
                        ['code' => '3.2', 'title' => 'Linux /var/log & Syslog Telemetry Reconstruction', 'status' => 'not_started'],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: Threat Hunting & MITRE Mapping',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Start Module',
                    'action_url' => '#',
                    'lessons' => [
                        ['code' => '4.1', 'title' => 'Sigma Rules for SIEM Alerts', 'status' => 'not_started'],
                        ['code' => '4.2', 'title' => 'Constructing Root Cause Timelines', 'status' => 'not_started'],
                    ]
                ],
            ],
        ];

        // Default to CYB302 modules if track is not specifically mapped
        $modules = $trackModules[$activeSubject['code'] ?? 'CYB302'] ?? $trackModules['CYB302'];

        View::render('student.curriculum', [
            'title' => 'Curriculum: ' . $courseName,
            'headerTitle' => 'Curriculum: ' . $courseName,
            'searchPlaceholder' => 'Search your modules...',
            'student' => $student,
            'subjects' => $subjects,
            'activeSubject' => $activeSubject,
            'selectedTrack' => $activeSubject['code'] ?? 'CYB302',
            'modules' => $modules,
        ], 'student');
    }
}
