<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Fee
{
    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT f.*, u.full_name as student_name, s.roll_no, c.name as class_name, c.division,
                   COALESCE(SUM(fp.amount), 0) as paid_amount
            FROM fees f
            JOIN students s ON f.student_id = s.id
            JOIN users u ON s.user_id = u.id
            JOIN classes c ON s.class_id = c.id
            LEFT JOIN fee_payments fp ON f.id = fp.fee_id
            GROUP BY f.id
            ORDER BY f.due_date ASC
        ");
        return $stmt->fetchAll();
    }

    public static function getByStudent(int $studentId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT f.*, COALESCE(SUM(fp.amount), 0) as paid_amount
            FROM fees f 
            LEFT JOIN fee_payments fp ON f.id = fp.fee_id
            WHERE f.student_id = :student_id 
            GROUP BY f.id
            ORDER BY f.due_date ASC
        ");
        $stmt->execute(['student_id' => $studentId]);
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO fees (student_id, title, amount, due_date, status)
            VALUES (:student_id, :title, :amount, :due_date, :status)
        ");
        $stmt->execute([
            'student_id' => $data['student_id'],
            'title' => $data['title'],
            'amount' => $data['amount'],
            'due_date' => $data['due_date'],
            'status' => $data['status'] ?? 'unpaid',
        ]);
        return (int)$db->lastInsertId();
    }

    public static function recordPayment(int $feeId, float $amount, string $method, string $txnRef): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO fee_payments (fee_id, amount, method, txn_ref, paid_at)
            VALUES (:fee_id, :amount, :method, :txn_ref, NOW())
        ");
        $stmt->execute([
            'fee_id' => $feeId,
            'amount' => $amount,
            'method' => $method,
            'txn_ref' => $txnRef,
        ]);

        // Update fee status to paid
        $uStmt = $db->prepare("UPDATE fees SET status = 'paid' WHERE id = :id");
        return $uStmt->execute(['id' => $feeId]);
    }

    public static function getTotalRevenue(): float
    {
        try {
            $db = Database::getConnection();
            return (float)$db->query("SELECT SUM(amount) FROM fee_payments")->fetchColumn() ?: 0.0;
        } catch (\Exception $e) {
            return 0.0;
        }
    }
}
