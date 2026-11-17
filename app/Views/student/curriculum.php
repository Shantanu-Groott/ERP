<?php
/**
 * Kalavanta Edutech - Student Curriculum & Learning Paths
 * Adapted to List-Based Track View matching official mockup
 */
$enrolledList = $enrolledCourses ?? ['CYB301', 'CYB302', 'CYB303', 'CYB304', 'CS301', 'CS302', 'CS303', 'CS304'];
?>
<div class="curriculum-portal-container" style="display: flex; flex-direction: column; gap: 20px;">

    <!-- Instant Unlock Notification Alert -->
    <?php if (!empty($_GET['unlocked'])): ?>
        <div style="background: #e6f4ea; border: 1px solid #a8dab5; border-radius: 16px; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 14px; box-shadow: 0 2px 8px rgba(28, 75, 50, 0.08);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="width: 32px; height: 32px; border-radius: 50%; background: #2d6a4f; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.95rem;">✓</span>
                <div>
                    <h4 style="font-size: 0.92rem; font-weight: 700; color: #153e28; margin: 0 0 2px 0;">Track Successfully Unlocked!</h4>
                    <p style="font-size: 0.78rem; color: #375943; margin: 0;">You have full enrolled access to all 4 modules, virtual sandbox environments, and course materials.</p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" style="background: transparent; border: none; font-size: 1.1rem; color: #2d6a4f; cursor: pointer;">✕</button>
        </div>
    <?php endif; ?>

    <!-- Top Metrics Overview: Side-by-Side Cards matching mockup -->
    <div class="metrics-overview-grid" style="display: grid; grid-template-columns: minmax(300px, 1fr) minmax(380px, 1.35fr); gap: 20px; align-items: stretch;">
        
        <!-- Left Card: Circular Overall Progress -->
        <div class="curriculum-stat-card" style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 22px 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 24px;">
            <!-- Circular Progress Ring (67%) -->
            <div style="position: relative; width: 84px; height: 84px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                <svg width="84" height="84" viewBox="0 0 88 88" style="transform: rotate(-90deg);">
                    <!-- Background Circle -->
                    <circle cx="44" cy="44" r="35" stroke="#e2ece4" stroke-width="7.5" fill="none" />
                    <!-- Progress Arc (67% of 219.9 = 147.3 dasharray, 72.6 dashoffset) -->
                    <circle cx="44" cy="44" r="35" stroke="#1c4b32" stroke-width="7.5" stroke-linecap="round" fill="none"
                            stroke-dasharray="219.9" stroke-dashoffset="72.6" style="transition: stroke-dashoffset 0.8s ease;" />
                </svg>
                <div style="position: absolute; text-align: center;">
                    <span style="font-size: 1.32rem; font-weight: 800; color: #183324; line-height: 1;">67%</span>
                </div>
            </div>

            <!-- Overall Progress Info & Bar -->
            <div style="flex: 1; min-width: 0;">
                <h3 style="font-size: 1.05rem; font-weight: 700; color: #183324; margin: 0 0 2px 0;">Overall Progress</h3>
                <p style="font-size: 0.82rem; color: #627467; margin: 0 0 10px 0; font-weight: 500;">Across All Tracks</p>
                <div style="width: 140px; max-width: 100%; height: 6px; background: #e2ece4; border-radius: 999px; overflow: hidden;">
                    <div style="width: 67%; height: 100%; background: #1c4b32; border-radius: 999px;"></div>
                </div>
            </div>
        </div>

        <!-- Right Card: 3 Primary Metrics with Dividers -->
        <div class="curriculum-stat-card" style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 22px 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-around;">
            
            <!-- Metric 1: Enrolled Tracks -->
            <div style="display: flex; flex-direction: column; gap: 4px; padding: 0 10px;">
                <span style="font-size: 1.85rem; font-weight: 800; color: #183324; line-height: 1.1;">8</span>
                <span style="font-size: 0.82rem; font-weight: 500; color: #627467;">Enrolled Tracks</span>
            </div>

            <div style="width: 1px; height: 44px; background: #edf2ed;"></div>

            <!-- Metric 2: Completed Labs -->
            <div style="display: flex; flex-direction: column; gap: 4px; padding: 0 10px;">
                <span style="font-size: 1.85rem; font-weight: 800; color: #183324; line-height: 1.1;">46</span>
                <span style="font-size: 0.82rem; font-weight: 500; color: #627467;">Completed Labs</span>
            </div>

            <div style="width: 1px; height: 44px; background: #edf2ed;"></div>

            <!-- Metric 3: Pending Labs -->
            <div style="display: flex; flex-direction: column; gap: 4px; padding: 0 10px;">
                <span style="font-size: 1.85rem; font-weight: 800; color: #183324; line-height: 1.1;">12</span>
                <span style="font-size: 0.82rem; font-weight: 500; color: #627467;">Pending Labs</span>
            </div>

        </div>

    </div>

    <!-- Filter Tabs Row matching mockup -->
    <div class="curriculum-filter-tabs" style="display: flex; align-items: center; gap: 32px; border-bottom: 1px solid #e2ece4; margin-top: 8px; padding-bottom: 0;">
        <button id="tab-all" class="filter-tab-btn active" onclick="switchCurriculumTab('all')"
                style="background: transparent; border: none; padding: 8px 4px 12px 4px; font-size: 0.92rem; font-weight: 700; color: #183324; border-bottom: 3px solid #1c4b32; margin-bottom: -1px; cursor: pointer; font-family: inherit; transition: all 0.2s ease;">
            All Tracks
        </button>
        <button id="tab-in-progress" class="filter-tab-btn" onclick="switchCurriculumTab('in-progress')"
                style="background: transparent; border: none; padding: 8px 4px 12px 4px; font-size: 0.92rem; font-weight: 500; color: #627467; border-bottom: 3px solid transparent; margin-bottom: -1px; cursor: pointer; font-family: inherit; transition: all 0.2s ease;">
            In Progress
        </button>
        <button id="tab-completed" class="filter-tab-btn" onclick="switchCurriculumTab('completed')"
                style="background: transparent; border: none; padding: 8px 4px 12px 4px; font-size: 0.92rem; font-weight: 500; color: #627467; border-bottom: 3px solid transparent; margin-bottom: -1px; cursor: pointer; font-family: inherit; transition: all 0.2s ease;">
            Completed
        </button>
    </div>

    <!-- Main Tracks List Container matching mockup -->
    <div id="tracks-list-card" style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); overflow: hidden;">
        
        <?php foreach ($allTracks as $index => $t): ?>
            <?php 
                $code = $t['code'];
                $isEnrolled = $t['is_enrolled'] ?? in_array($code, $enrolledList, true);
                $prog = (int)($t['display_progress'] ?? $t['progress']);
                $statusType = ($prog === 100) ? 'completed' : (($prog > 0) ? 'in-progress' : 'not-started');
                $isLast = ($index === count($allTracks) - 1);
            ?>
            <div class="track-row-wrapper" data-track-code="<?= htmlspecialchars($code) ?>" data-status="<?= $statusType ?>" data-progress="<?= $prog ?>" style="<?= !$isLast ? 'border-bottom: 1px solid #edf2ed;' : '' ?>">
                
                <!-- Main Horizontal Track Row -->
                <div class="track-row-item" style="padding: 18px 26px; display: flex; align-items: center; justify-content: space-between; gap: 20px; transition: background 0.15s ease;">
                    
                    <!-- Left: Soft Green Icon Badge + Track Title & Subtitle -->
                    <div style="display: flex; align-items: center; gap: 18px; min-width: 0; flex: 1;">
                        <!-- Icon Badge 48x48 in #d7e8db -->
                        <div class="track-icon-badge" style="width: 48px; height: 48px; min-width: 48px; border-radius: 14px; background: #d7e8db; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <?php if ($t['icon'] === 'shield'): ?>
                                <!-- Shield Icon for Network Defense Essentials -->
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    <path d="M9 12l2 2 4-4"/>
                                </svg>
                            <?php elseif ($t['icon'] === 'hacker'): ?>
                                <!-- Hacker / Silhouette Avatar for Ethical Hacking -->
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                    <path d="M4 14l2-2m14 0l-2-2"/>
                                </svg>
                            <?php elseif ($t['icon'] === 'key'): ?>
                                <!-- Key Icon for Cryptographic & Data Security -->
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="7.5" cy="15.5" r="4.5"/>
                                    <path d="M10.7 12.3L19 4"/>
                                    <path d="M15 4l4 4"/>
                                    <path d="M17 6l2-2"/>
                                </svg>
                            <?php elseif ($t['icon'] === 'forensics'): ?>
                                <!-- Siren / Forensics Radar Icon for Incident Response -->
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                                    <circle cx="12" cy="8" r="1.5" fill="#1c4b32"/>
                                </svg>
                            <?php elseif ($t['icon'] === 'database'): ?>
                                <!-- Database Cylinders for DBMS -->
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                                </svg>
                            <?php elseif ($t['icon'] === 'network'): ?>
                                <!-- Network Topology Nodes for Computer Networks -->
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="2" width="6" height="6" rx="1"/>
                                    <rect x="16" y="2" width="6" height="6" rx="1"/>
                                    <rect x="9" y="16" width="6" height="6" rx="1"/>
                                    <path d="M5 8v3a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8"/>
                                    <path d="M12 13v3"/>
                                </svg>
                            <?php elseif ($t['icon'] === 'theory'): ?>
                                <!-- Finite Automata Graph for Theory of Computation -->
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="6" cy="6" r="3"/>
                                    <circle cx="18" cy="6" r="3"/>
                                    <circle cx="12" cy="18" r="3"/>
                                    <path d="M8.5 7.5L15.5 7.5"/>
                                    <path d="M7.5 8.5L10.5 15.5"/>
                                    <path d="M16.5 8.5L13.5 15.5"/>
                                </svg>
                            <?php else: ?>
                                <!-- Web Browser & ERP System Icon -->
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="2" y1="12" x2="22" y2="12"/>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                                </svg>
                            <?php endif; ?>
                        </div>

                        <!-- Titles -->
                        <div style="min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <h4 class="track-title-text" style="font-size: 0.96rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.25;">
                                    <?= htmlspecialchars($t['name']) ?>
                                </h4>
                                <span style="font-size: 0.7rem; font-weight: 700; color: #5a7061; background: #eaf1eb; padding: 1px 6px; border-radius: 6px;">
                                    <?= htmlspecialchars($code) ?>
                                </span>
                            </div>
                            <p class="track-subtitle-text" style="font-size: 0.8rem; color: #627467; margin: 3px 0 0 0; line-height: 1.3;">
                                <?= htmlspecialchars($t['subtitle']) ?>
                            </p>
                        </div>
                    </div>

                    <!-- Right: Progress Bar + Percentage + Pill Button -->
                    <div style="display: flex; align-items: center; gap: 24px; flex-shrink: 0;">
                        
                        <!-- Horizontal Progress Bar (240px) -->
                        <div class="track-progress-bar-wrap" style="width: 240px; height: 6px; background: #e2ece4; border-radius: 999px; overflow: hidden;">
                            <div style="width: <?= $prog ?>%; height: 100%; background: #1c4b32; border-radius: 999px; transition: width 0.4s ease;"></div>
                        </div>

                        <!-- Percentage Label -->
                        <span style="font-size: 0.86rem; font-weight: 700; color: #183324; width: 44px; text-align: right; flex-shrink: 0;">
                            <?= $prog ?>%
                        </span>

                        <!-- Action Pill Button -->
                        <?php if ($isEnrolled): ?>
                            <button type="button" class="action-pill-btn btn-continue" onclick="toggleTrackDrawer('<?= htmlspecialchars($code) ?>')" 
                                    style="padding: 7px 20px; border-radius: 999px; background: #eaf1eb; color: #1c4b32; font-weight: 600; font-size: 0.83rem; border: 1px solid #d4e2d6; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease; font-family: inherit;">
                                <span>Continue</span>
                                <span style="font-size: 0.95rem;">&rarr;</span>
                            </button>
                        <?php else: ?>
                            <button type="button" class="action-pill-btn btn-buy" onclick="openPurchaseModal('<?= htmlspecialchars($code) ?>', '<?= htmlspecialchars(addslashes($t['name'])) ?>', '<?= htmlspecialchars($t['price']) ?>')" 
                                    style="padding: 7px 20px; border-radius: 999px; background: #fdf6ea; color: #92580a; font-weight: 600; font-size: 0.83rem; border: 1px solid #f6deb3; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease; font-family: inherit;">
                                <span>Buy Course</span>
                                <span style="font-size: 0.95rem;">&rarr;</span>
                            </button>
                        <?php endif; ?>

                    </div>

                </div>

                <!-- Expandable Modules Drawer (Opens on "Continue" or Click) -->
                <div id="drawer-<?= htmlspecialchars($code) ?>" class="track-modules-drawer" style="display: none; background: #f8faf8; border-top: 1px solid #edf2ed; padding: 22px 26px 26px 26px;">
                    
                    <!-- Drawer Header with Syllabus Info -->
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #e7efe9;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 0.74rem; font-weight: 800; color: #1c4b32; background: #d7e8db; padding: 2px 8px; border-radius: 6px;">
                                    <?= htmlspecialchars($code) ?> SYLLABUS
                                </span>
                                <span style="font-size: 0.82rem; font-weight: 600; color: #3b5343;">
                                    Mentor: <?= htmlspecialchars($t['instructor_name'] ?? 'Prof. Robert Miller') ?>
                                </span>
                                <span style="color: #9ab0a0;">•</span>
                                <span style="font-size: 0.82rem; color: #627467;">
                                    Credits: <?= htmlspecialchars($t['credits'] ?? 4) ?>
                                </span>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 10px;">
                            <?php if ($isEnrolled): ?>
                                <span style="font-size: 0.74rem; font-weight: 700; color: #2e7d32; background: #e8f5e9; padding: 3px 10px; border-radius: 999px; border: 1px solid #c8e6c9;">
                                    ✓ Enrolled Track (All Modules Unlocked)
                                </span>
                            <?php else: ?>
                                <span style="font-size: 0.74rem; font-weight: 700; color: #b45309; background: #fffbeb; padding: 3px 10px; border-radius: 999px; border: 1px solid #fde68a;">
                                    🔒 Preview Mode (Requires Purchase to Access)
                                </span>
                            <?php endif; ?>
                            <button onclick="toggleTrackDrawer('<?= htmlspecialchars($code) ?>')" style="background: transparent; border: none; font-size: 0.8rem; font-weight: 600; color: #627467; cursor: pointer;">
                                Close ✕
                            </button>
                        </div>
                    </div>

                    <!-- 4 Modules Grid for this Track -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                        <?php 
                            $modules = $t['modules'] ?? [];
                            foreach ($modules as $mod): 
                                $modNum = $mod['number'] ?? 1;
                                $modProgress = $mod['progress'] ?? 0;
                                $lessons = $mod['lessons'] ?? [];
                        ?>
                            <div class="module-card-box" style="background: #ffffff; border: 1px solid #e2ece4; border-radius: 16px; padding: 18px 20px; display: flex; flex-direction: column; justify-content: space-between; gap: 14px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); transition: transform 0.15s ease, box-shadow 0.15s ease;">
                                
                                <div>
                                    <!-- Module Number & Progress Badge -->
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #5a7061;">
                                            Module <?= $modNum ?>
                                        </span>
                                        <?php if ($modProgress === 100): ?>
                                            <span style="font-size: 0.7rem; font-weight: 700; background: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 999px;">
                                                100% Completed
                                            </span>
                                        <?php elseif ($modProgress > 0): ?>
                                            <span style="font-size: 0.7rem; font-weight: 700; background: #eaf1eb; color: #1c4b32; padding: 2px 8px; border-radius: 999px;">
                                                <?= $modProgress ?>% In Progress
                                            </span>
                                        <?php else: ?>
                                            <span style="font-size: 0.7rem; font-weight: 600; background: #f5f7f5; color: #7a8d80; padding: 2px 8px; border-radius: 999px;">
                                                Not Started
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Module Title -->
                                    <h5 style="font-size: 0.92rem; font-weight: 700; color: #183324; margin: 0 0 10px 0; line-height: 1.3;">
                                        <?= htmlspecialchars($mod['title']) ?>
                                    </h5>

                                    <!-- Lessons List Preview -->
                                    <div style="display: flex; flex-direction: column; gap: 6px; margin-bottom: 10px;">
                                        <?php foreach ($lessons as $l): ?>
                                            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.76rem; color: #435b4b; background: #f8faf8; padding: 5px 10px; border-radius: 8px;">
                                                <div style="display: flex; align-items: center; gap: 6px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    <span style="font-weight: 700; color: #1c4b32;"><?= htmlspecialchars($l['code']) ?></span>
                                                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= htmlspecialchars($l['title']) ?></span>
                                                </div>
                                                <span style="color: #7a8d80; font-size: 0.7rem; flex-shrink: 0;"><?= htmlspecialchars($l['duration']) ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Action Button: Open Interactive Learning Modal or Buy -->
                                <?php if ($isEnrolled): ?>
                                    <button type="button" onclick="openLearningModal('<?= htmlspecialchars($code) ?>', <?= (int)$modNum ?>)"
                                            style="width: 100%; padding: 8px 14px; border-radius: 10px; background: #1c4b32; color: #ffffff; border: none; font-weight: 600; font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: background 0.15s ease; font-family: inherit;">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Start Learning / Review</span>
                                    </button>
                                <?php else: ?>
                                    <button type="button" onclick="openPurchaseModal('<?= htmlspecialchars($code) ?>', '<?= htmlspecialchars(addslashes($t['name'])) ?>', '<?= htmlspecialchars($t['price']) ?>')"
                                            style="width: 100%; padding: 8px 14px; border-radius: 10px; background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-weight: 600; font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; font-family: inherit;">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <span>Unlock Course to Access (<?= htmlspecialchars($t['price']) ?>)</span>
                                    </button>
                                <?php endif; ?>

                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>
        <?php endforeach; ?>

    </div>

