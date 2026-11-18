<?php
/**
 * Kalavanta Edutech - Student Notices & Academic Bulletins Desk
 * Matches Brand Aesthetic:
 *  1. Top 4 Metric Overview Cards (Total, Urgent/Deadlines, Examinations, Career/Competitions)
 *  2. Featured / Pinned Latest Circular Banner
 *  3. Interactive Category Filter Pills (All, Urgent, Exam, Career, Academic, System)
 *  4. Real-time Live Search (Client-side instant filter by title, body, ref no, department)
 *  5. Responsive Circulars Grid (Card layout with category badges, priority indicators, ref no, excerpt)
 *  6. Official Kalavanta Edutech Circular Reading Modal (Full text, verified digital seal, print & copy link)
 */

$totalCirculars = count($notices);
$featuredNotice = !empty($notices) ? $notices[0] : null;
$categoryCounts = $counts ?? [
    'all' => $totalCirculars,
    'important' => 0,
    'exam' => 0,
    'career' => 0,
    'academic' => 0,
    'system' => 0,
];
?>

<div class="notices-page-container" style="display: flex; flex-direction: column; gap: 24px;">

    <!-- ==================================================== -->
    <!-- 1. TOP 4 METRIC OVERVIEW CARDS                       -->
    <!-- ==================================================== -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px;">
        
        <!-- Card 1: Total Bulletins -->
        <div class="metric-card" style="background: #ffffff; border: 1px solid #d9ebd9; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #eaf5ee; color: #2d6a4f; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <!-- Megaphone / Bulletin Icon -->
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 600; color: #627467;">Active Circulars</span>
                </div>
                <div style="font-size: 1.55rem; font-weight: 800; color: #183324; margin: 8px 0 2px 0; font-variant-numeric: tabular-nums; line-height: 1;">
                    <?= $categoryCounts['all'] ?>
                </div>
                <div style="font-size: 0.72rem; color: #2d6a4f; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #2d6a4f; display: inline-block;"></span>
                    Institutional Desk Live
                </div>
            </div>
            <!-- Bell Icon -->
            <div style="flex-shrink: 0; color: #b7d6bf;">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
            </div>
        </div>

        <!-- Card 2: Urgent / High Priority -->
        <div class="metric-card" style="background: #ffffff; border: 1px solid #fee2e2; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <!-- Alert / Warning Icon -->
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 600; color: #627467;">Urgent &amp; Action</span>
                </div>
                <div style="font-size: 1.55rem; font-weight: 800; color: #991b1b; margin: 8px 0 2px 0; font-variant-numeric: tabular-nums; line-height: 1;">
                    <?= $categoryCounts['important'] ?>
                </div>
                <div style="font-size: 0.72rem; color: #dc2626; font-weight: 700;">
                    Deadlines &amp; Reviews
                </div>
            </div>
            <!-- Alert Badge Icon -->
            <div style="flex-shrink: 0; color: #fca5a5;">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
            </div>
        </div>

        <!-- Card 3: Examinations -->
        <div class="metric-card" style="background: #ffffff; border: 1px solid #dbeafe; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #eff6ff; color: #1d4ed8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <!-- Calendar / Exam Icon -->
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 600; color: #627467;">Examinations</span>
                </div>
                <div style="font-size: 1.55rem; font-weight: 800; color: #1e3a8a; margin: 8px 0 2px 0; font-variant-numeric: tabular-nums; line-height: 1;">
                    <?= $categoryCounts['exam'] ?>
                </div>
                <div style="font-size: 0.72rem; color: #2563eb; font-weight: 700;">
                    Hall Tickets &amp; Timetables
                </div>
            </div>
            <!-- Calendar Icon -->
            <div style="flex-shrink: 0; color: #bfdbfe;">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>

        <!-- Card 4: Career & Competitions -->
        <div class="metric-card" style="background: #ffffff; border: 1px solid #f3e8ff; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #faf5ff; color: #7e22ce; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <!-- Briefcase / Trophy Icon -->
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 600; color: #627467;">Campus Drives</span>
                </div>
                <div style="font-size: 1.55rem; font-weight: 800; color: #581c87; margin: 8px 0 2px 0; font-variant-numeric: tabular-nums; line-height: 1;">
                    <?= $categoryCounts['career'] ?>
                </div>
                <div style="font-size: 0.72rem; color: #7e22ce; font-weight: 700;">
                    Hackathons &amp; Internships
                </div>
            </div>
            <!-- Star Icon -->
            <div style="flex-shrink: 0; color: #e9d5ff;">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
        </div>

    </div>

    <!-- ==================================================== -->
    <!-- 2. PINNED / FEATURED LATEST BULLETIN BANNER           -->
    <!-- ==================================================== -->
    <?php if ($featuredNotice): ?>
        <div class="featured-bulletin-card" style="background: linear-gradient(135deg, #ffffff 0%, #f4f8f5 100%); border: 1px solid #d7e8db; border-radius: 22px; padding: 24px 28px; box-shadow: 0 3px 12px rgba(28,75,50,0.04); position: relative; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
                <div style="max-width: 740px;">
                    <!-- Badge row -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;">
                        <span style="display: inline-flex; align-items: center; gap: 6px; background: #1c4b32; color: #ffffff; font-size: 0.7rem; font-weight: 700; padding: 3px 10px; border-radius: 999px; letter-spacing: 0.4px;">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #4ade80; animation: pulseDot 2s infinite;"></span>
                            LATEST CIRCULAR
                        </span>
                        <span style="background: <?= $featuredNotice['badge_bg'] ?>; color: <?= $featuredNotice['badge_color'] ?>; font-size: 0.72rem; font-weight: 700; padding: 3px 9px; border-radius: 999px;">
                            <?= $featuredNotice['category_label'] ?>
                        </span>
                        <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; color: #627467; font-weight: 600;">
                            <?= $featuredNotice['ref_no'] ?>
                        </span>
                        <span style="font-size: 0.74rem; color: #718576; font-weight: 500;">
                            &bull; Issued <?= $featuredNotice['formatted_date'] ?>
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #183324; margin: 0 0 8px 0; line-height: 1.35; letter-spacing: -0.2px;">
                        <?= htmlspecialchars($featuredNotice['title']) ?>
                    </h3>

                    <!-- Body Excerpt -->
                    <p style="font-size: 0.84rem; color: #475a4d; line-height: 1.55; margin: 0 0 14px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <?= htmlspecialchars(strip_tags($featuredNotice['body'])) ?>
                    </p>

                    <!-- Meta Tags -->
                    <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap; font-size: 0.74rem; color: #627467;">
                        <div style="display: inline-flex; align-items: center; gap: 5px;">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#2d6a4f" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span><?= htmlspecialchars($featuredNotice['department']) ?></span>
                        </div>
                        <div style="display: inline-flex; align-items: center; gap: 5px;">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#2d6a4f" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span><?= htmlspecialchars($featuredNotice['audience_label']) ?></span>
                        </div>
                        <div style="display: inline-flex; align-items: center; gap: 5px; color: #2d6a4f; font-weight: 700;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Verified Circular</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div style="display: flex; flex-direction: column; gap: 8px; align-self: center; flex-shrink: 0;">
                    <button type="button" class="btn-read-featured" 
                            onclick="openNoticeModal(<?= htmlspecialchars(json_encode($featuredNotice), ENT_QUOTES, 'UTF-8') ?>)"
                            style="background: #1c4b32; color: #ffffff; border: none; padding: 10px 22px; border-radius: 999px; font-weight: 700; font-size: 0.84rem; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; font-family: inherit; transition: all 0.15s ease; box-shadow: 0 2px 6px rgba(28,75,50,0.25);">
                        <span>Read Circular</span>
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                    <button type="button" 
                            onclick="printSpecificNotice(<?= htmlspecialchars(json_encode($featuredNotice), ENT_QUOTES, 'UTF-8') ?>)"
                            style="background: #eaf1eb; color: #1c4b32; border: 1px solid #d0e0d3; padding: 8px 18px; border-radius: 999px; font-weight: 600; font-size: 0.78rem; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; font-family: inherit; transition: background 0.15s ease;">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span>Print Circular</span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ==================================================== -->
    <!-- 3. INTERACTIVE FILTER PILLS & LIVE SEARCH BAR        -->
    <!-- ==================================================== -->
    <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 20px; padding: 16px 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
        
        <!-- Category Filter Pills -->
        <div class="notice-filter-pills" style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
            <button type="button" class="filter-pill-btn active" data-filter="all" onclick="setNoticeFilter('all', this)">
                All Circulars <span class="pill-count"><?= $categoryCounts['all'] ?></span>
            </button>
            <button type="button" class="filter-pill-btn" data-filter="important" onclick="setNoticeFilter('important', this)">
                Urgent / Deadlines <span class="pill-count"><?= $categoryCounts['important'] ?></span>
            </button>
            <button type="button" class="filter-pill-btn" data-filter="exam" onclick="setNoticeFilter('exam', this)">
                Examinations <span class="pill-count"><?= $categoryCounts['exam'] ?></span>
            </button>
            <button type="button" class="filter-pill-btn" data-filter="career" onclick="setNoticeFilter('career', this)">
                Career &amp; Events <span class="pill-count"><?= $categoryCounts['career'] ?></span>
            </button>
            <button type="button" class="filter-pill-btn" data-filter="academic" onclick="setNoticeFilter('academic', this)">
                Academic &amp; Syllabus <span class="pill-count"><?= $categoryCounts['academic'] ?></span>
            </button>
            <button type="button" class="filter-pill-btn" data-filter="system" onclick="setNoticeFilter('system', this)">
                Infrastructure <span class="pill-count"><?= $categoryCounts['system'] ?></span>
            </button>
        </div>

        <!-- Real-Time Live Search Input -->
        <div style="position: relative; min-width: 260px; max-width: 320px; flex: 1;">
            <svg width="15" height="15" fill="none" stroke="#718576" viewBox="0 0 24 24" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%);">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" id="noticeSearchFilter" placeholder="Filter by keyword, title, ref..." 
                   oninput="filterNoticesRealtime()"
                   style="width: 100%; padding: 8px 34px 8px 38px; border-radius: 999px; border: 1px solid #dbe5dc; background: #f7faf7; font-size: 0.82rem; color: #183324; font-family: inherit; outline: none; transition: all 0.15s ease;">
            <button type="button" id="clearSearchBtn" onclick="clearNoticeSearch()" style="display: none; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); border: none; background: transparent; color: #718576; cursor: pointer; font-size: 0.9rem; line-height: 1;">&times;</button>
        </div>

    </div>

    <!-- Active Count Counter -->
    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.78rem; color: #627467; padding: 0 4px;">
        <span>Showing <strong id="visibleNoticesCount" style="color: #183324;"><?= count($notices) ?></strong> of <?= count($notices) ?> circulars</span>
        <span style="display: flex; align-items: center; gap: 6px;">
            <span style="width: 7px; height: 7px; border-radius: 50%; background: #2d6a4f;"></span>
            Auto-synchronized with Academic Registrar
        </span>
    </div>

    <!-- ==================================================== -->
    <!-- 4. CIRCULARS GRID                                    -->
    <!-- ==================================================== -->
    <div id="noticesGridContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(330px, 1fr)); gap: 20px;">
        <?php if (empty($notices)): ?>
            <div id="emptyNoticeState" style="background: #ffffff; border: 1px dashed #cbdad0; border-radius: 20px; padding: 50px 20px; text-align: center; grid-column: 1 / -1;">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: #eaf1eb; color: #2d6a4f; margin: 0 auto 14px auto; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h4 style="font-size: 1.05rem; font-weight: 700; color: #183324; margin: 0 0 6px 0;">No Circulars Found</h4>
                <p style="font-size: 0.82rem; color: #627467; margin: 0;">New circulars published by academic faculty will appear on this board.</p>
            </div>
        <?php else: ?>
            <?php foreach ($notices as $n): ?>
                <?php 
                    $nJson = htmlspecialchars(json_encode($n), ENT_QUOTES, 'UTF-8');
                    $isUrgent = ($n['priority'] === 'urgent');
                    $isHigh = ($n['priority'] === 'high');
                ?>
                <div class="notice-card-item" 
                     data-category="<?= htmlspecialchars($n['category']) ?>"
                     data-priority="<?= htmlspecialchars($n['priority']) ?>"
                     data-title="<?= htmlspecialchars(strtolower($n['title'])) ?>"
                     data-ref="<?= htmlspecialchars(strtolower($n['ref_no'])) ?>"
                     data-dept="<?= htmlspecialchars(strtolower($n['department'])) ?>"
                     data-body="<?= htmlspecialchars(strtolower($n['body'])) ?>"
                     style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 20px; padding: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; gap: 16px; transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1); cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='#b8d5bf'; this.style.boxShadow='0 8px 24px rgba(28,75,50,0.06)';"
                     onmouseout="this.style.transform='none'; this.style.borderColor='#e5ece6'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.02)';"
                     onclick="openNoticeModal(<?= $nJson ?>)">
                    
                    <div>
                        <!-- Header Badges -->
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 8px; margin-bottom: 12px; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="font-size: 0.7rem; font-weight: 700; padding: 3px 8px; border-radius: 999px; background: <?= $n['badge_bg'] ?>; color: <?= $n['badge_color'] ?>;">
                                    <?= htmlspecialchars($n['category_label']) ?>
                                </span>
                                <?php if ($isUrgent): ?>
                                    <span style="font-size: 0.68rem; font-weight: 800; padding: 2px 8px; border-radius: 999px; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; gap: 4px;">
                                        <span style="width: 5px; height: 5px; border-radius: 50%; background: #dc2626; animation: pulseDot 1.5s infinite;"></span>
                                        URGENT
                                    </span>
                                <?php elseif ($isHigh): ?>
                                    <span style="font-size: 0.68rem; font-weight: 700; padding: 2px 8px; border-radius: 999px; background: #fff7ed; color: #c2410c;">
                                        PRIORITY
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <span style="font-size: 0.72rem; color: #718576; font-weight: 500;">
                                <?= $n['formatted_date'] ?>
                            </span>
                        </div>

                        <!-- Ref No -->
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; font-weight: 700; color: #718576; letter-spacing: 0.3px; margin-bottom: 6px;">
                            <?= htmlspecialchars($n['ref_no']) ?>
                        </div>

                        <!-- Title -->
                        <h4 style="font-size: 1.02rem; font-weight: 700; color: #183324; margin: 0 0 8px 0; line-height: 1.35; letter-spacing: -0.2px;">
                            <?= htmlspecialchars($n['title']) ?>
                        </h4>

                        <!-- Excerpt -->
                        <p style="font-size: 0.81rem; color: #526757; line-height: 1.55; margin: 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= htmlspecialchars(strip_tags($n['body'])) ?>
                        </p>
                    </div>

                    <!-- Card Footer -->
                    <div style="border-top: 1px solid #edf3ee; padding-top: 14px; display: flex; justify-content: space-between; align-items: center; gap: 10px; font-size: 0.73rem;">
                        <div style="display: flex; flex-direction: column; overflow: hidden;">
                            <span style="color: #183324; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                <?= htmlspecialchars($n['department']) ?>
                            </span>
                            <span style="color: #718576; font-size: 0.68rem;">
                                <?= htmlspecialchars($n['read_time']) ?> &bull; <?= htmlspecialchars($n['audience_label']) ?>
                            </span>
                        </div>

                        <!-- Action Link Button -->
                        <button type="button" class="btn-read-inline" 
                                onclick="event.stopPropagation(); openNoticeModal(<?= $nJson ?>)"
                                style="border: none; background: #eaf1eb; color: #1c4b32; font-weight: 700; font-size: 0.75rem; padding: 6px 14px; border-radius: 999px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; font-family: inherit; transition: all 0.15s ease;">
                            <span>View</span>
                            <span>&rarr;</span>
                        </button>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<!-- ==================================================== -->
    <!-- 5. INTERACTIVE CIRCULAR DETAILS MODAL                -->
    <!-- ==================================================== -->
    <div id="noticeModalOverlay" class="notice-modal-overlay" style="display: none;">
        <div class="notice-modal-container">
            
            <!-- Modal Header -->
            <div class="notice-modal-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #eaf5ee; color: #1c4b32; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <!-- Kalavanta Official Seal / Crest Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l8 4.5v6.5c0 5-3.5 9-8 11-4.5-2-8-6-8-11V6.5L12 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 0.7rem; font-weight: 800; color: #1c4b32; letter-spacing: 0.8px; text-transform: uppercase;">
                                KALAVANTA EDUTECH &bull; ACADEMIC BULLETIN
                            </span>
                        </div>
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; color: #718576; font-weight: 600;" id="modalNoticeRef">
                            REF: KE-CIR-2026-001
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-close-modal" onclick="closeNoticeModal()" title="Close">&times;</button>
            </div>

            <!-- Modal Body (Printable Circular Format) -->
            <div class="notice-modal-body" id="printableNoticeArea">
                
                <!-- Circular Metadata Box -->
                <div style="background: #f7faf7; border: 1px solid #e0ece2; border-radius: 14px; padding: 14px 18px; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; font-size: 0.78rem;">
                    <div>
                        <span style="color: #718576; display: block; font-size: 0.7rem; font-weight: 600;">Date of Issue</span>
                        <strong style="color: #183324; font-weight: 700;" id="modalNoticeDate">Nov 16, 2026</strong>
                    </div>
                    <div>
                        <span style="color: #718576; display: block; font-size: 0.7rem; font-weight: 600;">Issuing Authority</span>
                        <strong style="color: #183324; font-weight: 700;" id="modalNoticeDept">Dean of Academic Affairs</strong>
                    </div>
                    <div>
                        <span style="color: #718576; display: block; font-size: 0.7rem; font-weight: 600;">Recipient Audience</span>
                        <strong style="color: #183324; font-weight: 700;" id="modalNoticeAudience">Student Body (All Semesters)</strong>
                    </div>
                    <div>
                        <span style="color: #718576; display: block; font-size: 0.7rem; font-weight: 600;">Category &amp; Status</span>
                        <div style="display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                            <span id="modalNoticeCategoryBadge" style="font-size: 0.68rem; font-weight: 700; padding: 2px 7px; border-radius: 999px; background: #eaf5ee; color: #1c4b32;">
                                Academic
                            </span>
                            <span id="modalNoticePriorityBadge" style="font-size: 0.68rem; font-weight: 700; padding: 2px 7px; border-radius: 999px; background: #fee2e2; color: #dc2626;">
                                Urgent
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Main Subject Title -->
                <div>
                    <h2 style="font-size: 1.35rem; font-weight: 800; color: #183324; margin: 0; line-height: 1.35; letter-spacing: -0.3px;" id="modalNoticeTitle">
                        Mid-Semester Assessment Schedule &amp; Hall Ticket Issuance
                    </h2>
                </div>

                <hr style="border: none; border-top: 1px solid #eef3ee; margin: 0;">

                <!-- Full Circular Text Body -->
                <div style="font-size: 0.88rem; color: #2d4133; line-height: 1.7; white-space: pre-line;" id="modalNoticeBody">
                    Circular body text appears here...
                </div>

                <!-- Official Authentication Box -->
                <div style="margin-top: 10px; background: #fafcfa; border: 1px dashed #cde0d1; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#2d6a4f" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <div>
                            <div style="font-size: 0.74rem; font-weight: 800; color: #1c4b32; letter-spacing: 0.4px;">
                                DIGITALLY SIGNED &amp; VERIFIED CIRCULAR
                            </div>
                            <div style="font-size: 0.68rem; color: #627467;">
                                Kalavanta Academic Council &bull; Issued by <span id="modalNoticeAuthor">Administration</span>
                            </div>
                        </div>
                    </div>
                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; color: #2d6a4f; font-weight: 700; background: #eaf5ee; padding: 3px 8px; border-radius: 6px;">
                        STATUS: ACTIVE
                    </span>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="notice-modal-footer">
                <button type="button" class="btn-modal-copy" onclick="copyNoticeLink()" id="btnCopyNoticeLink">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span>Copy Link</span>
                </button>
                <button type="button" class="btn-modal-print" onclick="window.print()">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Print Circular</span>
                </button>
                <button type="button" class="btn-modal-dismiss" onclick="closeNoticeModal()">
                    Close
                </button>
            </div>

        </div>
    </div>

