-- ERP Initial Seed Data matching the updated schema
USE erp;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Roles
INSERT INTO roles (id, name) VALUES (1, 'admin'), (2, 'teacher'), (3, 'student')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Academic Years
INSERT INTO academic_years (id, label, start_date, end_date, is_current) VALUES
(1, '2026-27', '2026-06-01', '2027-05-31', 1)
ON DUPLICATE KEY UPDATE label=VALUES(label);

-- Departments
INSERT INTO departments (id, name, code) VALUES
(1, 'Computer Engineering', 'COMP'),
(2, 'Information Technology', 'IT'),
(3, 'Electronics & Telecommunication', 'EXTC')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Classes
INSERT INTO classes (id, department_id, academic_year_id, name, division) VALUES
(1, 1, 1, 'TE Computer', 'A'),
(2, 1, 1, 'TE Computer', 'B'),
(3, 1, 1, 'BE Computer', 'A')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Subjects
INSERT INTO subjects (id, department_id, code, name, credits) VALUES
(1, 1, 'CS301', 'Database Management Systems', 4),
(2, 1, 'CS302', 'Computer Networks', 4),
(3, 1, 'CS303', 'Theory of Computation', 3),
(4, 1, 'CS304', 'Web Computing & ERP', 3)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Users (admin123 hashed using password_hash('admin123', PASSWORD_BCRYPT))
-- $2y$10$Xk1feZIxXW8sRjAL/ZPyVuyyQTkN26tMPNbBHoIoRBryiU6kaIrSW
INSERT INTO users (id, role_id, email, username, password_hash, full_name, phone, status, must_change_password) VALUES
(1, 1, 'admin@erp.local', 'admin', '$2y$10$Xk1feZIxXW8sRjAL/ZPyVuyyQTkN26tMPNbBHoIoRBryiU6kaIrSW', 'System Administrator', '+1 555-0100', 'active', 0),
(2, 2, 'teacher@erp.local', 'prof.robert', '$2y$10$Xk1feZIxXW8sRjAL/ZPyVuyyQTkN26tMPNbBHoIoRBryiU6kaIrSW', 'Prof. Robert Miller', '+1 555-0101', 'active', 0),
(3, 3, 'student@erp.local', 'alex.j', '$2y$10$Xk1feZIxXW8sRjAL/ZPyVuyyQTkN26tMPNbBHoIoRBryiU6kaIrSW', 'Alex Johnson', '+1 555-0102', 'active', 0)
ON DUPLICATE KEY UPDATE full_name=VALUES(full_name), password_hash=VALUES(password_hash);

-- Teacher Profile
INSERT INTO teachers (id, user_id, employee_code, department_id, designation, joined_on) VALUES
(1, 2, 'EMP-1001', 1, 'Associate Professor', '2023-07-01')
ON DUPLICATE KEY UPDATE employee_code=VALUES(employee_code);

-- Student Profile
INSERT INTO students (id, user_id, roll_no, class_id, dob, guardian_name, guardian_phone, admitted_on) VALUES
(1, 3, 'COMP-2026-001', 1, '2005-04-12', 'Mark Johnson', '+1 555-0999', '2024-08-01')
ON DUPLICATE KEY UPDATE roll_no=VALUES(roll_no);

-- Teaching Assignment (Teacher 1 assigned to Class 1, Subject 1 & 2)
INSERT INTO teaching_assignments (id, teacher_id, class_id, subject_id) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2)
ON DUPLICATE KEY UPDATE teacher_id=VALUES(teacher_id);

-- Exams
INSERT INTO exams (id, class_id, name, exam_date) VALUES
(1, 1, 'Midterm Examination', '2026-10-10'),
(2, 1, 'Final Semester Exam', '2026-12-15')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Marks
INSERT INTO marks (id, exam_id, student_id, subject_id, marks_obtained, max_marks) VALUES
(1, 1, 1, 1, 88.50, 100.00),
(2, 1, 1, 2, 92.00, 100.00)
ON DUPLICATE KEY UPDATE marks_obtained=VALUES(marks_obtained);

-- Attendance
INSERT INTO attendance (id, student_id, assignment_id, date, status, marked_by) VALUES
(1, 1, 1, CURDATE(), 'present', 2)
ON DUPLICATE KEY UPDATE status=VALUES(status);

-- Fees
INSERT INTO fees (id, student_id, title, amount, due_date, status) VALUES
(1, 1, 'Semester 5 Tuition Fee', 1500.00, '2026-11-30', 'paid'),
(2, 1, 'Hostel & Mess Fee', 800.00, '2027-01-15', 'unpaid')
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- Fee Payments
INSERT INTO fee_payments (id, fee_id, amount, method, txn_ref) VALUES
(1, 1, 1500.00, 'Online / Card', 'TXN-984210')
ON DUPLICATE KEY UPDATE amount=VALUES(amount);

-- Announcements
INSERT INTO announcements (id, author_id, audience, title, body) VALUES
(1, 1, 'all', 'Welcome to Academic Year 2026-27', 'Welcome to all faculty and students! The academic schedule and syllabus are now live.')
ON DUPLICATE KEY UPDATE title=VALUES(title);

SET FOREIGN_KEY_CHECKS = 1;
