-- ERP Portal schema (MySQL 8 / MariaDB 10.6+)
CREATE DATABASE IF NOT EXISTS erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE erp;

-- ---------- AUTH & RBAC ----------
CREATE TABLE IF NOT EXISTS roles (
  id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(30) NOT NULL UNIQUE          -- admin | teacher | student
);

INSERT INTO roles (name) VALUES ('admin'), ('teacher'), ('student')
ON DUPLICATE KEY UPDATE name=name;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  role_id TINYINT UNSIGNED NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  username VARCHAR(60) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,      -- password_hash(PASSWORD_ARGON2ID) or PASSWORD_DEFAULT
  full_name VARCHAR(120) NOT NULL,
  phone VARCHAR(20) NULL,
  status ENUM('active','suspended','pending') NOT NULL DEFAULT 'active',
  must_change_password TINYINT(1) NOT NULL DEFAULT 1,
  failed_attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
  locked_until DATETIME NULL,
  last_login_at DATETIME NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS login_attempts (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  identifier VARCHAR(190) NOT NULL,
  ip_address VARCHAR(45) NOT NULL,
  success TINYINT(1) NOT NULL,
  attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (identifier, attempted_at),
  INDEX (ip_address, attempted_at)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS password_resets (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNSIGNED NOT NULL,
  token_hash CHAR(64) NOT NULL,             -- sha256 of emailed token
  expires_at DATETIME NOT NULL,
  used_at DATETIME NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX (token_hash)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS audit_logs (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNSIGNED NULL,
  action VARCHAR(80) NOT NULL,
  entity VARCHAR(60) NULL,
  entity_id INT UNSIGNED NULL,
  meta JSON NULL,
  ip_address VARCHAR(45) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX (user_id, created_at)
) ENGINE=InnoDB;

-- ---------- ACADEMIC STRUCTURE ----------
CREATE TABLE IF NOT EXISTS academic_years (
  id SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  label VARCHAR(20) NOT NULL UNIQUE,        -- 2026-27
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  is_current TINYINT(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS departments (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL UNIQUE,
  code VARCHAR(10) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS classes (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  department_id INT UNSIGNED NOT NULL,
  academic_year_id SMALLINT UNSIGNED NOT NULL,
  name VARCHAR(60) NOT NULL,                -- e.g. TE Computer
  division VARCHAR(10) NULL,
  FOREIGN KEY (department_id) REFERENCES departments(id),
  FOREIGN KEY (academic_year_id) REFERENCES academic_years(id),
  UNIQUE (department_id, academic_year_id, name, division)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS subjects (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  department_id INT UNSIGNED NOT NULL,
  code VARCHAR(20) NOT NULL UNIQUE,
  name VARCHAR(150) NOT NULL,
  credits TINYINT UNSIGNED NOT NULL DEFAULT 3,
  FOREIGN KEY (department_id) REFERENCES departments(id)
) ENGINE=InnoDB;

-- ---------- PROFILES ----------
CREATE TABLE IF NOT EXISTS teachers (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNSIGNED NOT NULL UNIQUE,
  employee_code VARCHAR(30) NOT NULL UNIQUE,
  department_id INT UNSIGNED NOT NULL,
  designation VARCHAR(80) NULL,
  joined_on DATE NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (department_id) REFERENCES departments(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS students (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNSIGNED NOT NULL UNIQUE,
  roll_no VARCHAR(30) NOT NULL UNIQUE,
  class_id INT UNSIGNED NOT NULL,
  dob DATE NULL,
  guardian_name VARCHAR(120) NULL,
  guardian_phone VARCHAR(20) NULL,
  admitted_on DATE NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (class_id) REFERENCES classes(id)
) ENGINE=InnoDB;

-- teacher <-> class <-> subject assignment
CREATE TABLE IF NOT EXISTS teaching_assignments (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  teacher_id INT UNSIGNED NOT NULL,
  class_id INT UNSIGNED NOT NULL,
  subject_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
  UNIQUE (teacher_id, class_id, subject_id)
) ENGINE=InnoDB;

-- ---------- OPERATIONS ----------
CREATE TABLE IF NOT EXISTS attendance (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  student_id INT UNSIGNED NOT NULL,
  assignment_id INT UNSIGNED NOT NULL,
  date DATE NOT NULL,
  status ENUM('present','absent','late','excused') NOT NULL,
  marked_by INT UNSIGNED NOT NULL,          -- users.id
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (assignment_id) REFERENCES teaching_assignments(id) ON DELETE CASCADE,
  FOREIGN KEY (marked_by) REFERENCES users(id),
  UNIQUE (student_id, assignment_id, date)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS exams (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  class_id INT UNSIGNED NOT NULL,
  name VARCHAR(80) NOT NULL,                -- Midterm, Final
  exam_date DATE NULL,
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS marks (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  exam_id INT UNSIGNED NOT NULL,
  student_id INT UNSIGNED NOT NULL,
  subject_id INT UNSIGNED NOT NULL,
  marks_obtained DECIMAL(5,2) NOT NULL,
  max_marks DECIMAL(5,2) NOT NULL DEFAULT 100,
  FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects(id),
  UNIQUE (exam_id, student_id, subject_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS fees (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  student_id INT UNSIGNED NOT NULL,
  title VARCHAR(120) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  due_date DATE NOT NULL,
  status ENUM('unpaid','partial','paid') NOT NULL DEFAULT 'unpaid',
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS fee_payments (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  fee_id INT UNSIGNED NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  method VARCHAR(30) NOT NULL,
  txn_ref VARCHAR(80) NULL,
  paid_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (fee_id) REFERENCES fees(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS announcements (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  author_id INT UNSIGNED NOT NULL,
  audience ENUM('all','teachers','students') NOT NULL DEFAULT 'all',
  title VARCHAR(180) NOT NULL,
  body TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES users(id)
) ENGINE=InnoDB;

-- ---------- CAREER & INDUSTRY DESK ----------
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

-- ---------- VIRTUAL SESSIONS & LIVE CLASSES ----------
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

-- Sessions stored in DB
CREATE TABLE IF NOT EXISTS sessions (
  id VARCHAR(128) PRIMARY KEY,
  user_id INT UNSIGNED NULL,
  data MEDIUMTEXT NOT NULL,
  ip_address VARCHAR(45) NULL,
  user_agent VARCHAR(255) NULL,
  last_activity INT UNSIGNED NOT NULL,
  INDEX (last_activity)
) ENGINE=InnoDB;
