<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Mark
{
    public static function save(array $data): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO marks (exam_id, student_id, subject_id, marks_obtained, max_marks)
            VALUES (:exam_id, :student_id, :subject_id, :marks_obtained, :max_marks)
            ON DUPLICATE KEY UPDATE
                marks_obtained = VALUES(marks_obtained),
                max_marks = VALUES(max_marks)
        ");
        return $stmt->execute([
            'exam_id' => $data['exam_id'],
            'student_id' => $data['student_id'],
            'subject_id' => $data['subject_id'],
            'marks_obtained' => $data['marks_obtained'],
            'max_marks' => $data['max_marks'] ?? 100.00,
        ]);
    }

    public static function getByStudent(int $studentId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT m.*, e.name as exam_name, e.exam_date, s.name as subject_name, s.code as subject_code
            FROM marks m
            JOIN exams e ON m.exam_id = e.id
            JOIN subjects s ON m.subject_id = s.id
            WHERE m.student_id = :student_id
            ORDER BY e.exam_date DESC, s.code ASC
        ");
        $stmt->execute(['student_id' => $studentId]);
        return $stmt->fetchAll();
    }

    public static function getByExamAndSubject(int $examId, int $subjectId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT m.*, u.full_name as student_name, st.roll_no
            FROM marks m
            JOIN students st ON m.student_id = st.id
            JOIN users u ON st.user_id = u.id
            WHERE m.exam_id = :exam_id AND m.subject_id = :subject_id
            ORDER BY st.roll_no ASC
        ");
        $stmt->execute([
            'exam_id' => $examId,
            'subject_id' => $subjectId
        ]);
        return $stmt->fetchAll();
    }

    public static function getExams(): array
    {
        $db = Database::getConnection();
        return $db->query("SELECT * FROM exams ORDER BY exam_date DESC")->fetchAll();
    }
}
