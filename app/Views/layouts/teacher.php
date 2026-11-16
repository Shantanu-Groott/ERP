<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Teacher Area') ?> - Kalavanta Edutech ERP</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand" style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px;">
                <div style="background: #ffffff; padding: 6px 10px; border-radius: 8px; width: 100%;">
                    <img src="/assets/img/logo.png" alt="Kalavanta Edutech" style="max-height: 38px; max-width: 100%; display: block;">
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <span style="font-size: 0.85rem; color: #94a3b8;">Kalavanta ERP</span>
                    <span class="badge" style="background:#0ea5e9;">TEACHER</span>
                </div>
            </div>
            <ul class="nav-links">
                <li><a href="/teacher/dashboard" class="<?= strpos($_SERVER['REQUEST_URI'], '/teacher/dashboard') !== false ? 'active' : '' ?>">📊 Overview</a></li>
                <li><a href="/teacher/attendance" class="<?= strpos($_SERVER['REQUEST_URI'], '/teacher/attendance') !== false ? 'active' : '' ?>">📅 Mark Attendance</a></li>
                <li><a href="/teacher/marks" class="<?= strpos($_SERVER['REQUEST_URI'], '/teacher/marks') !== false ? 'active' : '' ?>">📝 Enter Marks</a></li>
            </ul>
            <div class="user-badge">
                <div class="info">
                    <div class="name"><?= htmlspecialchars(\App\Core\Session::get('user_name', 'Teacher')) ?></div>
                    <div class="role">Faculty Staff</div>
                </div>
                <a href="/logout" title="Logout" style="color: #94a3b8; text-decoration: none; font-size: 1.1rem;">🚪</a>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <header class="topbar">
                <h3 style="font-size: 1.1rem; color: #1e293b;"><?= htmlspecialchars($title ?? 'Teacher Workspace') ?></h3>
                <div>
                    <span style="font-size: 0.85rem; color: #64748b;"><?= date('l, F j, Y') ?></span>
                </div>
            </header>
            <main class="content-body">
                <?= $content ?>
            </main>
        </div>
    </div>
    <script src="/assets/js/app.js"></script>
</body>
</html>