</div>

<!-- ==================================================== -->
<!-- INTERACTIVE LEARNING MODAL (Study Notes, Sandbox & Commands) -->
<!-- ==================================================== -->
<div id="learningModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(18, 38, 26, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    
    <div style="background: #ffffff; border-radius: 24px; width: 100%; max-width: 980px; max-height: 90vh; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 20px 40px rgba(0,0,0,0.2); animation: modalFadeIn 0.2s ease-out;">
        
        <!-- Modal Top Header -->
        <div style="background: #1c4b32; color: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span id="lm-track-code" style="background: rgba(255,255,255,0.2); font-size: 0.74rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                    CYB302
                </span>
                <div>
                    <h3 id="lm-modal-title" style="font-size: 1.05rem; font-weight: 700; margin: 0; line-height: 1.2;">
                        Module 1: Reconnaissance & OSINT
                    </h3>
                    <p id="lm-track-name" style="font-size: 0.78rem; color: #c4decb; margin: 2px 0 0 0;">
                        Ethical Hacking & Pen Testing
                    </p>
                </div>
            </div>
            <button onclick="closeLearningModal()" style="background: rgba(255,255,255,0.15); border: none; color: #ffffff; width: 32px; height: 32px; border-radius: 50%; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.15s ease;">
                ✕
            </button>
        </div>

        <!-- Modal Body: Lesson Selector Sidebar + Rich Study Workspace -->
        <div style="display: flex; flex: 1; min-height: 0; overflow: hidden;">
            
            <!-- Left Sidebar: Lessons List -->
            <div style="width: 290px; border-right: 1px solid #edf2ed; background: #f8faf8; padding: 18px; overflow-y: auto; flex-shrink: 0;">
                <div style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #5a7061; margin-bottom: 12px;">
                    Module Lessons
                </div>
                <div id="lm-lessons-container" style="display: flex; flex-direction: column; gap: 8px;">
                    <!-- Injected dynamically by JS -->
                </div>
            </div>

            <!-- Right Workspace: Study Notes, Shell Terminal & Lab Sandbox -->
            <div style="flex: 1; padding: 24px 28px; overflow-y: auto; background: #ffffff;">
                
                <!-- Lesson Title & Duration -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 14px; margin-bottom: 16px; padding-bottom: 14px; border-bottom: 1px solid #edf2ed;">
                    <div>
                        <span id="lm-active-lesson-code" style="font-size: 0.75rem; font-weight: 800; color: #1c4b32; background: #eaf1eb; padding: 2px 8px; border-radius: 6px;">
                            Lesson 1.1
                        </span>
                        <h2 id="lm-active-lesson-title" style="font-size: 1.25rem; font-weight: 700; color: #183324; margin: 8px 0 0 0; line-height: 1.25;">
                            Introduction to Active & Passive Recon
                        </h2>
                    </div>
                    <span id="lm-active-lesson-duration" style="font-size: 0.78rem; font-weight: 600; color: #5a7061; background: #f1f4f2; padding: 4px 10px; border-radius: 999px; flex-shrink: 0;">
                        25 mins
                    </span>
                </div>

                <!-- Concept Overview Summary -->
                <div style="margin-bottom: 20px;">
                    <h4 style="font-size: 0.84rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #435b4b; margin: 0 0 8px 0;">
                        Concept Summary
                    </h4>
                    <p id="lm-active-lesson-summary" style="font-size: 0.88rem; line-height: 1.6; color: #334a3b; margin: 0; background: #fbfdfb; border-left: 3px solid #1c4b32; padding: 12px 16px; border-radius: 0 10px 10px 0;">
                        ...
                    </p>
                </div>

                <!-- Key Learning Objectives -->
                <div style="margin-bottom: 20px;">
                    <h4 style="font-size: 0.84rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #435b4b; margin: 0 0 10px 0;">
                        Key Learning Takeaways
                    </h4>
                    <ul id="lm-active-lesson-points" style="margin: 0; padding-left: 0; list-style: none; display: flex; flex-direction: column; gap: 8px;">
                        <!-- Injected dynamically by JS -->
                    </ul>
                </div>

                <!-- Interactive Terminal Box with Commands -->
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <h4 style="font-size: 0.84rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #435b4b; margin: 0;">
                            Live Command Terminal Syntax
                        </h4>
                        <button type="button" onclick="copyLessonCommand()" id="lm-copy-btn" 
                                style="background: #eaf1eb; border: 1px solid #d4e2d6; border-radius: 6px; padding: 3px 10px; font-size: 0.72rem; font-weight: 700; color: #1c4b32; cursor: pointer; font-family: inherit;">
                            Copy Command
                        </button>
                    </div>
                    <div style="background: #141e17; border-radius: 12px; padding: 14px 18px; border: 1px solid #233527; font-family: 'Consolas', 'Monaco', 'Courier New', monospace; font-size: 0.82rem; color: #a8d5b5; overflow-x: auto; box-shadow: inset 0 2px 6px rgba(0,0,0,0.4);">
                        <div style="display: flex; gap: 6px; margin-bottom: 8px; opacity: 0.6;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #ff5f56; display: inline-block;"></span>
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #ffbd2e; display: inline-block;"></span>
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #27c93f; display: inline-block;"></span>
                            <span style="font-size: 0.68rem; color: #627467; margin-left: 6px;">bash — cyber-sandbox@kalavanta:~$</span>
                        </div>
                        <pre id="lm-active-lesson-commands" style="margin: 0; white-space: pre-wrap; word-break: break-all; line-height: 1.5; color: #cbe7d3;"></pre>
                    </div>
                </div>

                <!-- Hands-on Lab Sandbox Instructions -->
                <div style="background: #eef6f0; border: 1px solid #d2e6d6; border-radius: 14px; padding: 16px 20px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#1c4b32" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        <h4 style="font-size: 0.86rem; font-weight: 700; color: #183324; margin: 0;">
                            Hands-on Lab Exercise
                        </h4>
                    </div>
                    <p id="lm-active-lesson-lab" style="font-size: 0.82rem; color: #2c4735; margin: 0; line-height: 1.5;">
                        ...
                    </p>
                </div>

                <!-- Actions: Launch Virtual Lab & Mark Complete -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 14px; padding-top: 14px; border-top: 1px solid #edf2ed;">
                    <button type="button" onclick="launchVirtualLabDemo()" style="padding: 10px 20px; border-radius: 10px; background: #2d6a4f; color: #ffffff; border: none; font-weight: 700; font-size: 0.84rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-family: inherit; box-shadow: 0 2px 6px rgba(45,106,79,0.25);">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Launch Virtual Cyber Sandbox</span>
                    </button>

                    <button type="button" id="lm-complete-toggle-btn" onclick="toggleLessonComplete()" style="padding: 10px 18px; border-radius: 10px; background: #eaf1eb; color: #1c4b32; border: 1px solid #d4e2d6; font-weight: 600; font-size: 0.82rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-family: inherit;">
                        <span>✓</span>
                        <span id="lm-complete-text">Mark Lesson as Completed</span>
                    </button>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- ==================================================== -->
