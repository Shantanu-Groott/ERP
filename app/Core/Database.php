<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $config = require dirname(dirname(__DIR__)) . '/config/database.php';
            
            $dsn = sprintf(
                "%s:host=%s;port=%s;dbname=%s;charset=%s",
                $config['driver'],
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            } catch (PDOException $e) {
                error_log("Database Connection Error: " . $e->getMessage());
                throw new \RuntimeException("Database connection failed. Please verify server configuration.");
            }
        }

        return self::$instance;
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
