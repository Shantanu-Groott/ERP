<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Sign In') ?> - Kalavanta Edutech ERP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            background: #173827 url('/assets/img/auth-bg.jpg') no-repeat center center / cover;
            position: relative;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Subtle dark gradient overlay to guarantee perfect contrast */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 75% 50%, rgba(13, 39, 26, 0.45) 0%, rgba(9, 28, 19, 0.82) 100%);
            z-index: 1;
        }

        .auth-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 36px 64px 28px 64px;
        }

        /* Top Brand Header */
        .auth-top-header {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            background: rgba(255, 255, 255, 0.95);
            padding: 8px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(8px);
        }

        .brand-badge img {
            height: 38px;
            width: auto;
            display: block;
        }

        .brand-badge-divider {
            width: 1px;
            height: 22px;
            background: #cbd5e1;
        }

        .brand-badge-tag {
            font-size: 0.85rem;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #1b4d3e;
            text-transform: uppercase;
        }

        /* Center Grid Layout: Left Hero Title & Right White Card */
        .auth-main-grid {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 48px;
            margin: auto 0;
            width: 100%;
        }

        .auth-hero-text {
            flex: 1;
            max-width: 580px;
        }

        .auth-hero-text h1 {
            font-size: 3.25rem;
            font-weight: 800;
            line-height: 1.18;
            color: #ffffff;
            text-shadow: 0 4px 18px rgba(0, 0, 0, 0.35);
            letter-spacing: -0.5px;
        }

        .auth-hero-text p {
            margin-top: 18px;
            font-size: 1.15rem;
            line-height: 1.6;
            color: #d1fae5;
            font-weight: 400;
            max-width: 480px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        }

        /* Clean White Card from theme */
        .auth-card-container {
            width: 100%;
            max-width: 640px;
            flex-shrink: 0;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 48px 46px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.4), 0 0 1px 1px rgba(255, 255, 255, 0.1);
            color: #1e293b;
        }

        .auth-card-header h2 {
            font-size: 1.85rem;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.5px;
        }

        .auth-card-header p {
            color: #64748b;
            font-size: 0.925rem;
            margin-top: 6px;
            margin-bottom: 24px;
        }

        /* Social / Google button from reference */
        .btn-google {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 12px 18px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-google:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .separator-text {
            display: flex;
            align-items: center;
            text-align: center;
            color: #94a3b8;
            font-size: 0.8rem;
            font-weight: 500;
            margin: 22px 0;
        }

        .separator-text::before,
        .separator-text::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .separator-text::before { margin-right: 14px; }
        .separator-text::after { margin-left: 14px; }

        /* Form Inputs matching theme */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-icon-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 16px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .input-field {
            width: 100%;
            padding: 13px 44px 13px 46px;
            font-size: 0.95rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            outline: none;
            color: #1e293b;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .input-field:focus {
            border-color: #155e42;
            box-shadow: 0 0 0 4px rgba(21, 94, 66, 0.12);
        }

        .input-field::placeholder {
            color: #94a3b8;
        }

        .btn-toggle-eye {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 4px;
            transition: color 0.2s;
        }

        .btn-toggle-eye:hover {
            color: #155e42;
        }

        .form-options-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-top: 8px;
            margin-bottom: 24px;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #155e42;
            text-decoration: underline;
        }

        /* Solid Theme Button */
        .btn-theme-submit {
            width: 100%;
            padding: 14px 20px;
            background: #1b4d3e;
            background: linear-gradient(135deg, #1b4d3e 0%, #154335 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(21, 67, 53, 0.35);
            transition: all 0.2s ease;
        }

        .btn-theme-submit:hover {
            background: linear-gradient(135deg, #164033 0%, #0f3328 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(21, 67, 53, 0.45);
        }

        .btn-theme-submit:active {
            transform: translateY(0);
        }

        /* Bottom Footer */
        .auth-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.65);
        }

        /* Quick hints / Demo Credentials badge */
        .demo-credentials-box {
            margin-top: 22px;
            padding: 14px 16px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px dashed #cbd5e1;
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.6;
        }

        .demo-credentials-box strong {
            color: #1e293b;
        }

        .demo-credentials-box code {
            background: #e2e8f0;
            padding: 2px 6px;
            border-radius: 4px;
            color: #1b4d3e;
            font-weight: 600;
            font-family: monospace;
        }

        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 20px;
        }
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .auth-hero-text h1 {
                font-size: 2.6rem;
            }
            .auth-wrapper {
                padding: 28px 32px 20px 32px;
            }
        }

        @media (max-width: 860px) {
            .auth-main-grid {
                flex-direction: column;
                justify-content: center;
                gap: 32px;
            }
            .auth-hero-text {
                text-align: center;
                max-width: 100%;
            }
            .auth-hero-text p {
                margin: 10px auto 0 auto;
            }
            .auth-card-container {
                max-width: 440px;
                margin: 0 auto;
            }
            .auth-footer {
                flex-direction: column;
                gap: 8px;
                text-align: center;
                margin-top: 20px;
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 30px 22px;
            }
            .auth-hero-text h1 {
                font-size: 2rem;
            }
            .auth-wrapper {
                padding: 20px 18px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <!-- Top Left Brand Icon -->
        <header class="auth-top-header">
            <div class="brand-badge">
                <img src="/assets/img/logo.png" alt="Kalavanta Edutech">
                <div class="brand-badge-divider"></div>
                <span class="brand-badge-tag">ERP</span>
            </div>
        </header>

        <!-- Main Center Area -->
        <main class="auth-main-grid">
            <div class="auth-hero-text">
                <h1>Everything you need to manage Kalavanta Edutech</h1>
                <p>Unified enterprise academic management, live attendance, examination gradebooks, and real-time operations.</p>
            </div>

            <div class="auth-card-container">
                <div class="auth-card">
                    <?= $content ?>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="auth-footer">
            <span>&copy; <?= date('Y') ?> Kalavanta Edutech. All Rights Reserved.</span>
            <span>Ver. 3.0</span>
        </footer>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                if (icon) {
                    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
                }
            } else {
                input.type = 'password';
                if (icon) {
                    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                }
            }
        }
    </script>
</body>
</html>
