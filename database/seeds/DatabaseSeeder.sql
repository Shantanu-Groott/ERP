-- ====================================================
-- Kalavanta Edutech Student ERP Seeder
-- Student-Focused Seed Data
-- ====================================================

-- Academic Year
INSERT INTO academic_years (id, label, start_date, end_date, is_current) VALUES
(1, '2026-27', '2026-07-01', '2027-06-30', 1)
ON DUPLICATE KEY UPDATE is_current=VALUES(is_current);

-- Departments
INSERT INTO departments (id, name, code) VALUES
(1, 'Computer Engineering', 'COMP'),
(2, 'Information Technology', 'IT')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Classes
INSERT INTO classes (id, department_id, academic_year_id, name, division) VALUES
(1, 1, 1, 'TE Computer', 'A'),
(2, 1, 1, 'TE Computer', 'B'),
(3, 1, 1, 'BE Computer', 'A')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Subjects & Cybersecurity Tracks
INSERT INTO subjects (id, department_id, code, name, credits, instructor_name, instructor_title) VALUES
(1, 1, 'CS301', 'Database Management Systems', 4, 'Prof. Robert Miller', 'Lead Mentor & Faculty Lead'),
(2, 1, 'CS302', 'Computer Networks', 4, 'Prof. Robert Miller', 'Lead Mentor & Faculty Lead'),
(3, 1, 'CS303', 'Theory of Computation', 3, 'Prof. Robert Miller', 'Lead Mentor & Faculty Lead'),
(4, 1, 'CS304', 'Web Computing & ERP', 3, 'Prof. Robert Miller', 'Lead Mentor & Faculty Lead'),
(5, 1, 'CYB301', 'Network Defense Essentials', 4, 'Prof. Robert Miller', 'Lead Mentor - Cybersecurity'),
(6, 1, 'CYB302', 'Ethical Hacking & Penetration Testing', 4, 'Prof. Robert Miller', 'Lead Mentor - Cybersecurity'),
(7, 1, 'CYB303', 'Cryptographic & Data Security', 3, 'Prof. Robert Miller', 'Lead Mentor - Cybersecurity'),
(8, 1, 'CYB304', 'Incident Response & Digital Forensics', 3, 'Prof. Robert Miller', 'Lead Mentor - Cybersecurity')
ON DUPLICATE KEY UPDATE name=VALUES(name), instructor_name=VALUES(instructor_name);

-- Student User: Shantanu (password: admin123)
INSERT INTO users (id, email, username, password_hash, full_name, phone, status, must_change_password) VALUES
(3, 'shantanu@erp.local', 'shantanu', '$2y$10$Xk1feZIxXW8sRjAL/ZPyVuyyQTkN26tMPNbBHoIoRBryiU6kaIrSW', 'Shantanu', '+1 555-0102', 'active', 0)
ON DUPLICATE KEY UPDATE full_name=VALUES(full_name), password_hash=VALUES(password_hash);

-- Student Profile
INSERT INTO students (id, user_id, roll_no, class_id, dob, guardian_name, guardian_phone, admitted_on) VALUES
(1, 3, 'COMP-2026-001', 1, '2005-04-12', 'Mark Johnson', '+1 555-0999', '2024-08-01')
ON DUPLICATE KEY UPDATE roll_no=VALUES(roll_no);

-- Attendance Records
INSERT IGNORE INTO attendance (student_id, subject_id, date, status, remarks) VALUES
(1, 1, '2026-11-03', 'present', 'On-time lab presence'),
(1, 2, '2026-11-04', 'present', 'On-time lab presence'),
(1, 5, '2026-11-05', 'present', 'Network Defense practical'),
(1, 6, '2026-11-06', 'present', 'Penetration testing sandbox'),
(1, 1, '2026-11-07', 'late', 'Tardy 10 mins'),
(1, 2, '2026-11-10', 'present', 'Packet forensics completed'),
(1, 7, '2026-11-11', 'present', 'RSA cipher evaluation'),
(1, 8, '2026-11-12', 'present', 'Memory dump triage'),
(1, 5, '2026-11-13', 'present', 'Firewall rules audited'),
(1, 6, '2026-11-14', 'excused', 'Campus Hackathon duty'),
(1, 1, '2026-11-15', 'present', 'DBMS index optimization'),
(1, 2, '2026-11-16', 'present', 'Wireshark session trace');

-- Exams
INSERT INTO exams (id, class_id, name, exam_date) VALUES
(1, 1, 'Midterm Theory Evaluation', '2026-09-20'),
(2, 1, 'Final Semester Comprehensive', '2026-11-01'),
(3, 1, 'Midterm Practical Exam', '2026-10-15')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Marks
INSERT IGNORE INTO marks (exam_id, student_id, subject_id, marks_obtained, max_marks) VALUES
(1, 1, 1, 92.00, 100.00),
(1, 1, 2, 88.50, 100.00),
(2, 1, 1, 94.00, 100.00),
(2, 1, 2, 91.50, 100.00),
(3, 1, 5, 96.00, 100.00),
(3, 1, 6, 95.00, 100.00);

-- Fees
INSERT INTO fees (id, student_id, title, amount, due_date, status) VALUES
(1, 1, 'Semester 5 Tuition & Cyber Lab Fee', 45000.00, '2026-08-15', 'paid'),
(2, 1, 'Exam & Certification Assessment Fee', 3500.00, '2026-11-30', 'unpaid')
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- Announcements
INSERT INTO announcements (id, author_id, audience, title, body, created_at) VALUES
(1, 3, 'students', 'Annual Inter-College Hackathon 2026 - Registration Open', 'Registrations are officially open for the Annual Kalavanta Hackathon. All Computer & Cybersecurity enrollees can form teams up to 4 members. Prizes include cloud credits and direct internship interviews.', NOW() - INTERVAL 1 DAY),
(2, 3, 'students', 'Cloud Sandbox Maintenance & Terminal Upgrade', 'The sandbox Kubernetes cluster will undergo a rolling kernel patch tonight from 01:00 AM to 02:00 AM IST. Virtual labs and terminal sandboxes will remain available with no downtime.', NOW() - INTERVAL 3 HOUR),
(3, 3, 'students', 'Final Project Review Guidelines & Documentation Format', 'All students must submit IEEE-format project synopsis along with GitHub repository link before the upcoming deadline. Review dates have been posted to your curriculum portal.', NOW() - INTERVAL 5 HOUR)
ON DUPLICATE KEY UPDATE title=VALUES(title);