<!-- INSTANT COURSE PURCHASE MODAL -->
<!-- ==================================================== -->
<div id="purchaseModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(18, 38, 26, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    
    <div style="background: #ffffff; border-radius: 24px; width: 100%; max-width: 520px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2); animation: modalFadeIn 0.2s ease-out;">
        
        <div style="background: #1c4b32; color: #ffffff; padding: 22px 24px; position: relative;">
            <button onclick="closePurchaseModal()" style="position: absolute; top: 16px; right: 16px; background: rgba(255,255,255,0.15); border: none; color: #ffffff; width: 30px; height: 30px; border-radius: 50%; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                ✕
            </button>
            <span id="pm-course-code" style="background: rgba(255,255,255,0.2); font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                CS301
            </span>
            <h3 id="pm-course-name" style="font-size: 1.25rem; font-weight: 700; margin: 10px 0 4px 0; line-height: 1.25;">
                Database Management Systems
            </h3>
            <p style="font-size: 0.82rem; color: #c4decb; margin: 0;">
                Full-Semester Practical Curriculum & Certification Track
            </p>
        </div>

        <form action="/student/courses/buy" method="POST" style="padding: 24px; margin: 0;">
            <?= \App\Core\Csrf::field() ?>
            <input type="hidden" name="code" id="pm-input-code" value="">

            <div style="margin-bottom: 20px;">
                <h4 style="font-size: 0.84rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #435b4b; margin: 0 0 10px 0;">
                    Included with Enrollment:
                </h4>
                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.82rem; color: #2e4738;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #2d6a4f; font-weight: 800;">✓</span>
                        <span>Full access to all 4 modules and recorded mentor walkthroughs</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #2d6a4f; font-weight: 800;">✓</span>
                        <span>Interactive terminal environments & live sandbox exercises</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #2d6a4f; font-weight: 800;">✓</span>
                        <span>Final Capstone defense and verified Kalavanta Certificate</span>
                    </div>
                </div>
            </div>

            <div style="background: #f7faf8; border: 1px solid #d8e6db; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span style="font-size: 0.74rem; font-weight: 600; color: #627467; display: block;">Enrollment Fee</span>
                    <span id="pm-price" style="font-size: 1.45rem; font-weight: 800; color: #183324;">₹1,499</span>
                </div>
                <span style="font-size: 0.74rem; font-weight: 700; color: #2e7d32; background: #e8f5e9; padding: 4px 10px; border-radius: 999px;">
                    Student Cohort Access
                </span>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closePurchaseModal()" style="flex: 1; padding: 11px; border-radius: 10px; background: #f1f4f2; color: #5a7061; border: none; font-weight: 600; font-size: 0.84rem; cursor: pointer; font-family: inherit;">
                    Cancel
                </button>
                <button type="submit" style="flex: 2; padding: 11px; border-radius: 10px; background: #1c4b32; color: #ffffff; border: none; font-weight: 700; font-size: 0.86rem; cursor: pointer; font-family: inherit; box-shadow: 0 2px 8px rgba(28,75,50,0.25);">
                    Confirm & Unlock Instantly &rarr;
                </button>
            </div>
        </form>

    </div>

