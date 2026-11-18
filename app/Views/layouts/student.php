<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Student Dashboard') ?> - Kalavanta Edutech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;0,6..72,600;1,6..72,400&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-sage: #e8efe9;
            --bg-surface: #f4f7f4;
            --sidebar-bg: #ffffffff;
            --card-bg: #ffffff;
            --card-muted: #f7faf7;
            --text-dark: #1e2d24;
            --text-muted: #5e7164;
            --primary-green: #2d6a4f;
            --primary-hover: #1b4332;
            --accent-green: #40916c;
            --pill-active: #d8e5d8;
            --pill-green: #d1e7dd;
            --border-sage: #d5e0d5;
            --border-light: #e5ede5;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-sage);
            color: var(--text-dark);
            height: 100vh;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .font-serif {
            font-family: 'Newsreader', serif;
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Outer Layout */
        .portal-layout {
            display: flex;
            width: 100%;
            height: 100vh;
            max-height: 100vh;
            overflow: hidden;
            gap: 0;
        }

        /* Sage Minimal Sidebar (Full Screen Height & Scroll-Locked) */
        .portal-sidebar {
            width: 250px;
            height: 100vh;
            max-height: 100vh;
            background: var(--sidebar-bg);
            margin: 0;
            padding: 24px 16px 18px 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-shrink: 0;
            border-right: 1px solid var(--border-sage);
            border-top: none;
            border-bottom: none;
            border-left: none;
            border-radius: 0;
            position: sticky;
            top: 0;
            left: 0;
            z-index: 50;
            overflow: hidden;
        }

        .sidebar-inner-top {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0;
            overflow: hidden;
        }

        .sidebar-nav-container {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overscroll-behavior: contain;
            padding-right: 4px;
            scrollbar-width: thin;
            scrollbar-color: #c4d4c4 transparent;
        }

        .sidebar-nav-container::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav-container::-webkit-scrollbar-thumb {
            background-color: #c4d4c4;
            border-radius: 4px;
        }

        .sidebar-nav-container::-webkit-scrollbar-track {
            background: transparent;
        }

        /* User Profile Pill at top of sidebar */
        .user-profile-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding: 4px;
        }

        .avatar-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #2d6a4f;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }

        .user-meta-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .user-badges-row {
            display: flex;
            gap: 6px;
            margin-top: 4px;
        }

        .pill-tag {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 9999px;
            letter-spacing: 0.5px;
        }

        .pill-premium {
            background: #d8e5d8;
            color: #244833;
        }

        .pill-role {
            background: #cce3d4;
            color: #1b4332;
        }

        /* Green Primary Action Button (+ New Diagram) */
        .btn-sidebar-action {
            width: 100%;
            padding: 12px 16px;
            background: #347a57;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            font-size: 0.88rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(52, 122, 87, 0.25);
            transition: all 0.2s ease;
            text-decoration: none;
            margin-bottom: 22px;
        }

        .btn-sidebar-action:hover {
            background: #285f43;
            transform: translateY(-1px);
        }

        /* Navigation List */
        .sidebar-nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.15s ease;
        }

        .sidebar-nav-item a:hover {
            color: var(--text-dark);
            background: rgba(216, 229, 216, 0.5);
        }

        .sidebar-nav-item.active a {
            color: #173827;
            background: var(--pill-active);
            font-weight: 700;
        }

        .sidebar-nav-item svg {
            width: 19px;
            height: 19px;
            stroke-width: 1.8;
            color: currentColor;
        }

        /* Bottom Settings link */
        .sidebar-bottom {
            padding-top: 16px;
            border-top: 1px solid var(--border-sage);
        }

        .sidebar-bottom a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.84rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.15s ease;
        }

        .sidebar-bottom a svg {
            width: 14px;
            height: 14px;
            stroke-width: 2;
            color: currentColor;
            flex-shrink: 0;
            opacity: 0.85;
            transition: transform 0.15s ease;
        }

        .sidebar-bottom a:hover {
            color: var(--text-dark);
            background: rgba(216, 229, 216, 0.5);
        }

        .sidebar-bottom a:hover svg {
            transform: translateX(2px);
            opacity: 1;
        }

        /* Main Workspace Canvas */
        .portal-canvas {
            flex: 1;
            height: 100vh;
            max-height: 100vh;
            background: var(--bg-sage);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: #cbd5cb transparent;
        }

        .portal-canvas::-webkit-scrollbar {
            width: 6px;
        }

        .portal-canvas::-webkit-scrollbar-thumb {
            background-color: #cbd5cb;
            border-radius: 4px;
        }

        .portal-canvas::-webkit-scrollbar-track {
            background: transparent;
        }

        /* Canvas Top Header Row */
        .canvas-topbar {
            padding: 24px 36px 12px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .canvas-title-group h1 {
            font-size: 2.2rem;
            font-weight: 500;
            color: #183324;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-pill-container {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .search-pill-box {
            background: #ffffff;
            border: 1px solid var(--border-sage);
            border-radius: 14px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 260px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        .search-pill-box input {
            border: none;
            outline: none;
            font-size: 0.85rem;
            color: var(--text-dark);
            width: 100%;
            background: transparent;
        }

        .search-pill-box input::placeholder {
            color: #8c9e91;
        }

        .icon-notification-btn {
            background: #ffffff;
            border: 1px solid var(--border-sage);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .icon-notification-btn:hover {
            color: var(--text-dark);
            background: #eef3ee;
        }

        /* Content Body Wrapper */
        .canvas-content {
            padding: 16px 36px 36px 36px;
            flex: 1;
        }

        @media (max-width: 1024px) {
            .portal-layout {
                flex-direction: column;
                height: auto;
                max-height: none;
                overflow: visible;
                padding: 0;
            }
            .portal-sidebar {
                width: 100%;
                height: auto;
                max-height: none;
                border-radius: 0;
                border-right: none;
                border-bottom: 1px solid var(--border-sage);
                position: static;
                overflow: visible;
            }
            .sidebar-inner-top {
                overflow: visible;
            }
            .sidebar-nav-container {
                overflow: visible;
            }
            .portal-canvas {
                height: auto;
                max-height: none;
                overflow: visible;
            }
            .canvas-topbar {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
            }
            .canvas-content {
                padding: 16px 20px 24px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="portal-layout">
        
        <!-- Left Sage Minimal Sidebar (Full Height & Scroll-Locked) -->
        <aside class="portal-sidebar">
            <div class="sidebar-inner-top">
                <!-- Brand Header Matching Mockup -->
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 22px; padding: 2px 2px;">
                    <a href="/student/dashboard" style="display: flex; align-items: center; gap: 9px; text-decoration: none;">
                        <img src="/assets/img/logo.png" alt="Kalavanta" style="height: 28px; width: auto; object-fit: contain;">
                    </a>
                </div>

                <!-- User Profile Pill (Clickable link to profile) -->
                <a href="/student/profile" class="user-profile-header" style="text-decoration: none; display: flex; align-items: center; gap: 12px; margin-bottom: 20px; padding: 6px; border-radius: 12px; transition: background 0.15s ease;" title="View Student Profile">
                    <div class="avatar-circle">
                        <?= htmlspecialchars(strtoupper(substr((string)\App\Core\Session::get('user_name', 'S'), 0, 1))) ?>
                    </div>
                    <div>
                        <div class="user-meta-name">
                            <?= htmlspecialchars(\App\Core\Session::get('user_name', 'Shantanu')) ?>
                        </div>
                        <div style="font-size: 0.72rem; color: #627467; font-weight: 600; margin-top: 1px;">
                            Student Profile &rarr;
                        </div>
                    </div>
                </a>

                <!-- Green New Diagram Button -->
                <a href="/student/curriculum" class="btn-sidebar-action">
                    <span style="font-size: 1.1rem; line-height: 1;">+</span>
                    <span>New Study Lab</span>
                </a>

                <!-- Scroll-Locked Navigation Container -->
                <div class="sidebar-nav-container">
                    <?php $currentUri = $_SERVER['REQUEST_URI'] ?? ''; ?>
                    <ul class="sidebar-nav-list">
                        <li class="sidebar-nav-item <?= strpos($currentUri, '/student/dashboard') !== false ? 'active' : '' ?>">
                            <a href="/student/dashboard">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-nav-item <?= strpos($currentUri, '/student/curriculum') !== false ? 'active' : '' ?>">
                            <a href="/student/curriculum">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <span>Curriculum</span>
                            </a>
                        </li>
                        <li class="sidebar-nav-item <?= strpos($currentUri, '/student/attendance') !== false ? 'active' : '' ?>">
                            <a href="/student/attendance">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Attendance Log</span>
                            </a>
                        </li>
                        <li class="sidebar-nav-item <?= strpos($currentUri, '/student/results') !== false ? 'active' : '' ?>">
                            <a href="/student/results">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Exam Grades</span>
                            </a>
                        </li>
                        <li class="sidebar-nav-item <?= strpos($currentUri, '/student/notices') !== false ? 'active' : '' ?>">
                            <a href="/student/notices">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span>Notices</span>
                            </a>
                        </li>
                        <li class="sidebar-nav-item <?= strpos($currentUri, '/student/certificate') !== false ? 'active' : '' ?>">
                            <a href="/student/certificate">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>Certificate</span>
                            </a>
                        </li>
                        <li class="sidebar-nav-item <?= strpos($currentUri, '/student/openings') !== false ? 'active' : '' ?>">
                            <a href="/student/openings">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>Openings</span>
                            </a>
                        </li>
                        <li class="sidebar-nav-item <?= strpos($currentUri, '/student/projects') !== false ? 'active' : '' ?>">
                            <a href="/student/projects">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span>Projects</span>
                            </a>
                        </li>
                        <li class="sidebar-nav-item <?= strpos($currentUri, '/student/live-class') !== false ? 'active' : '' ?>">
                            <a href="/student/live-class" style="color: #b91c1c;">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Live Lab 🔴</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Settings / Logout -->
            <div class="sidebar-bottom" style="display: flex; align-items: center; justify-content: space-between; gap: 8px; padding-top: 14px; border-top: 1px solid #dbe5db;">
                <a href="/student/profile" style="display: inline-flex; align-items: center; gap: 8px; color: #3b5343; text-decoration: none; font-size: 0.84rem; font-weight: 600;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Settings</span>
                </a>

                <form action="/logout" method="POST" style="margin: 0; padding: 0; display: inline;">
                    <?= \App\Core\Csrf::field() ?>
                    <button type="submit" title="Sign out" style="display: inline-flex; align-items: center; gap: 5px; color: #843030; text-decoration: none; font-size: 0.76rem; font-weight: 600; padding: 4px 8px; border-radius: 6px; background: rgba(132, 48, 48, 0.08); border: none; cursor: pointer; font-family: inherit;">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Exit</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace Canvas -->
        <main class="portal-canvas">
            
            <!-- Topbar with Serife Title & Search Pill -->
            <header class="canvas-topbar">
                <div class="canvas-title-group">
                    <?php if (!empty($headerTitle)): ?>
                        <div style="display: flex; align-items: flex-start; gap: 10px;">
                            <?php if (!empty($backUrl)): ?>
                                <a href="<?= htmlspecialchars($backUrl) ?>" style="color: #183324; text-decoration: none; font-size: 1.25rem; font-weight: 700; line-height: 1.2; margin-top: 2px;" title="Back">&larr;</a>
                            <?php endif; ?>
                            <div>
                                <h1 class="font-serif" style="margin: 0; line-height: 1.2;">
                                    <?= htmlspecialchars($headerTitle) ?>
                                </h1>
                                <?php if (!empty($headerSubtitle)): ?>
                                    <p style="font-size: 0.8rem; color: #627467; margin: 3px 0 0 0; font-weight: 500;">
                                        <?= htmlspecialchars($headerSubtitle) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <h1 class="font-serif">
                            Welcome back, <?= htmlspecialchars(explode(' ', (string)\App\Core\Session::get('user_name', 'Shantanu'))[0]) ?>!
                            <span style="font-size: 1.8rem;">👋</span>
                        </h1>
                    <?php endif; ?>
                </div>

                <div class="search-pill-container">
                    <div class="search-pill-box">
                        <svg width="16" height="16" fill="none" stroke="#718576" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" placeholder="<?= !empty($searchPlaceholder) ? htmlspecialchars($searchPlaceholder) : 'Search courses, labs, modules...' ?>">
                    </div>
                    
                    <a href="/student/notices" class="icon-notification-btn" title="Notices">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Page Body -->
            <div class="canvas-content">
                <?= $content ?>
            </div>
        </main>

    </div>

    <script src="/assets/js/app.js"></script>
</body>
</html>
