<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Subject
{
    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT s.*, d.name as department_name, d.code as department_code
            FROM subjects s
            JOIN departments d ON s.department_id = d.id
            ORDER BY s.code ASC
        ");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM subjects WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO subjects (department_id, code, name, credits)
            VALUES (:department_id, :code, :name, :credits)
        ");
        $stmt->execute([
            'department_id' => $data['department_id'],
            'code' => $data['code'],
            'name' => $data['name'],
            'credits' => $data['credits'] ?? 3,
        ]);
        return (int)$db->lastInsertId();
    }
}
