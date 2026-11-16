<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Teacher
{
    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT t.*, u.full_name as name, u.email, u.username, u.phone, u.status, d.name as department_name, d.code as department_code
            FROM teachers t
            JOIN users u ON t.user_id = u.id
            JOIN departments d ON t.department_id = d.id
            ORDER BY t.id DESC
        ");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT t.*, u.full_name as name, u.email, u.username, u.phone, u.status, d.name as department_name, d.code as department_code
            FROM teachers t
            JOIN users u ON t.user_id = u.id
            JOIN departments d ON t.department_id = d.id
            WHERE t.id = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findByUserId(int $userId): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT t.*, u.full_name as name, u.email, u.phone, d.name as department_name
            FROM teachers t
            JOIN users u ON t.user_id = u.id
            JOIN departments d ON t.department_id = d.id
            WHERE t.user_id = :user_id
            LIMIT 1
        ");
        $stmt->execute(['user_id' => $userId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO teachers (user_id, employee_code, department_id, designation, joined_on)
            VALUES (:user_id, :employee_code, :department_id, :designation, :joined_on)
        ");
        $stmt->execute([
            'user_id' => $data['user_id'],
            'employee_code' => $data['employee_code'],
            'department_id' => $data['department_id'],
            'designation' => $data['designation'] ?? 'Lecturer',
            'joined_on' => $data['joined_on'] ?? date('Y-m-d'),
        ]);
        return (int)$db->lastInsertId();
    }

    public static function getAssignments(int $teacherId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT ta.id as assignment_id, c.id as class_id, c.name as class_name, c.division, 
                   s.id as subject_id, s.name as subject_name, s.code as subject_code
            FROM teaching_assignments ta
            JOIN classes c ON ta.class_id = c.id
            JOIN subjects s ON ta.subject_id = s.id
            WHERE ta.teacher_id = :teacher_id
            ORDER BY c.name, s.code
        ");
        $stmt->execute(['teacher_id' => $teacherId]);
        return $stmt->fetchAll();
    }

    public static function count(): int
    {
        try {
            $db = Database::getConnection();
            return (int)$db->query("SELECT COUNT(*) FROM teachers")->fetchColumn();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
