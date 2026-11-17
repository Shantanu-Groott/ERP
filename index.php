<?php

/**
 * Kalavanta Edutech ERP - Built-in Server Router & Front Proxy
 *
 * Allows running the server from the project root using ANY of:
 *   1) php -S localhost:8000 -t public   (Standard production/dev command)
 *   2) php -S localhost:8000 index.php  (Router script mode)
 *   3) php -S localhost:8000            (Default root mode)
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');
$publicPath = __DIR__ . '/public';
$targetFile = $publicPath . $uri;

// Serve static assets located inside public/
if ($uri !== '/' && file_exists($targetFile) && !is_dir($targetFile)) {
    $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $mimes = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'json'  => 'application/json',
        'pdf'   => 'application/pdf',
    ];
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
    }
    readfile($targetFile);
    exit;
}

// Forward to front controller in public/index.php
$_SERVER['DOCUMENT_ROOT'] = $publicPath;
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $publicPath . '/index.php';

require_once $publicPath . '/index.php';
