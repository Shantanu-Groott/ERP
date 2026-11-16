<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? '404 Not Found') ?> - Kalavanta Edutech ERP</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: #f8fafc;
            text-align: center;
            padding: 20px;
        }
        .error-box {
            background: #fff;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            max-width: 500px;
            width: 100%;
        }
        .error-code {
            font-size: 5rem;
            font-weight: 800;
            color: #4f46e5;
            line-height: 1;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <div class="error-code">404</div>
        <h2 style="margin: 15px 0 10px;">Page Not Found</h2>
        <p style="color: #64748b; margin-bottom: 24px;"><?= htmlspecialchars($message ?? 'The page or resource you are looking for does not exist.') ?></p>
        <a href="/login" class="btn btn-primary">Return to Portal</a>
    </div>
</body>
</html>
