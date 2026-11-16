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
            SELECT u.id, u.email, u.username, u.full_name, u.phone, u.status, u.last_login_at, u.created_at
            FROM users u
            ORDER BY u.id DESC
        ");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT u.*
            FROM users u
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
            SELECT u.*
            FROM users u
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
        $passwordHash = !empty($data['password_hash']) 
            ? $data['password_hash'] 
            : password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = $db->prepare("
            INSERT INTO users (email, username, password_hash, full_name, phone, status, must_change_password)
            VALUES (:email, :username, :password_hash, :full_name, :phone, :status, :must_change_password)
        ");
        $stmt->execute([
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

        foreach (['full_name', 'email', 'phone', 'status', 'must_change_password'] as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                $params[$field] = $data[$field];
            }
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        return $db->prepare($sql)->execute($params);
    }

    public static function updatePassword(int $id, string $newPassword): bool
    {
        $db = Database::getConnection();
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $db->prepare("UPDATE users SET password_hash = :hash, must_change_password = 0 WHERE id = :id");
        return $stmt->execute(['hash' => $hash, 'id' => $id]);
    }

    public static function delete(int $id): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function count(): int
    {
        $db = Database::getConnection();
        return (int)$db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
