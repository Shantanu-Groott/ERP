<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class ClassRoom
{
    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT c.*, d.name as department_name, d.code as department_code, ay.label as academic_year,
                   COUNT(s.id) as total_students
            FROM classes c
            JOIN departments d ON c.department_id = d.id
            JOIN academic_years ay ON c.academic_year_id = ay.id
            LEFT JOIN students s ON s.class_id = c.id
            GROUP BY c.id
            ORDER BY c.name ASC, c.division ASC
        ");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT c.*, d.name as department_name, ay.label as academic_year
            FROM classes c
            JOIN departments d ON c.department_id = d.id
            JOIN academic_years ay ON c.academic_year_id = ay.id
            WHERE c.id = :id 
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO classes (department_id, academic_year_id, name, division)
            VALUES (:department_id, :academic_year_id, :name, :division)
        ");
        $stmt->execute([
            'department_id' => $data['department_id'],
            'academic_year_id' => $data['academic_year_id'],
            'name' => $data['name'],
            'division' => $data['division'] ?? 'A',
        ]);
        return (int)$db->lastInsertId();
    }

    public static function count(): int
    {
        try {
            $db = Database::getConnection();
            return (int)$db->query("SELECT COUNT(*) FROM classes")->fetchColumn();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
