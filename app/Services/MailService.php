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

        // If local development or SMTP without extension, record to log
        $logPath = dirname(dirname(__DIR__)) . '/storage/logs/mail.log';
        $logEntry = sprintf(
            "[%s] TO: %s | SUBJECT: %s\nBODY:\n%s\n----------------------------------------\n",
            date('Y-m-d H:i:s'),
            $to,
            $subject,
            $body
        );
        @file_put_contents($logPath, $logEntry, FILE_APPEND);

        // Native PHP mail fallback
        if (!empty($instance->config['host']) && $instance->config['mailer'] === 'native') {
            return @mail($to, $subject, $body, implode("\r\n", $headers));
        }

        return true;
    }
}
