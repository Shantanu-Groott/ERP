<?php

// Student ERP Database Connection Configuration
if (!defined('DB_DRIVER')) {
    define('DB_DRIVER', 'mysql');
}
if (!defined('DB_HOST')) {
    define('DB_HOST', getenv('EDULMS_STUDENT_DB_HOST') ?: (getenv('DB_HOST') ?: 'localhost'));
}
if (!defined('DB_NAME')) {
    define('DB_NAME', getenv('EDULMS_STUDENT_DB_NAME') ?: (getenv('DB_DATABASE') ?: 'groott_o1_student'));
}
if (!defined('DB_USER')) {
    define('DB_USER', getenv('EDULMS_STUDENT_DB_USER') ?: (getenv('DB_USERNAME') ?: 'groott_o1_shantanu'));
}
if (!defined('DB_PASS')) {
    define('DB_PASS', getenv('EDULMS_STUDENT_DB_PASS') ?: (getenv('DB_PASSWORD') ?: 'Shantanu@12'));
}
if (!defined('DB_PORT')) {
    define('DB_PORT', getenv('EDULMS_STUDENT_DB_PORT') ?: (getenv('DB_PORT') ?: '3306'));
}

return [
    'driver' => DB_DRIVER,
    'host' => DB_HOST,
    'port' => DB_PORT,
    'database' => DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASS,
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options' => [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ]
];
