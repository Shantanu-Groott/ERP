<?php

return [
    'mailer' => getenv('MAIL_MAILER') ?: 'smtp',
    'host' => getenv('MAIL_HOST') ?: 'smtp.mailtrap.io',
    'port' => (int)(getenv('MAIL_PORT') ?: 2525),
    'username' => getenv('MAIL_USERNAME') ?: null,
    'password' => getenv('MAIL_PASSWORD') ?: null,
    'encryption' => getenv('MAIL_ENCRYPTION') ?: 'tls',
    'from' => [
        'address' => getenv('MAIL_FROM_ADDRESS') ?: 'no-reply@erp.local',
        'name' => getenv('MAIL_FROM_NAME') ?: 'Kalavanta Edutech ERP',
    ],
];
