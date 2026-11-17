<?php

namespace App\Services;

use App\Core\Database;
use PDO;

class AuditService
{
    public static function log(?int $userId, string $action, ?string $entity = null, ?int $entityId = null, ?array $meta = null): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        try {
            $db = Database::getConnection();
            
            $stmt = $db->prepare("
                INSERT INTO audit_logs (user_id, action, entity, entity_id, meta, ip_address, created_at)
                VALUES (:user_id, :action, :entity, :entity_id, :meta, :ip_address, NOW())
            ");
            $stmt->execute([
                'user_id' => $userId,
                'action' => $action,
                'entity' => $entity,
                'entity_id' => $entityId,
                'meta' => $meta ? json_encode($meta) : null,
                'ip_address' => $ip,
            ]);
        } catch (\Throwable $e) {
            // Protected local fallback sink with restricted permissions
            $logDir = dirname(dirname(__DIR__)) . '/storage/logs';
            if (!is_dir($logDir)) {
                @mkdir($logDir, 0700, true);
            }
            $logFile = $logDir . '/audit.log';
            $entry = sprintf("[%s] USER:%s ACTION:%s ENTITY:%s ID:%s IP:%s\n", 
                date('Y-m-d H:i:s'), $userId ?? 'GUEST', $action, $entity ?? 'none', $entityId ?? 'none', $ip);
            
            $written = @file_put_contents($logFile, $entry, FILE_APPEND);
            if (file_exists($logFile)) {
                @chmod($logFile, 0600);
            }

            // If local fallback write also fails, emit an operational alert without leaking raw DB/system exceptions
            if ($written === false) {
                error_log(sprintf('[SECURITY_ALERT] Audit logging failed to record action "%s" for user "%s".', $action, $userId ?? 'GUEST'));
            }
        }
    }

    public static function getRecent(int $limit = 10): array
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                SELECT a.*, u.full_name as user_name 
                FROM audit_logs a
                LEFT JOIN users u ON a.user_id = u.id
                ORDER BY a.created_at DESC
                LIMIT :limit
            ");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Throwable $e) {
            return [];
        }
    }
}