<!-- ==================================================== -->
<!-- STYLES & ANIMATIONS                                  -->
<!-- ==================================================== -->
<style>
/* Pulse Animation for urgent circulars */
@keyframes pulseDot {
    0% { transform: scale(0.95); opacity: 0.8; }
    50% { transform: scale(1.3); opacity: 1; }
    100% { transform: scale(0.95); opacity: 0.8; }
}

/* Category Filter Pills */
.filter-pill-btn {
    border: none;
    background: transparent;
    color: #526757;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 999px;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}
.filter-pill-btn .pill-count {
    background: #e2ece4;
    color: #2d6a4f;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 999px;
}
.filter-pill-btn.active {
    background: #1c4b32 !important;
    color: #ffffff !important;
    box-shadow: 0 1px 4px rgba(28, 75, 50, 0.2);
}
.filter-pill-btn.active .pill-count {
    background: rgba(255, 255, 255, 0.25) !important;
    color: #ffffff !important;
}
.filter-pill-btn:hover:not(.active) {
    background: #eaf1eb;
    color: #1c4b32;
}

/* Button Read Inline */
.btn-read-inline:hover {
    background: #1c4b32 !important;
    color: #ffffff !important;
}

/* Featured Button */
.btn-read-featured:hover {
    background: #143725 !important;
}

/* Notice Modal Overlay & Styling */
.notice-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(18, 38, 26, 0.5);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.notice-modal-container {
    background: #ffffff;
    border-radius: 22px;
    max-width: 650px;
    width: 100%;
    max-height: 90vh;
    box-shadow: 0 20px 45px rgba(0,0,0,0.18);
    overflow: hidden;
    border: 1px solid #dce8de;
    display: flex;
    flex-direction: column;
    animation: noticeModalUp 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes noticeModalUp {
    from { opacity: 0; transform: translateY(12px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.notice-modal-header {
    background: #f4f8f5;
    padding: 18px 24px;
    border-bottom: 1px solid #e2ece4;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}
.btn-close-modal {
    background: transparent;
    border: none;
    font-size: 1.4rem;
    color: #627467;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
    line-height: 1;
}
.btn-close-modal:hover {
    color: #183324;
    background: #e2ece4;
}
.notice-modal-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    overflow-y: auto;
    max-height: calc(90vh - 140px);
}
.notice-modal-footer {
    padding: 14px 24px;
    background: #fafcfa;
    border-top: 1px solid #edf2ed;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.btn-modal-dismiss {
    background: #f3f7f4;
    color: #3b5343;
    border: 1px solid #d5e0d5;
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: background 0.15s ease;
}
.btn-modal-dismiss:hover {
    background: #e5ece6;
}
.btn-modal-copy {
    background: #ffffff;
    color: #2d6a4f;
    border: 1px solid #cfe0d2;
    padding: 8px 16px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-modal-copy:hover {
    background: #eaf1eb;
}
.btn-modal-print {
    background: #1c4b32;
    color: #ffffff;
    border: none;
    padding: 8px 20px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: inherit;
    cursor: pointer;
    transition: background 0.15s ease;
}
.btn-modal-print:hover {
    background: #143725;
}

/* Print Specific Media Styling */
@media print {
    body * {
        visibility: hidden;
    }
    #printableNoticeArea, #printableNoticeArea * {
        visibility: visible;
    }
    #printableNoticeArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 20px;
    }
}
</style>

<!-- ==================================================== -->
<!-- JAVASCRIPT LOGIC & REAL-TIME SEARCH                  -->
<!-- ==================================================== -->
<script>
let currentCategoryFilter = 'all';
let currentSearchTerm = '';
let currentOpenNotice = null;

// Filter Category Pills
function setNoticeFilter(category, btn) {
    currentCategoryFilter = category;
    document.querySelectorAll('.filter-pill-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');

    applyAllNoticeFilters();
}

// Live Search Filter
function filterNoticesRealtime() {
    const input = document.getElementById('noticeSearchFilter');
    const clearBtn = document.getElementById('clearSearchBtn');
    currentSearchTerm = (input ? input.value : '').trim().toLowerCase();

    if (clearBtn) {
        clearBtn.style.display = currentSearchTerm ? 'block' : 'none';
    }

    applyAllNoticeFilters();
}

function clearNoticeSearch() {
    const input = document.getElementById('noticeSearchFilter');
    if (input) input.value = '';
    currentSearchTerm = '';
    const clearBtn = document.getElementById('clearSearchBtn');
    if (clearBtn) clearBtn.style.display = 'none';

    applyAllNoticeFilters();
}

// Combined Filter Function
function applyAllNoticeFilters() {
    const cards = document.querySelectorAll('.notice-card-item');
    let visibleCount = 0;

    cards.forEach(card => {
        const cat = card.getAttribute('data-category');
        const pri = card.getAttribute('data-priority');
        const title = card.getAttribute('data-title') || '';
        const ref = card.getAttribute('data-ref') || '';
        const dept = card.getAttribute('data-dept') || '';
        const body = card.getAttribute('data-body') || '';

        // Category filter match
        let matchesCategory = false;
        if (currentCategoryFilter === 'all') {
            matchesCategory = true;
        } else if (currentCategoryFilter === 'important') {
            matchesCategory = (pri === 'urgent' || pri === 'high');
        } else {
            matchesCategory = (cat === currentCategoryFilter);
        }

        // Search term match
        let matchesSearch = true;
        if (currentSearchTerm) {
            matchesSearch = title.includes(currentSearchTerm) || 
                            ref.includes(currentSearchTerm) || 
                            dept.includes(currentSearchTerm) || 
                            body.includes(currentSearchTerm);
        }

        if (matchesCategory && matchesSearch) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const countElem = document.getElementById('visibleNoticesCount');
    if (countElem) countElem.textContent = visibleCount;
}

// Open Circular Details Modal
function openNoticeModal(notice) {
    if (!notice) return;
    currentOpenNotice = notice;

    document.getElementById('modalNoticeRef').textContent = notice.ref_no || 'KE-CIR-2026';
    document.getElementById('modalNoticeDate').textContent = notice.formatted_date || 'Nov 16, 2026';
    document.getElementById('modalNoticeDept').textContent = notice.department || 'Academic Dean Office';
    document.getElementById('modalNoticeAudience').textContent = notice.audience_label || 'Student Body';
    document.getElementById('modalNoticeTitle').textContent = notice.title || 'Official Circular';
    document.getElementById('modalNoticeBody').textContent = notice.body || '';
    document.getElementById('modalNoticeAuthor').textContent = notice.author_name || 'Administration';

    // Badges
    const catBadge = document.getElementById('modalNoticeCategoryBadge');
    if (catBadge) {
        catBadge.textContent = notice.category_label || 'Notice';
        catBadge.style.background = notice.badge_bg || '#eaf5ee';
        catBadge.style.color = notice.badge_color || '#1c4b32';
    }

    const priBadge = document.getElementById('modalNoticePriorityBadge');
    if (priBadge) {
        priBadge.textContent = notice.priority_label || 'General Notice';
        if (notice.priority === 'urgent') {
            priBadge.style.background = '#fee2e2';
            priBadge.style.color = '#dc2626';
            priBadge.style.display = 'inline-block';
        } else if (notice.priority === 'high') {
            priBadge.style.background = '#fff7ed';
            priBadge.style.color = '#c2410c';
            priBadge.style.display = 'inline-block';
        } else {
            priBadge.style.display = 'none';
        }
    }

    const overlay = document.getElementById('noticeModalOverlay');
    if (overlay) overlay.style.display = 'flex';
}

function closeNoticeModal() {
    const overlay = document.getElementById('noticeModalOverlay');
    if (overlay) overlay.style.display = 'none';
    currentOpenNotice = null;
}

function printSpecificNotice(notice) {
    openNoticeModal(notice);
    setTimeout(() => {
        window.print();
    }, 250);
}

function copyNoticeLink() {
    const ref = currentOpenNotice ? currentOpenNotice.ref_no : '';
    const shareUrl = window.location.origin + window.location.pathname + '#ref=' + encodeURIComponent(ref);
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(shareUrl).then(() => {
            const btn = document.getElementById('btnCopyNoticeLink');
            if (btn) {
                const origHtml = btn.innerHTML;
                btn.innerHTML = '<span>✓ Copied!</span>';
                setTimeout(() => { btn.innerHTML = origHtml; }, 2000);
            }
        });
    }
}

// Close Modal on backdrop click or escape
window.addEventListener('click', function(e) {
    const overlay = document.getElementById('noticeModalOverlay');
    if (e.target === overlay) closeNoticeModal();
});
window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeNoticeModal();
});
</script>