</div>

<!-- Data store for interactive Learning Modal -->
<script>
window.__CURRICULUM_DATA__ = <?= json_encode($allTracks, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
</script>

<!-- Embedded Interactive Scripts for Filter Tabs, Drawers, Modals & Live Search -->
<style>
@keyframes modalFadeIn {
    from { opacity: 0; transform: translateY(14px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.track-row-item:hover {
    background: #fafcfb;
}
.action-pill-btn.btn-continue:hover {
    background: #1c4b32 !important;
    color: #ffffff !important;
    border-color: #1c4b32 !important;
    box-shadow: 0 3px 8px rgba(28, 75, 50, 0.18);
}
.action-pill-btn.btn-buy:hover {
    background: #fde68a !important;
    color: #78350f !important;
    border-color: #f59e0b !important;
}
.module-card-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(28, 75, 50, 0.06) !important;
}
@media (max-width: 900px) {
    .metrics-overview-grid {
        grid-template-columns: 1fr !important;
    }
    .track-row-item {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 14px !important;
    }
    .track-row-item > div:last-child {
        width: 100% !important;
        justify-content: space-between !important;
    }
    .track-progress-bar-wrap {
        width: 140px !important;
    }
}
</style>

<script>
// Filter Tabs Switching (All Tracks, In Progress, Completed)
function switchCurriculumTab(tabType) {
    document.querySelectorAll('.filter-tab-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.style.fontWeight = '500';
        btn.style.color = '#627467';
        btn.style.borderBottomColor = 'transparent';
    });

    const activeBtn = document.getElementById('tab-' + tabType);
    if (activeBtn) {
        activeBtn.classList.add('active');
        activeBtn.style.fontWeight = '700';
        activeBtn.style.color = '#183324';
        activeBtn.style.borderBottomColor = '#1c4b32';
    }

    const rows = document.querySelectorAll('.track-row-wrapper');
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        if (tabType === 'all') {
            row.style.display = 'block';
        } else if (tabType === 'in-progress') {
            row.style.display = (status === 'in-progress') ? 'block' : 'none';
        } else if (tabType === 'completed') {
            row.style.display = (status === 'completed') ? 'block' : 'none';
        }
    });
}

