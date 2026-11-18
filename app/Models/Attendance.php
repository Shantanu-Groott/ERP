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
            INSERT INTO attendance (student_id, subject_id, date, status, remarks)
            VALUES (:student_id, :subject_id, :date, :status, :remarks)
            ON DUPLICATE KEY UPDATE
                status = VALUES(status),
                remarks = VALUES(remarks)
        ");
        return $stmt->execute([
            'student_id' => $data['student_id'],
            'subject_id' => $data['subject_id'],
            'date' => $data['date'],
            'status' => $data['status'],
            'remarks' => $data['remarks'] ?? null,
        ]);
    }

    public static function getByStudent(int $studentId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT a.*, c.name as class_name, c.division, s.name as subject_name, s.code as subject_code,
                   s.instructor_name as faculty_name, s.instructor_title as faculty_designation
            FROM attendance a
            JOIN students st ON a.student_id = st.id
            JOIN classes c ON st.class_id = c.id
            JOIN subjects s ON a.subject_id = s.id
            WHERE a.student_id = :student_id
            ORDER BY a.date DESC
        ");
        $stmt->execute(['student_id' => $studentId]);
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
                SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late_days,
                SUM(CASE WHEN status = 'excused' THEN 1 ELSE 0 END) as excused_days
            FROM attendance
            WHERE student_id = :student_id
        ");
        $stmt->execute(['student_id' => $studentId]);
        $stats = $stmt->fetch();
        $total = (int)($stats['total_days'] ?? 0);
        $present = (int)($stats['present_days'] ?? 0);
        $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;
        $late = (int)($stats['late_days'] ?? 0);
        $excused = (int)($stats['excused_days'] ?? 0);
        
        return [
            'total' => $total,
            'present' => $present,
            'absent' => (int)($stats['absent_days'] ?? 0),
            'late' => $late,
            'excused' => $excused,
            'late_excused' => $late + $excused,
            'percentage' => $percentage,
        ];
    }
}
