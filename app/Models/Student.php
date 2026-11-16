<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Student
{
    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT s.*, u.full_name as name, u.email, u.username, u.phone, u.status, 
                   c.name as class_name, c.division, d.name as department_name
            FROM students s
            JOIN users u ON s.user_id = u.id
            JOIN classes c ON s.class_id = c.id
            JOIN departments d ON c.department_id = d.id
            ORDER BY s.id DESC
        ");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT s.*, u.full_name as name, u.email, u.username, u.phone, u.status, 
                   c.name as class_name, c.division, d.name as department_name
            FROM students s
            JOIN users u ON s.user_id = u.id
            JOIN classes c ON s.class_id = c.id
            JOIN departments d ON c.department_id = d.id
            WHERE s.id = :id
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
            SELECT s.*, u.full_name as name, u.email, u.phone, 
                   c.name as class_name, c.division, d.name as department_name
            FROM students s
            JOIN users u ON s.user_id = u.id
            JOIN classes c ON s.class_id = c.id
            JOIN departments d ON c.department_id = d.id
            WHERE s.user_id = :user_id
            LIMIT 1
        ");
        $stmt->execute(['user_id' => $userId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findByClass(int $classId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT s.*, u.full_name as name, u.email
            FROM students s
            JOIN users u ON s.user_id = u.id
            WHERE s.class_id = :class_id
            ORDER BY s.roll_no ASC
        ");
        $stmt->execute(['class_id' => $classId]);
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO students (user_id, roll_no, class_id, dob, guardian_name, guardian_phone, admitted_on)
            VALUES (:user_id, :roll_no, :class_id, :dob, :guardian_name, :guardian_phone, :admitted_on)
        ");
        $stmt->execute([
            'user_id' => $data['user_id'],
            'roll_no' => $data['roll_no'],
            'class_id' => $data['class_id'],
            'dob' => $data['dob'] ?? null,
            'guardian_name' => $data['guardian_name'] ?? null,
            'guardian_phone' => $data['guardian_phone'] ?? null,
            'admitted_on' => $data['admitted_on'] ?? date('Y-m-d'),
        ]);
        return (int)$db->lastInsertId();
    }

    public static function count(): int
    {
        try {
            $db = Database::getConnection();
            return (int)$db->query("SELECT COUNT(*) FROM students")->fetchColumn();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
