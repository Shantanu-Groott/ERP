<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT u.id, u.role_id, r.name as role, u.email, u.username, u.full_name, u.phone, u.status, u.last_login_at, u.created_at
            FROM users u
            JOIN roles r ON u.role_id = r.id
            ORDER BY u.id DESC
        ");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT u.*, r.name as role
            FROM users u
            JOIN roles r ON u.role_id = r.id
            WHERE u.id = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function findByEmailOrUsername(string $identifier): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT u.*, r.name as role
            FROM users u
            JOIN roles r ON u.role_id = r.id
            WHERE u.email = :email OR u.username = :username
            LIMIT 1
        ");
        $stmt->execute([
            'email' => $identifier,
            'username' => $identifier
        ]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function create(array $data): int
    {
        $db = Database::getConnection();
        
        // Resolve role_id from role name if string given
        $roleId = $data['role_id'] ?? null;
        if (!$roleId && !empty($data['role'])) {
            $rStmt = $db->prepare("SELECT id FROM roles WHERE name = :name LIMIT 1");
            $rStmt->execute(['name' => $data['role']]);
            $roleId = $rStmt->fetchColumn();
        }

        $passwordHash = !empty($data['password_hash']) 
            ? $data['password_hash'] 
            : password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = $db->prepare("
            INSERT INTO users (role_id, email, username, password_hash, full_name, phone, status, must_change_password)
            VALUES (:role_id, :email, :username, :password_hash, :full_name, :phone, :status, :must_change_password)
        ");
        $stmt->execute([
            'role_id' => $roleId ?: 3,
            'email' => $data['email'],
            'username' => $data['username'],
            'password_hash' => $passwordHash,
            'full_name' => $data['full_name'],
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'] ?? 'active',
            'must_change_password' => $data['must_change_password'] ?? 0,
        ]);
        return (int)$db->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $db = Database::getConnection();
        $fields = [];
        $params = ['id' => $id];

        foreach (['full_name', 'email', 'phone', 'status', 'must_change_password', 'role_id'] as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                $params[$field] = $data[$field];
            }
        }

        if (!empty($data['password'])) {
            $fields[] = "password_hash = :password_hash";
            $params['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        return $db->prepare($sql)->execute($params);
    }

    public static function delete(int $id): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function updateLastLogin(int $id): void
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE users SET last_login_at = NOW(), failed_attempts = 0, locked_until = NULL WHERE id = :id");
            $stmt->execute(['id' => $id]);
        } catch (\Exception $e) {}
    }

    public static function incrementFailedAttempts(int $id, int $maxAttempts = 5, int $lockoutMinutes = 15): void
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                UPDATE users 
                SET failed_attempts = failed_attempts + 1,
                    locked_until = IF(failed_attempts + 1 >= :max, DATE_ADD(NOW(), INTERVAL :lockout MINUTE), locked_until)
                WHERE id = :id
            ");
            $stmt->execute([
                'id' => $id,
                'max' => $maxAttempts,
                'lockout' => $lockoutMinutes
            ]);
        } catch (\Exception $e) {}
    }

    public static function countByRole(string $role): int
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                SELECT COUNT(u.id) 
                FROM users u
                JOIN roles r ON u.role_id = r.id
                WHERE r.name = :role
            ");
            $stmt->execute(['role' => $role]);
            return (int)$stmt->fetchColumn();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
