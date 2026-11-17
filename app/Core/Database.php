<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;
    private static array $instances = [];

    private function __construct() {}
    private function __clone() {}

    /**
     * Get PDO connection instance.
     * If $connectionName is null, returns the default active target ('local' or 'remote').
     * If 'local' or 'remote' is passed, returns that specific instance.
     */
    public static function getConnection(?string $connectionName = null): PDO
    {
        if ($connectionName !== null) {
            if (!isset(self::$instances[$connectionName])) {
                $config = require dirname(dirname(__DIR__)) . '/config/database.php';
                $connConfig = $config['connections'][$connectionName] ?? null;
                if (!$connConfig) {
                    throw new \InvalidArgumentException("Database connection profile [{$connectionName}] not configured.");
                }
                self::$instances[$connectionName] = self::createPdoInstance($connConfig, $config['options'] ?? []);
            }
            return self::$instances[$connectionName];
        }

        if (self::$instance === null) {
            $config = require dirname(dirname(__DIR__)) . '/config/database.php';
            try {
                self::$instance = self::createPdoInstance($config, $config['options'] ?? []);
            } catch (\Throwable $e) {
                // If local connection failed and remote configuration is available, try remote fallback
                if (($config['target'] ?? '') === 'local' && isset($config['connections']['remote'])) {
                    error_log("Local DB connection failed, attempting remote fallback: " . $e->getMessage());
                    self::$instance = self::createPdoInstance($config['connections']['remote'], $config['options'] ?? []);
                } else {
                    throw $e;
                }
            }
        }

        return self::$instance;
    }

    private static function createPdoInstance(array $config, array $options = []): PDO
    {
        $dsn = sprintf(
            "%s:host=%s;port=%s;dbname=%s;charset=%s",
            $config['driver'] ?? 'mysql',
            $config['host'] ?? '127.0.0.1',
            $config['port'] ?? '3306',
            $config['database'] ?? 'erp',
            $config['charset'] ?? 'utf8mb4'
        );

        $defaultOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            return new PDO(
                $dsn,
                $config['username'] ?? 'root',
                $config['password'] ?? '',
                !empty($options) ? $options : $defaultOptions
            );
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new \RuntimeException("Database connection failed. Please verify server configuration.");
        }
    }

    /**
     * Get current active target name ('local' or 'remote')
     */
    public static function getActiveTarget(): string
    {
        $config = require dirname(dirname(__DIR__)) . '/config/database.php';
        return $config['target'] ?? 'local';
    }

    /**
     * Reset cached PDO instances (useful during CLI switches or tests)
     */
    public static function resetConnection(): void
    {
        self::$instance = null;
        self::$instances = [];
    }

    public static function staff(): PDO
    {
        return self::getConnection();
    }

    public static function student(): PDO
    {
        return self::getConnection();
    }
}
