<?php

// ====================================================
// Kalavanta Edutech Student ERP Database Configuration
// Supports dual-mode: 'remote' (Deployment) & 'local' (Tests)
// ====================================================

// Auto-detect deployment vs local development:
$httpHost = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? '');
$isLocalDev = (
    empty($httpHost) ||
    str_contains($httpHost, 'localhost') ||
    str_starts_with($httpHost, '127.0.0.1') ||
    str_starts_with($httpHost, '::1') ||
    (php_sapi_name() === 'cli' && getenv('DB_TARGET') === 'local')
);

// Determine target: check DB_TARGET in .env, then production/live host detection
$target = getenv('DB_TARGET');
if (!$target) {
    if (getenv('APP_ENV') === 'production' || (!$isLocalDev && !empty($httpHost))) {
        $target = 'remote';
    } else {
        $target = 'local';
    }
}
$target = strtolower(trim((string)$target));

// ----------------------------------------------------
// 1. REMOTE DEPLOYMENT CONFIGURATION
// ----------------------------------------------------
$remoteConfig = [
    'driver'    => getenv('EDULMS_STUDENT_DB_DRIVER') ?: 'mysql',
    'host'      => getenv('EDULMS_STUDENT_DB_HOST') ?: (getenv('DB_HOST') ?: 'localhost'),
    'port'      => getenv('EDULMS_STUDENT_DB_PORT') ?: (getenv('DB_PORT') ?: '3306'),
    'database'  => getenv('EDULMS_STUDENT_DB_NAME') ?: 'groott_o1_student',
    'username'  => getenv('EDULMS_STUDENT_DB_USER') ?: 'groott_o1_shantanu',
    'password'  => getenv('EDULMS_STUDENT_DB_PASS') ?: 'Shantanu@12',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
];

// ----------------------------------------------------
// 2. LOCAL TEST CONFIGURATION (Database: erp, User: root)
// [LOCAL INTEGRATION BLOCK - Can be bypassed via DB_TARGET=remote or deleted for deployment]
// ----------------------------------------------------
$localConfig = [
    'driver'    => getenv('DB_LOCAL_DRIVER') ?: 'mysql',
    'host'      => getenv('DB_LOCAL_HOST') ?: (getenv('DB_HOST') ?: '127.0.0.1'),
    'port'      => getenv('DB_LOCAL_PORT') ?: (getenv('DB_PORT') ?: '3306'),
    'database'  => getenv('DB_LOCAL_NAME') ?: 'erp',
    'username'  => getenv('DB_LOCAL_USER') ?: 'root',
    'password'  => getenv('DB_LOCAL_PASS') !== false && getenv('DB_LOCAL_PASS') !== '' 
                    ? getenv('DB_LOCAL_PASS') 
                    : (getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '1235'),
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
];
// [END LOCAL INTEGRATION BLOCK]

// Select active configuration based on target (falls back safely to remote if local is deleted)
$active = ($target === 'local' && isset($localConfig)) ? $localConfig : $remoteConfig;
$activeTarget = ($target === 'local' && isset($localConfig)) ? 'local' : 'remote';

// Define global constants for active connection
if (!defined('DB_TARGET')) define('DB_TARGET', $activeTarget);
if (!defined('DB_DRIVER')) define('DB_DRIVER', $active['driver']);
if (!defined('DB_HOST'))   define('DB_HOST', $active['host']);
if (!defined('DB_PORT'))   define('DB_PORT', $active['port']);
if (!defined('DB_NAME'))   define('DB_NAME', $active['database']);
if (!defined('DB_USER'))   define('DB_USER', $active['username']);
if (!defined('DB_PASS'))   define('DB_PASS', $active['password']);

return [
    'target'    => $activeTarget,
    'driver'    => $active['driver'],
    'host'      => $active['host'],
    'port'      => $active['port'],
    'database'  => $active['database'],
    'username'  => $active['username'],
    'password'  => $active['password'],
    'charset'   => $active['charset'],
    'collation' => $active['collation'],
    'options'   => [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ],
    // Both connection profiles available
    'connections' => [
        'remote' => $remoteConfig,
        'local'  => $localConfig ?? $remoteConfig,
    ],
];
