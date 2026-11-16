<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Attendance
{
    public static function mark(array $data): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO attendance (student_id, assignment_id, date, status, marked_by)
            VALUES (:student_id, :assignment_id, :date, :status, :marked_by)
            ON DUPLICATE KEY UPDATE
                status = VALUES(status),
                marked_by = VALUES(marked_by)
        ");
        return $stmt->execute([
            'student_id' => $data['student_id'],
            'assignment_id' => $data['assignment_id'],
            'date' => $data['date'],
            'status' => $data['status'],
            'marked_by' => $data['marked_by'],
        ]);
    }

    public static function getByStudent(int $studentId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT a.*, c.name as class_name, c.division, s.name as subject_name, s.code as subject_code,
                   tu.full_name as faculty_name, t.designation as faculty_designation
            FROM attendance a
            JOIN teaching_assignments ta ON a.assignment_id = ta.id
            JOIN classes c ON ta.class_id = c.id
            JOIN subjects s ON ta.subject_id = s.id
            JOIN teachers t ON ta.teacher_id = t.id
            JOIN users tu ON t.user_id = tu.id
            WHERE a.student_id = :student_id
            ORDER BY a.date DESC
        ");
        $stmt->execute(['student_id' => $studentId]);
        return $stmt->fetchAll();
    }

    public static function getByAssignmentAndDate(int $assignmentId, string $date): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT a.*, st.roll_no, u.full_name as student_name
            FROM attendance a
            JOIN students st ON a.student_id = st.id
            JOIN users u ON st.user_id = u.id
            WHERE a.assignment_id = :assignment_id AND a.date = :date
            ORDER BY st.roll_no ASC
        ");
        $stmt->execute([
            'assignment_id' => $assignmentId,
            'date' => $date
        ]);
        return $stmt->fetchAll();
    }

    public static function getStudentStats(int $studentId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT 
                COUNT(*) as total_days,
                SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_days,
                SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_days,
                SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late_days
            FROM attendance
            WHERE student_id = :student_id
        ");
        $stmt->execute(['student_id' => $studentId]);
        $stats = $stmt->fetch();
        $total = (int)($stats['total_days'] ?? 0);
        $present = (int)($stats['present_days'] ?? 0);
        $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;
        
        return [
            'total' => $total,
            'present' => $present,
            'absent' => (int)($stats['absent_days'] ?? 0),
            'late' => (int)($stats['late_days'] ?? 0),
            'percentage' => $percentage
        ];
    }
}
