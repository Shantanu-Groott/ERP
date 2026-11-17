<?php
declare(strict_types=1);

/**
 * Kalavanta Edutech ERP - Database Environment Switcher & Health Tool
 *
 * Usage:
 *   php database/switch_db.php status         # Test and display status of both databases
 *   php database/switch_db.php local          # Switch active DB to local (erp / root)
 *   php database/switch_db.php remote         # Switch active DB to remote (groott_o1_student / groott_o1_shantanu)
 *   php database/switch_db.php remove-local   # Switch to remote and remove local testing block
 */

define('ROOT_PATH', dirname(__DIR__));

$action = strtolower(trim($argv[1] ?? 'status'));
$envFile = ROOT_PATH . '/.env';

if (!file_exists($envFile)) {
    echo "[-] Error: .env file not found at {$envFile}\n";
    exit(1);
}

// Function to read .env into array
function loadEnvLines(string $path): array {
    return file($path, FILE_IGNORE_NEW_LINES);
}

// Function to update a key in .env
function updateEnvKey(string $path, string $key, string $value): void {
    $lines = loadEnvLines($path);
    $found = false;
    $newLines = [];

    foreach ($lines as $line) {
        if (preg_match("/^\s*{$key}\s*=/", $line)) {
            $newLines[] = "{$key}={$value}";
            $found = true;
        } else {
            $newLines[] = $line;
        }
    }

    if (!$found) {
        $newLines[] = "{$key}={$value}";
    }

    file_put_contents($path, implode("\n", $newLines) . "\n");
}

// Function to test a connection configuration
function testDb(string $label, array $cfg): void {
    echo "[*] Testing {$label} connection...\n";
    echo "    Host: {$cfg['host']}:{$cfg['port']}\n";
    echo "    Database: {$cfg['database']}\n";
    echo "    User: {$cfg['username']}\n";

    try {
        $dsn = "mysql:host={$cfg['host']};port={$cfg['port']};dbname={$cfg['database']};charset=utf8mb4";
        $pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 3,
        ]);
        $dbName = $pdo->query("SELECT DATABASE()")->fetchColumn();
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

        echo "    [+] SUCCESS: Connected to '{$dbName}'!\n";
        echo "    [+] Tables: " . count($tables) . " | Registered Users: {$userCount}\n\n";
    } catch (\Throwable $e) {
        echo "    [-] FAILED: " . $e->getMessage() . "\n\n";
    }
}

// Bootstrap environment
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            [$k, $v] = explode('=', $line, 2);
            $k = trim($k);
            $v = trim($v, " \t\n\r\0\x0B\"'");
            putenv("{$k}={$v}");
            $_ENV[$k] = $v;
            $_SERVER[$k] = $v;
        }
    }
}

$config = require ROOT_PATH . '/config/database.php';

switch ($action) {
    case 'local':
        updateEnvKey($envFile, 'DB_TARGET', 'local');
        echo "========================================================\n";
        echo " Switched Active Database Target to: LOCAL (erp / root)\n";
        echo "========================================================\n\n";
        testDb('LOCAL (erp / root)', $config['connections']['local']);
        break;

    case 'remote':
        updateEnvKey($envFile, 'DB_TARGET', 'remote');
        echo "========================================================\n";
        echo " Switched Active Database Target to: REMOTE (Deployment)\n";
        echo "========================================================\n\n";
        testDb('REMOTE (Deployment)', $config['connections']['remote']);
        break;

    case 'remove-local':
        updateEnvKey($envFile, 'DB_TARGET', 'remote');
        echo "========================================================\n";
        echo " Preparing for Deployment: Removed Local Target\n";
        echo "========================================================\n";
        echo "[+] Set DB_TARGET=remote in .env\n";
        echo "[+] The application will now strictly use the remote deployment database.\n";
        echo "[+] To permanently remove the local testing code from PHP:\n";
        echo "    Simply delete the marked [LOCAL INTEGRATION BLOCK] inside config/database.php.\n\n";
        testDb('REMOTE (Deployment)', $config['connections']['remote']);
        break;

    case 'status':
    default:
        $activeTarget = strtoupper($config['target'] ?? 'UNKNOWN');
        echo "========================================================\n";
        echo " Database Environment Status | ACTIVE: [{$activeTarget}]\n";
        echo "========================================================\n\n";
        testDb('LOCAL DB [erp / root]', $config['connections']['local']);
        testDb('REMOTE DB [groott_o1_student / groott_o1_shantanu]', $config['connections']['remote']);
        echo "Commands to switch:\n";
        echo "  php database/switch_db.php local   # Switch to local erp/root\n";
        echo "  php database/switch_db.php remote  # Switch to remote deployment\n";
        echo "  php database/switch_db.php remove-local # Remove local and use remote exclusively\n";
        break;
}
