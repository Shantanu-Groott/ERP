<?php

namespace App\Core;

class Response
{
    private int $statusCode = 200;
    private array $headers = [];

    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;
        http_response_code($code);
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        header("{$name}: {$value}");
        return $this;
    }

    public function redirect(string $url, int $statusCode = 302): void
    {
        $this->setStatusCode($statusCode);

        if (str_starts_with($url, '/')) {
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            $baseDir = str_replace('\\', '/', dirname($scriptName));
            if ($baseDir !== '/' && $baseDir !== '.' && $baseDir !== '') {
                if (str_ends_with($baseDir, '/public')) {
                    $baseDir = dirname($baseDir);
                }
                if ($baseDir !== '/' && $baseDir !== '.' && !str_starts_with($url, $baseDir)) {
                    $url = rtrim($baseDir, '/') . $url;
                }
            }
        }

        header("Location: {$url}");
        exit;
    }

    public function json(array $data, int $statusCode = 200): void
    {
        $this->setStatusCode($statusCode);
        $this->setHeader('Content-Type', 'application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
}