// Toggle Track Modules Drawer
function toggleTrackDrawer(trackCode) {
    const drawer = document.getElementById('drawer-' + trackCode);
    if (!drawer) return;
    const isHidden = (drawer.style.display === 'none' || drawer.style.display === '');
    drawer.style.display = isHidden ? 'block' : 'none';
    if (isHidden) {
        drawer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// Learning Modal Logic
let currentModalTrack = null;
let currentModalModule = null;
let currentModalLessonIdx = 0;

function openLearningModal(trackCode, moduleNumber) {
    const track = window.__CURRICULUM_DATA__.find(t => t.code === trackCode);
    if (!track) return;
    const mod = (track.modules || []).find(m => m.number == moduleNumber) || track.modules[0];
    if (!mod) return;

    currentModalTrack = track;
    currentModalModule = mod;
    currentModalLessonIdx = 0;

    document.getElementById('lm-track-code').textContent = track.code;
    document.getElementById('lm-track-name').textContent = track.name;
    document.getElementById('lm-modal-title').textContent = mod.title;

    renderModalLessonsSidebar();
    renderActiveLessonContent();

    const modal = document.getElementById('learningModal');
    modal.style.display = 'flex';
}

function closeLearningModal() {
    document.getElementById('learningModal').style.display = 'none';
}

function renderModalLessonsSidebar() {
    const container = document.getElementById('lm-lessons-container');
    container.innerHTML = '';
    const lessons = currentModalModule.lessons || [];

    lessons.forEach((l, idx) => {
        const isCurrent = (idx === currentModalLessonIdx);
        const item = document.createElement('div');
        item.style.padding = '9px 12px';
        item.style.borderRadius = '10px';
        item.style.cursor = 'pointer';
        item.style.transition = 'all 0.15s ease';
        item.style.background = isCurrent ? '#1c4b32' : '#ffffff';
        item.style.color = isCurrent ? '#ffffff' : '#183324';
        item.style.border = isCurrent ? '1px solid #1c4b32' : '1px solid #e5ece6';
        item.style.boxShadow = isCurrent ? '0 2px 6px rgba(28,75,50,0.2)' : 'none';

        item.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                <span style="font-size: 0.7rem; font-weight: 800; ${isCurrent ? 'color: #a8d5b5;' : 'color: #5a7061;'}">${l.code}</span>
                <span style="font-size: 0.68rem; ${isCurrent ? 'color: #c4decb;' : 'color: #7a8d80;'}">${l.duration}</span>
            </div>
            <div style="font-size: 0.8rem; font-weight: 600; margin-top: 3px; line-height: 1.25; ${isCurrent ? 'color: #ffffff;' : 'color: #183324;'}">
                ${l.title}
            </div>
        `;
        item.onclick = () => {
            currentModalLessonIdx = idx;
            renderModalLessonsSidebar();
            renderActiveLessonContent();
        };
        container.appendChild(item);
    });
}

function renderActiveLessonContent() {
    const lessons = currentModalModule.lessons || [];
    const lesson = lessons[currentModalLessonIdx];
    if (!lesson) return;

    document.getElementById('lm-active-lesson-code').textContent = 'Lesson ' + lesson.code;
    document.getElementById('lm-active-lesson-title').textContent = lesson.title;
    document.getElementById('lm-active-lesson-duration').textContent = lesson.duration;
    document.getElementById('lm-active-lesson-summary').textContent = lesson.summary;

    const pointsList = document.getElementById('lm-active-lesson-points');
    pointsList.innerHTML = '';
    (lesson.key_points || []).forEach(pt => {
        const li = document.createElement('li');
        li.style.display = 'flex';
        li.style.alignItems = 'flex-start';
        li.style.gap = '8px';
        li.style.fontSize = '0.84rem';
        li.style.color = '#2d4435';
        li.innerHTML = `<span style="color: #2d6a4f; font-weight: 800; line-height: 1.4;">•</span><span>${pt}</span>`;
        pointsList.appendChild(li);
    });

    document.getElementById('lm-active-lesson-commands').textContent = lesson.commands || 'No command execution required for this conceptual lesson.';
    document.getElementById('lm-active-lesson-lab').textContent = lesson.lab_instructions || 'Complete the lesson review questions and submit the assessment.';

    const isComplete = (lesson.status === 'completed');
    const completeBtn = document.getElementById('lm-complete-toggle-btn');
    const completeText = document.getElementById('lm-complete-text');
    if (isComplete) {
        completeBtn.style.background = '#e8f5e9';
        completeBtn.style.color = '#2e7d32';
        completeBtn.style.borderColor = '#c8e6c9';
        completeText.textContent = 'Completed ✓';
    } else {
        completeBtn.style.background = '#eaf1eb';
        completeBtn.style.color = '#1c4b32';
        completeBtn.style.borderColor = '#d4e2d6';
        completeText.textContent = 'Mark Lesson as Completed';
    }
}

function copyLessonCommand() {
    const cmdText = document.getElementById('lm-active-lesson-commands').textContent;
    navigator.clipboard.writeText(cmdText).then(() => {
        const btn = document.getElementById('lm-copy-btn');
        const orig = btn.textContent;
        btn.textContent = '✓ Copied!';
        btn.style.background = '#2d6a4f';
        btn.style.color = '#ffffff';
        setTimeout(() => {
            btn.textContent = orig;
            btn.style.background = '#eaf1eb';
            btn.style.color = '#1c4b32';
        }, 1800);
    });
}

function toggleLessonComplete() {
    const lessons = currentModalModule.lessons || [];
    const lesson = lessons[currentModalLessonIdx];
    if (!lesson) return;
    lesson.status = (lesson.status === 'completed') ? 'in_progress' : 'completed';
    renderActiveLessonContent();
}

function launchVirtualLabDemo() {
    alert('Launching sandbox instance for ' + currentModalTrack.name + ' (' + currentModalTrack.code + ')...\nVirtual Terminal Container active on port 4200.');
}

// Course Purchase Modal Logic
function openPurchaseModal(code, name, price) {
    document.getElementById('pm-input-code').value = code;
    document.getElementById('pm-course-code').textContent = code;
    document.getElementById('pm-course-name').textContent = name;
    document.getElementById('pm-price').textContent = price;
    document.getElementById('purchaseModal').style.display = 'flex';
}

function closePurchaseModal() {
    document.getElementById('purchaseModal').style.display = 'none';
}

// Live Search Integration with Topbar Search Pill
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-pill-box input');
    if (!searchInput) return;

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.track-row-wrapper');

        rows.forEach(row => {
            if (!query) {
                row.style.display = 'block';
                return;
            }
            const code = (row.getAttribute('data-track-code') || '').toLowerCase();
            const title = (row.querySelector('.track-title-text')?.textContent || '').toLowerCase();
            const subtitle = (row.querySelector('.track-subtitle-text')?.textContent || '').toLowerCase();
            const drawerContent = (row.querySelector('.track-modules-drawer')?.textContent || '').toLowerCase();

            if (code.includes(query) || title.includes(query) || subtitle.includes(query) || drawerContent.includes(query)) {
                row.style.display = 'block';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
