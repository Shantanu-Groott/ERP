<?php

// ----------------------------------------------------
// Single Front Controller & Bootstrap Entry Point
// ----------------------------------------------------

define('APP_START', microtime(true));
define('ROOT_PATH', dirname(__DIR__));

// Load .env variables if present
if (file_exists(ROOT_PATH . '/.env')) {
    $lines = file(ROOT_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
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

// Register PSR-4 Autoloader (Native fallback if Composer vendor/autoload isn't run yet)
if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
} else {
    spl_autoload_register(function ($class) {
        $prefix = 'App\\';
        $baseDir = ROOT_PATH . '/app/';

        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
        }
    });
}

// Start Session handling
\App\Core\Session::start();

// Initialize HTTP Context & Routing
$request = new \App\Core\Request();
$response = new \App\Core\Response();
$router = new \App\Core\Router($request, $response);

// Load Web Routes & Dispatch
require ROOT_PATH . '/routes/web.php';

try {
    $router->dispatch();
} catch (\Throwable $e) {
    if (filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOLEAN)) {
        http_response_code(500);
        echo "<h1>Application Error</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    } else {
        $response->setStatusCode(500);
        \App\Core\View::render('errors.500', [
            'title' => 'Server Error',
            'message' => 'An error occurred while processing your request.'
        ]);
    }
}
