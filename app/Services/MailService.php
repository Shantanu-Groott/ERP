<?php

namespace App\Services;

class MailService
{
    private array $config;

    public function __construct()
    {
        $this->config = require dirname(dirname(__DIR__)) . '/config/mail.php';
    }

    public static function send(string $to, string $subject, string $body): bool
    {
        $instance = new self();
        
        $from = $instance->config['from']['address'];
        $fromName = $instance->config['from']['name'];

        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=utf-8',
            "From: {$fromName} <{$from}>",
            "Reply-To: {$from}",
            'X-Mailer: PHP/' . phpversion()
        ];

        // Record sanitized delivery metadata to log (Tokens, URLs, and email bodies are excluded for security)
        $logDir = dirname(dirname(__DIR__)) . '/storage/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0700, true);
        }
        $logPath = $logDir . '/mail.log';
        $sanitizedSubject = preg_replace('/(token|code|key|secret)[=:\s]+[a-zA-Z0-9_\-\.]{8,}/i', '$1=[REDACTED]', strip_tags($subject));
        $sanitizedSubject = preg_replace('/https?:\/\/\S+/i', '[REDACTED_URL]', $sanitizedSubject);
        $logEntry = sprintf(
            "[%s] DISPATCHED | TO: %s | SUBJECT: %s\n",
            date('Y-m-d H:i:s'),
            filter_var($to, FILTER_SANITIZE_EMAIL),
            $sanitizedSubject
        );
        @file_put_contents($logPath, $logEntry, FILE_APPEND);
        if (file_exists($logPath)) {
            @chmod($logPath, 0600);
        }

        // Native PHP mail fallback
        if (!empty($instance->config['host']) && $instance->config['mailer'] === 'native') {
            return @mail($to, $subject, $body, implode("\r\n", $headers));
        }

        return true;
    }
}
