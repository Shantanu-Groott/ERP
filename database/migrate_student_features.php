<?php
$config = require dirname(__DIR__) . '/config/database.php';
$pdo = new PDO(
    "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}",
    $config['username'],
    $config['password'],
    $config['options']
);

echo "Starting migration...\n";

// 1. Create job_openings
$pdo->exec("
CREATE TABLE IF NOT EXISTS job_openings (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    company_name VARCHAR(120) NOT NULL,
    title VARCHAR(150) NOT NULL,
    employment_type VARCHAR(60) NOT NULL DEFAULT 'Full Time',
    location VARCHAR(120) NOT NULL,
    course_codes VARCHAR(100) NULL,
    deadline VARCHAR(60) NOT NULL,
    skills TEXT NOT NULL,
    description TEXT NOT NULL,
    application_email VARCHAR(120) NOT NULL,
    status ENUM('active','closed') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
");
echo "Table job_openings ready.\n";

// 2. Create student_projects
$pdo->exec("
CREATE TABLE IF NOT EXISTS student_projects (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    company_name VARCHAR(120) NOT NULL,
    title VARCHAR(150) NOT NULL,
    project_type VARCHAR(80) NOT NULL DEFAULT 'Industry Practical Lab',
    location VARCHAR(120) NOT NULL,
    course_codes VARCHAR(100) NULL,
    engagement VARCHAR(60) NOT NULL,
    skills TEXT NOT NULL,
    description TEXT NOT NULL,
    contact_email VARCHAR(120) NOT NULL,
    status ENUM('open','in_progress','completed') NOT NULL DEFAULT 'open',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
");
echo "Table student_projects ready.\n";

// 3. Create live_classes
$pdo->exec("
CREATE TABLE IF NOT EXISTS live_classes (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(180) NOT NULL,
    subject_id INT UNSIGNED NULL,
    teacher_id INT UNSIGNED NULL,
    class_id INT UNSIGNED NULL,
    room_code VARCHAR(40) NOT NULL DEFAULT 'SEC-LAB-804',
    meeting_url VARCHAR(255) NOT NULL,
    scheduled_at DATETIME NOT NULL,
    duration_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 60,
    status ENUM('live','scheduled','completed') NOT NULL DEFAULT 'scheduled',
    presenter_name VARCHAR(120) NOT NULL DEFAULT 'Prof. Robert Miller',
    description TEXT NULL,
    prerequisites TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL
) ENGINE=InnoDB;
");
echo "Table live_classes ready.\n";

// 4. Seed job_openings if empty
$jobCount = $pdo->query("SELECT COUNT(*) FROM job_openings")->fetchColumn();
if ($jobCount == 0) {
    $stmt = $pdo->prepare("
        INSERT INTO job_openings (company_name, title, employment_type, location, course_codes, deadline, skills, description, application_email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $jobs = [
        [
            'Hostinger Cloud Systems',
            'Associate DevOps & Infrastructure Engineer',
            'Full Time',
            'Bengaluru / Remote',
            'CS301, CS302, CYB301',
            'Dec 30, 2026',
            'Linux, Docker, Kubernetes, CI/CD, Nginx',
            'Deploying enterprise web workloads, managing high-availability database clusters, and hardening production containers.',
            'careers@hostinger.com'
        ],
        [
            'Kalavanta Technologies',
            'Junior Full-Stack PHP & Cloud Developer',
            'Graduate Trainee',
            'Mumbai / Hybrid',
            'COMP, IT, CS304',
            'Jan 15, 2027',
            'PHP 8, MySQL, REST APIs, Tailwind CSS, JavaScript',
            'Building next-generation educational ERP systems, designing relational database models, and maintaining secure session lifecycles.',
            'recruitment@kalavanta.edu'
        ],
        [
            'CyberSec Defense Labs',
            'Security Audit & Penetration Testing Analyst',
            'Internship (6 Months)',
            'Pune / Onsite',
            'CYB301, CYB302',
            'Dec 20, 2026',
            'Network Forensics, OWASP Top 10, Wireshark, RBAC',
            'Conducting automated security scanning, penetration testing against sandboxed clusters, and preparing ISO 27001 reports.',
            'jobs@cyberseclabs.io'
        ],
        [
            'Fortress Cloud Security',
            'Junior SOC Analyst / Incident Responder',
            'Full Time',
            'Remote / India',
            'CYB304, CS302',
            'Jan 10, 2027',
            'SIEM (Splunk/ELK), Memory Forensics, Snort IDS, Threat Hunting',
            'Monitoring security telemetry, triaging suspicious incident tickets, and constructing defensive playbooks.',
            'careers@fortress-sec.io'
        ]
    ];
    foreach ($jobs as $j) {
        $stmt->execute($j);
    }
    echo "Seeded " . count($jobs) . " job openings.\n";
}

// 5. Seed student_projects if empty
$projCount = $pdo->query("SELECT COUNT(*) FROM student_projects")->fetchColumn();
if ($projCount == 0) {
    $stmt = $pdo->prepare("
        INSERT INTO student_projects (company_name, title, project_type, location, course_codes, engagement, skills, description, contact_email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $projects = [
        [
            'FinTrack Global',
            'High-Throughput Payment Ledger & Reconciliation Engine',
            'Capstone Industry Project',
            'Remote Collaboration',
            'CS301, CS304',
            '12 Weeks (Mentored)',
            'MySQL 8, ACID Transactions, Microservices, REST',
            'Design an idempotent payment processing module that reconciles batch bank statements with automated audit trails.',
            'capstone@fintrack.io'
        ],
        [
            'Apex Cloud AI',
            'Kubernetes Pod Security & RBAC Enforcement Suite',
            'Industry Practical Lab',
            'Hybrid Sandbox',
            'CS302, CYB301',
            '8 Weeks (Lab Work)',
            'Kubernetes, YAML, CIS Benchmarks, RBAC',
            'Implement admission controller webhooks and automate privilege escalation prevention on multi-tenant clusters.',
            'labs@apexcloud.ai'
        ],
        [
            'ZeroTrust Labs',
            'Automated PenTest Harness for Educational Portals',
            'Cybersecurity Capstone',
            'On-Campus Sandbox',
            'CYB302, CYB303',
            '10 Weeks (Team Project)',
            'Python, Metasploit, Nmap, Burp Suite, Cryptography',
            'Construct an offensive security testing pipeline that audits Web ERP authentication routines and reports session hijacking vectors.',
            'projects@zerotrustlabs.com'
        ]
    ];
    foreach ($projects as $p) {
        $stmt->execute($p);
    }
    echo "Seeded " . count($projects) . " student projects.\n";
}

// 6. Seed live_classes if empty
$liveCount = $pdo->query("SELECT COUNT(*) FROM live_classes")->fetchColumn();
if ($liveCount == 0) {
    $stmt = $pdo->prepare("
        INSERT INTO live_classes (title, subject_id, teacher_id, class_id, room_code, meeting_url, scheduled_at, duration_minutes, status, presenter_name, description, prerequisites)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $classes = [
        [
            'Network Defense Essentials: Live IDS & Packet Forensics Lab',
            2,
            1,
            1,
            'SEC-DEF-801',
            'https://meet.google.com/kalavanta-cyber-defense',
            date('Y-m-d H:i:s', strtotime('-15 minutes')),
            90,
            'live',
            'Prof. Robert Miller',
            'Hands-on walkthrough of Snort IDS rule crafting, TCP session reconstruction in Wireshark, and firewall hardening against SYN floods.',
            'Wireshark installed, VirtualBox / Docker with Ubuntu 22.04 LTS sandbox.'
        ],
        [
            'Ethical Hacking: Vulnerability Scanning & Exploit Payloads',
            2,
            1,
            1,
            'PEN-LAB-402',
            'https://meet.google.com/kalavanta-pentest-session',
            date('Y-m-d H:i:s', strtotime('+2 hours')),
            60,
            'scheduled',
            'Prof. Robert Miller',
            'Analyzing CVE-2024 exploit chains, reconnaissance with Nmap, and constructing sandboxed Metasploit handlers.',
            'Kali Linux virtual machine or WSL2 environment with Python 3.'
        ],
        [
            'Database Query Optimization & Transaction Audit Lab',
            1,
            1,
            1,
            'DB-OPT-301',
            'https://meet.google.com/kalavanta-dbms-audit',
            date('Y-m-d H:i:s', strtotime('+1 day 10:00:00')),
            75,
            'scheduled',
            'Prof. Robert Miller',
            'Deep dive into EXPLAIN ANALYZE, composite B-Tree indexing, deadlock resolution in InnoDB, and audit logs.',
            'MySQL 8 client installed, ERP demo database imported.'
        ],
        [
            'Incident Response & Memory Forensics Masterclass',
            2,
            1,
            1,
            'IR-FOR-505',
            'https://meet.google.com/kalavanta-forensics-live',
            date('Y-m-d H:i:s', strtotime('-2 days 14:00:00')),
            60,
            'completed',
            'Prof. Robert Miller',
            'Volatile memory triage using Volatility 3, recovering process injection artifacts, and constructing MITRE ATT&CK timelines.',
            'Completed session recording and lab notes available in archive.'
        ]
    ];
    foreach ($classes as $c) {
        $stmt->execute($c);
    }
    echo "Seeded " . count($classes) . " live classes.\n";
}

// 7. Add Cybersecurity subjects if missing
$existingCodes = $pdo->query("SELECT code FROM subjects")->fetchAll(PDO::FETCH_COLUMN);
$newSubjects = [
    ['CYB301', 'Network Defense Essentials', 4],
    ['CYB302', 'Ethical Hacking & Penetration Testing', 4],
    ['CYB303', 'Cryptographic & Data Security', 3],
    ['CYB304', 'Incident Response & Digital Forensics', 3]
];
$stmtSub = $pdo->prepare("INSERT INTO subjects (department_id, code, name, credits) VALUES (1, ?, ?, ?)");
$stmtAssign = $pdo->prepare("INSERT IGNORE INTO teaching_assignments (teacher_id, class_id, subject_id) VALUES (1, 1, ?)");

foreach ($newSubjects as $ns) {
    if (!in_array($ns[0], $existingCodes)) {
        $stmtSub->execute([$ns[0], $ns[1], $ns[2]]);
        $subId = $pdo->lastInsertId();
        $stmtAssign->execute([$subId]);
        echo "Added subject {$ns[0]}: {$ns[1]}\n";
    }
}

// Assign subjects 3 and 4 to Class 1 as well
$pdo->exec("INSERT IGNORE INTO teaching_assignments (teacher_id, class_id, subject_id) VALUES (1, 1, 3), (1, 1, 4)");

// 8. Add rich attendance records for Shantanu (student_id = 1)
$attCount = $pdo->query("SELECT COUNT(*) FROM attendance WHERE student_id = 1")->fetchColumn();
if ($attCount < 10) {
    $dates = [
        ['2026-11-03', 'present', 1],
        ['2026-11-04', 'present', 2],
        ['2026-11-05', 'present', 1],
        ['2026-11-06', 'present', 2],
        ['2026-11-07', 'late', 1],
        ['2026-11-10', 'present', 2],
        ['2026-11-11', 'present', 1],
        ['2026-11-12', 'present', 2],
        ['2026-11-13', 'present', 1],
        ['2026-11-14', 'excused', 2],
        ['2026-11-15', 'present', 1],
        ['2026-11-16', 'present', 2],
    ];
    $stmtAtt = $pdo->prepare("INSERT IGNORE INTO attendance (student_id, assignment_id, date, status, marked_by) VALUES (1, ?, ?, ?, 2)");
    foreach ($dates as $d) {
        $stmtAtt->execute([$d[2], $d[0], $d[1]]);
    }
    echo "Added attendance records.\n";
}

// 9. Add exam marks for student 1 (Shantanu)
$marksCount = $pdo->query("SELECT COUNT(*) FROM marks WHERE student_id = 1")->fetchColumn();
if ($marksCount < 4) {
    // Check if practical exam exists
    $pracExam = $pdo->query("SELECT id FROM exams WHERE name = 'Midterm Practical Exam'")->fetchColumn();
    if (!$pracExam) {
        $pdo->exec("INSERT INTO exams (class_id, name, exam_date) VALUES (1, 'Midterm Practical Exam', '2026-10-15')");
        $pracExam = $pdo->lastInsertId();
    }
    
    // Add marks
    $marksData = [
        [1, 1, 1, 92.00, 100.00], // Midterm - DBMS
        [1, 1, 2, 88.50, 100.00], // Midterm - Computer Networks
        [$pracExam, 1, 1, 95.00, 100.00], // Practical - DBMS
        [$pracExam, 1, 2, 94.00, 100.00], // Practical - Networks
    ];
    $stmtM = $pdo->prepare("INSERT IGNORE INTO marks (exam_id, student_id, subject_id, marks_obtained, max_marks) VALUES (?, ?, ?, ?, ?)");
    foreach ($marksData as $md) {
        $stmtM->execute($md);
    }
    echo "Added exam marks for Shantanu.\n";
}

// 10. Add announcements
$annCount = $pdo->query("SELECT COUNT(*) FROM announcements")->fetchColumn();
if ($annCount < 3) {
    $pdo->exec("
        INSERT INTO announcements (author_id, audience, title, body, created_at) VALUES
        (1, 'all', 'Annual Inter-College Hackathon 2026 - Registration Open', 'Registrations are officially open for the Annual Kalavanta Hackathon. All Computer & Cybersecurity enrollees can form teams up to 4 members. Prizes include cloud credits and direct internship interviews.', NOW() - INTERVAL 1 DAY),
        (2, 'students', 'Cloud Sandbox Maintenance & Terminal Upgrade', 'The sandbox Kubernetes cluster will undergo a rolling kernel patch tonight from 01:00 AM to 02:00 AM IST. Virtual labs and terminal sandboxes will remain available with no downtime.', NOW() - INTERVAL 3 HOUR),
        (2, 'students', 'Final Project Review Guidelines & Documentation Format', 'All students must submit IEEE-format project synopsis along with GitHub repository link before the upcoming deadline. Review dates have been posted to your curriculum portal.', NOW() - INTERVAL 5 HOUR)
    ");
    echo "Added announcements.\n";
}

echo "Migration completed successfully!\n";
