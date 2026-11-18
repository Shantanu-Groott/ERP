<?php
/**
 * Kalavanta Edutech - Student Curriculum & Course Learning Portal
 * Clean course navigation without "tracks", with enlarged module icons (object-fit: cover; object-position: center).
 */
$enrolledList = $enrolledCourses ?? ['CYB301', 'CYB302', 'CYB303', 'CYB304'];
$initialView = $initialView ?? 'courses';
$activeCourseCode = $selectedTrack ?? 'CYB302';
?>
<div class="curriculum-portal-master" style="display: flex; flex-direction: column; gap: 20px;">

    <!-- ==================================================== -->
    <!-- SECTION 1: ALL COURSES LIST VIEW -->
    <!-- ==================================================== -->
    <div id="courses-view-container" style="<?= $initialView === 'modules' ? 'display: none;' : 'display: flex; flex-direction: column; gap: 20px;' ?>">

        <!-- Top Metrics Overview: Side-by-Side Cards -->
        <div class="metrics-overview-grid" style="display: grid; grid-template-columns: minmax(300px, 1fr) minmax(380px, 1.35fr); gap: 20px; align-items: stretch;">
            
            <!-- Left Card: Circular Overall Progress (67%) -->
            <div class="curriculum-stat-card" style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 22px 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 24px;">
                <div style="position: relative; width: 84px; height: 84px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                    <svg width="84" height="84" viewBox="0 0 88 88" style="transform: rotate(-90deg);">
                        <circle cx="44" cy="44" r="35" stroke="#e2ece4" stroke-width="7.5" fill="none" />
                        <circle cx="44" cy="44" r="35" stroke="#1c4b32" stroke-width="7.5" stroke-linecap="round" fill="none"
                                stroke-dasharray="219.9" stroke-dashoffset="72.6" style="transition: stroke-dashoffset 0.8s ease;" />
                    </svg>
                    <div style="position: absolute; text-align: center;">
                        <span style="font-size: 1.32rem; font-weight: 800; color: #183324; line-height: 1;">67%</span>
                    </div>
                </div>

                <div style="flex: 1; min-width: 0;">
                    <h3 style="font-size: 1.05rem; font-weight: 700; color: #183324; margin: 0 0 2px 0;">Overall Progress</h3>
                    <p style="font-size: 0.82rem; color: #627467; margin: 0 0 10px 0; font-weight: 500;">Across All Courses</p>
                    <div style="width: 140px; max-width: 100%; height: 6px; background: #e2ece4; border-radius: 999px; overflow: hidden;">
                        <div style="width: 67%; height: 100%; background: #1c4b32; border-radius: 999px;"></div>
                    </div>
                </div>
            </div>

            <!-- Right Card: 3 Key Metrics with Vertical Dividers -->
            <div class="curriculum-stat-card" style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 22px 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-around;">
                <div style="display: flex; flex-direction: column; gap: 4px; padding: 0 10px;">
                    <span style="font-size: 1.85rem; font-weight: 800; color: #183324; line-height: 1.1;">8</span>
                    <span style="font-size: 0.82rem; font-weight: 500; color: #627467;">Enrolled Courses</span>
                </div>

                <div style="width: 1px; height: 44px; background: #edf2ed;"></div>

                <div style="display: flex; flex-direction: column; gap: 4px; padding: 0 10px;">
                    <span style="font-size: 1.85rem; font-weight: 800; color: #183324; line-height: 1.1;">46</span>
                    <span style="font-size: 0.82rem; font-weight: 500; color: #627467;">Completed Labs</span>
                </div>

                <div style="width: 1px; height: 44px; background: #edf2ed;"></div>

                <div style="display: flex; flex-direction: column; gap: 4px; padding: 0 10px;">
                    <span style="font-size: 1.85rem; font-weight: 800; color: #183324; line-height: 1.1;">12</span>
                    <span style="font-size: 0.82rem; font-weight: 500; color: #627467;">Pending Labs</span>
                </div>
            </div>

        </div>

        <!-- Filter Tabs Row -->
        <div class="curriculum-filter-tabs" style="display: flex; align-items: center; gap: 32px; border-bottom: 1px solid #e2ece4; margin-top: 6px; padding-bottom: 0;">
            <button id="tab-all" class="filter-tab-btn active" onclick="switchCurriculumTab('all')"
                    style="background: transparent; border: none; padding: 8px 4px 12px 4px; font-size: 0.92rem; font-weight: 700; color: #183324; border-bottom: 3px solid #1c4b32; margin-bottom: -1px; cursor: pointer; font-family: inherit; transition: all 0.2s ease;">
                All Courses
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

        <!-- Main Courses List Card -->
        <div id="courses-list-card" style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); overflow: hidden;">
            
            <?php foreach ($allTracks as $index => $t): ?>
                <?php 
                    $code = $t['code'];
                    $isEnrolled = $t['is_enrolled'] ?? in_array($code, $enrolledList, true);
                    $prog = (int)($t['display_progress'] ?? $t['progress']);
                    $statusType = ($prog === 100) ? 'completed' : (($prog > 0) ? 'in-progress' : 'not-started');
                    $isLast = ($index === count($allTracks) - 1);
                ?>
                <div class="course-row-wrapper" data-course-code="<?= htmlspecialchars($code) ?>" data-status="<?= $statusType ?>" data-progress="<?= $prog ?>" style="<?= !$isLast ? 'border-bottom: 1px solid #edf2ed;' : '' ?>">
                    
                    <div class="course-row-item" style="padding: 18px 26px; display: flex; align-items: center; justify-content: space-between; gap: 20px; transition: background 0.15s ease;">
                        
                        <!-- Left: Soft Green Icon Badge + Course Title & Subtitle -->
                        <div style="display: flex; align-items: center; gap: 18px; min-width: 0; flex: 1;">
                            <div class="course-icon-badge" style="width: 48px; height: 48px; min-width: 48px; border-radius: 14px; background: #d7e8db; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <?php if ($t['icon'] === 'shield'): ?>
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                        <path d="M9 12l2 2 4-4"/>
                                    </svg>
                                <?php elseif ($t['icon'] === 'hacker'): ?>
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                        <path d="M4 14l2-2m14 0l-2-2"/>
                                    </svg>
                                <?php elseif ($t['icon'] === 'key'): ?>
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="7.5" cy="15.5" r="4.5"/>
                                        <path d="M10.7 12.3L19 4"/>
                                        <path d="M15 4l4 4"/>
                                        <path d="M17 6l2-2"/>
                                    </svg>
                                <?php elseif ($t['icon'] === 'forensics'): ?>
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                                        <circle cx="12" cy="8" r="1.5" fill="#1c4b32"/>
                                    </svg>
                                <?php elseif ($t['icon'] === 'database'): ?>
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <ellipse cx="12" cy="5" rx="9" ry="3"/>
                                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                                    </svg>
                                <?php elseif ($t['icon'] === 'network'): ?>
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="2" width="6" height="6" rx="1"/>
                                        <rect x="16" y="2" width="6" height="6" rx="1"/>
                                        <rect x="9" y="16" width="6" height="6" rx="1"/>
                                        <path d="M5 8v3a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8"/>
                                        <path d="M12 13v3"/>
                                    </svg>
                                <?php elseif ($t['icon'] === 'theory'): ?>
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="6" cy="6" r="3"/>
                                        <circle cx="18" cy="6" r="3"/>
                                        <circle cx="12" cy="18" r="3"/>
                                        <path d="M8.5 7.5L15.5 7.5"/>
                                        <path d="M7.5 8.5L10.5 15.5"/>
                                        <path d="M16.5 8.5L13.5 15.5"/>
                                    </svg>
                                <?php else: ?>
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1c4b32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="2" y1="12" x2="22" y2="12"/>
                                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                                    </svg>
                                <?php endif; ?>
                            </div>

                            <div style="min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <h4 class="course-title-text" style="font-size: 0.96rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.25;">
                                        <?= htmlspecialchars($t['name']) ?>
                                    </h4>
                                    <span style="font-size: 0.7rem; font-weight: 700; color: #5a7061; background: #eaf1eb; padding: 1px 6px; border-radius: 6px;">
                                        <?= htmlspecialchars($code) ?>
                                    </span>
                                </div>
                                <p class="course-subtitle-text" style="font-size: 0.8rem; color: #627467; margin: 3px 0 0 0; line-height: 1.3;">
                                    <?= htmlspecialchars($t['subtitle']) ?>
                                </p>
                            </div>
                        </div>

                        <!-- Right: Progress Bar + Percentage + Action Button (Strict Linear Grid Alignment) -->
                        <div class="course-metrics-group">
                            
                            <div class="course-progress-bar-wrap" style="width: 240px; height: 6px; background: #e2ece4; border-radius: 999px; overflow: hidden;">
                                <div style="width: <?= $prog ?>%; height: 100%; background: #1c4b32; border-radius: 999px; transition: width 0.4s ease;"></div>
                            </div>

                            <span class="course-percent-num">
                                <?= $prog ?>%
                            </span>

                            <!-- Action Button: Exactly 120px across Continue and View -->
                            <button type="button" class="action-pill-btn <?= $isEnrolled ? 'btn-continue' : 'btn-view' ?>" onclick="showModulesView('<?= htmlspecialchars($code) ?>')">
                                <span><?= $isEnrolled ? 'Continue' : 'View' ?></span>
                                <span style="font-size: 0.95rem;">&rarr;</span>
                            </button>

                        </div>

                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    </div>

    <!-- ==================================================== -->
    <!-- SECTION 2: 2x2 COURSE MODULES VIEW (Exact Mockup Match) -->
    <!-- ==================================================== -->
    <div id="modules-view-container" style="<?= $initialView === 'modules' ? 'display: flex; flex-direction: column; gap: 20px;' : 'display: none; flex-direction: column; gap: 20px;' ?>">
        
        <!-- Modules View Top Bar: Back Button & Course Details (Clean, no track tags/pills) -->
        <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 20px; padding: 18px 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
            
            <div style="display: flex; align-items: center; gap: 14px;">
                <button type="button" onclick="showCoursesView()" style="display: inline-flex; align-items: center; gap: 6px; background: #eaf1eb; color: #1c4b32; border: 1px solid #d4e2d6; padding: 7px 16px; border-radius: 999px; font-size: 0.82rem; font-weight: 700; cursor: pointer; font-family: inherit; transition: all 0.15s ease;">
                    <span>&larr;</span>
                    <span>Back to All Courses</span>
                </button>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span id="mv-course-code" style="background: #d7e8db; color: #1c4b32; font-size: 0.72rem; font-weight: 800; padding: 2px 8px; border-radius: 6px;">
                            CYB302
                        </span>
                        <h2 id="mv-course-name" class="font-serif" style="font-size: 1.25rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.2;">
                            Ethical Hacking & Pen Testing
                        </h2>
                    </div>
                    <p id="mv-course-subtitle" style="font-size: 0.8rem; color: #627467; margin: 2px 0 0 0;">
                        Learn penetration testing techniques • 4 Syllabus Modules
                    </p>
                </div>
            </div>

            <!-- Course Overall Progress Indicator -->
            <div style="display: flex; align-items: center; gap: 12px; background: #f8faf8; padding: 6px 16px; border-radius: 999px; border: 1px solid #e2ece4;">
                <span style="font-size: 0.78rem; font-weight: 600; color: #5a7061;">Course Progress:</span>
                <div style="width: 100px; height: 6px; background: #e2ece4; border-radius: 999px; overflow: hidden;">
                    <div id="mv-course-progbar" style="width: 50%; height: 100%; background: #1c4b32; border-radius: 999px; transition: width 0.4s ease;"></div>
                </div>
                <span id="mv-course-percent" style="font-size: 0.82rem; font-weight: 800; color: #183324;">50%</span>
            </div>

        </div>

        <!-- 2x2 Grid of 4 Module Cards (Enlarged Icons with object-fit: cover; object-position: center;) -->
        <div id="modules-grid-2x2" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <!-- Dynamically populated by render2x2ModulesGrid -->
        </div>

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
                <span id="lm-course-code" style="background: rgba(255,255,255,0.2); font-size: 0.74rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                    CYB302
                </span>
                <div>
                    <h3 id="lm-modal-title" style="font-size: 1.05rem; font-weight: 700; margin: 0; line-height: 1.2;">
                        Module 1: Reconnaissance & OSINT
                    </h3>
                    <p id="lm-course-name" style="font-size: 0.78rem; color: #c4decb; margin: 2px 0 0 0;">
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

<!-- Data store for interactive Modules View & Learning Modal -->
<script>
window.__CURRICULUM_DATA__ = <?= json_encode($allTracks, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
window.__ACTIVE_COURSE_CODE__ = <?= json_encode($activeCourseCode) ?>;
</script>

<style>
@keyframes modalFadeIn {
    from { opacity: 0; transform: translateY(14px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.course-row-item:hover {
    background: #fafcfb;
}
.course-metrics-group {
    display: grid;
    grid-template-columns: 240px 48px 120px;
    gap: 20px;
    align-items: center;
    flex-shrink: 0;
}
.course-percent-num {
    font-size: 0.86rem;
    font-weight: 700;
    color: #183324;
    text-align: right;
    font-variant-numeric: tabular-nums;
    white-space: nowrap;
    display: block;
}
.action-pill-btn {
    width: 120px;
    height: 36px;
    border-radius: 999px;
    background: #eaf1eb;
    color: #1c4b32;
    font-weight: 600;
    font-size: 0.83rem;
    border: 1px solid #d4e2d6;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.15s ease;
    font-family: inherit;
    box-sizing: border-box;
    white-space: nowrap;
    text-decoration: none;
}
.action-pill-btn:hover {
    background: #1c4b32 !important;
    color: #ffffff !important;
    border-color: #1c4b32 !important;
    box-shadow: 0 3px 8px rgba(28, 75, 50, 0.18);
}
.module-2x2-card {
    background: #ffffff;
    border: 1px solid #e2ece4;
    border-radius: 22px;
    padding: 24px 26px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 16px;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.module-2x2-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(28, 75, 50, 0.06);
}
.module-btn-action:hover {
    background: #143724 !important;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(28, 75, 50, 0.22);
}
@media (max-width: 960px) {
    #modules-grid-2x2 {
        grid-template-columns: 1fr !important;
    }
    .metrics-overview-grid {
        grid-template-columns: 1fr !important;
    }
    .course-row-item {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 14px !important;
    }
    .course-metrics-group {
        width: 100% !important;
        grid-template-columns: 1fr auto auto !important;
        gap: 14px !important;
    }
    .course-progress-bar-wrap {
        width: 100% !important;
    }
}
@media (max-width: 580px) {
    .course-metrics-group {
        grid-template-columns: 1fr auto !important;
        gap: 10px !important;
    }
    .course-metrics-group .action-pill-btn {
        grid-column: span 2;
        width: 100% !important;
    }
}
</style>

<script>
// ==========================================
// VIEW SWITCHING: Courses List <-> 2x2 Modules
// ==========================================

function showCoursesView() {
    document.getElementById('modules-view-container').style.display = 'none';
    const coursesContainer = document.getElementById('courses-view-container');
    coursesContainer.style.display = 'flex';
    coursesContainer.style.flexDirection = 'column';
    coursesContainer.style.gap = '20px';
    
    // Update browser URL cleanly
    try {
        history.pushState(null, '', '/student/curriculum');
    } catch(e) {}
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function showModulesView(courseCode) {
    const course = window.__CURRICULUM_DATA__.find(t => t.code === courseCode);
    if (!course) return;

    window.__ACTIVE_COURSE_CODE__ = courseCode;

    // Update Topbar Info in Modules View
    document.getElementById('mv-course-code').textContent = course.code;
    document.getElementById('mv-course-name').textContent = course.name;
    document.getElementById('mv-course-subtitle').textContent = course.subtitle + ' • 4 Syllabus Modules';
    
    const prog = course.display_progress !== undefined ? course.display_progress : course.progress;
    document.getElementById('mv-course-progbar').style.width = prog + '%';
    document.getElementById('mv-course-percent').textContent = prog + '%';

    // Render the 4 Module Cards in 2x2 Grid with enlarged icons (object-fit: cover; object-position: center;)
    render2x2ModulesGrid(course);

    // Switch view containers
    document.getElementById('courses-view-container').style.display = 'none';
    const modulesContainer = document.getElementById('modules-view-container');
    modulesContainer.style.display = 'flex';
    modulesContainer.style.flexDirection = 'column';
    modulesContainer.style.gap = '20px';

    // Update browser URL cleanly
    try {
        history.pushState(null, '', '/student/curriculum?course=' + encodeURIComponent(courseCode));
    } catch(e) {}
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function render2x2ModulesGrid(course) {
    const container = document.getElementById('modules-grid-2x2');
    container.innerHTML = '';
    const modules = course.modules || [];

    modules.forEach((mod) => {
        const modNum = mod.number || 1;
        const modTitle = mod.title || ('Module ' + modNum);
        const modProg = mod.progress || 0;
        const modImage = mod.image || ('/assets/img/curriculum-mod' + modNum + '.png');
        const lessons = mod.lessons || [];

        // Exact button labels matching mockup image media_1794914362125_ecd92b1c.jpg:
        // Mod 1 -> Viewed (100%), Mod 2 -> Continue (75%), Mod 3 -> Continue (40%), Mod 4 -> Start Module (10%)
        let btnText = mod.action_label;
        if (!btnText) {
            if (modProg === 100) btnText = 'Viewed';
            else if (modProg > 0) btnText = 'Continue';
            else btnText = 'Start Module';
        }

        // Circular Donut Ring Calculation (radius 17, circumference 106.8)
        const circumference = 106.8;
        const dashoffset = circumference * (1 - (modProg / 100));

        // Build Card HTML
        const card = document.createElement('div');
        card.className = 'module-2x2-card';

        // Header: Title + Circular Ring
        let headerHtml = `
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 14px;">
                <h3 style="font-size: 1.05rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.3;">
                    ${escapeHtml(modTitle)}
                </h3>
                <div style="position: relative; width: 44px; height: 44px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                    <svg width="44" height="44" viewBox="0 0 44 44" style="transform: rotate(-90deg);">
                        <circle cx="22" cy="22" r="17" stroke="#e2ece4" stroke-width="3.5" fill="none" />
                        <circle cx="22" cy="22" r="17" stroke="#1c4b32" stroke-width="3.5" stroke-linecap="round" fill="none"
                                stroke-dasharray="106.8" stroke-dashoffset="${dashoffset.toFixed(1)}" />
                    </svg>
                    <span style="position: absolute; font-size: 0.72rem; font-weight: 800; color: #183324;">
                        ${modProg}%
                    </span>
                </div>
            </div>
        `;

        // Body: Left Illustration Box (Enlarged to 135x135 with object-fit: cover; object-position: center;) + Right Lessons Checklist
        let lessonsHtml = '';
        lessons.forEach(l => {
            const isCompleted = (l.status === 'completed');
            const isInProgress = (l.status === 'in_progress');

            // Left icon
            let iconHtml = '';
            if (isCompleted) {
                iconHtml = `<span style="width: 17px; height: 17px; min-width: 17px; border-radius: 50%; background: #2d6a4f; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 0.62rem; font-weight: 800;">✓</span>`;
            } else if (isInProgress) {
                iconHtml = `<span style="width: 17px; height: 17px; min-width: 17px; border-radius: 50%; border: 2px dashed #2d6a4f; display: flex; align-items: center; justify-content: center;"></span>`;
            } else {
                iconHtml = `<span style="width: 17px; height: 17px; min-width: 17px; border-radius: 50%; border: 1.5px solid #b8ccbc; display: flex; align-items: center; justify-content: center;"></span>`;
            }

            // Right status
            let rightStatusHtml = '';
            if (isCompleted) {
                rightStatusHtml = `<span style="color: #617b68; font-size: 0.8rem; font-weight: 600;">✓</span>`;
            } else if (isInProgress) {
                rightStatusHtml = `<span style="color: #2d6a4f; font-size: 0.74rem; font-weight: 700;">In Progress</span>`;
            } else {
                rightStatusHtml = `<span style="color: #829687; font-size: 0.74rem; font-weight: 500;">Not Started</span>`;
            }

            lessonsHtml += `
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 8px; min-width: 0;">
                        ${iconHtml}
                        <span style="font-size: 0.82rem; font-weight: 500; color: #223c2a; line-height: 1.25; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            ${escapeHtml(l.code)} ${escapeHtml(l.title)}
                        </span>
                    </div>
                    <div style="flex-shrink: 0;">
                        ${rightStatusHtml}
                    </div>
                </div>
            `;
        });

        // Enlarged icon container (135px x 135px) with object-fit: cover; object-position: center;
        let bodyHtml = `
            <div style="display: flex; align-items: center; gap: 20px; margin: 12px 0;">
                <div style="width: 135px; height: 135px; min-width: 135px; border-radius: 18px; background: #f2f7f3; overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
                    <img src="${modImage}" alt="${escapeHtml(modTitle)}" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; border-radius: 18px;">
                </div>
                <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 10px;">
                    ${lessonsHtml}
                </div>
            </div>
        `;

        // Footer: Dark Green Pill Button matching mockup
        let footerHtml = `
            <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: auto; padding-top: 4px;">
                <button type="button" class="module-btn-action" onclick="openLearningModal('${course.code}', ${modNum})"
                        style="background: #1c4b32; color: #ffffff; border: none; border-radius: 999px; padding: 8px 26px; font-weight: 600; font-size: 0.84rem; cursor: pointer; transition: all 0.15s ease; font-family: inherit;">
                    ${escapeHtml(btnText)}
                </button>
            </div>
        `;

        card.innerHTML = headerHtml + bodyHtml + footerHtml;
        container.appendChild(card);
    });
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, function(m) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
    });
}

// ==========================================
// FILTER TABS SWITCHING (Courses List)
// ==========================================
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

    const rows = document.querySelectorAll('.course-row-wrapper');
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

// ==========================================
// INTERACTIVE LEARNING MODAL
// ==========================================
let currentModalCourse = null;
let currentModalModule = null;
let currentModalLessonIdx = 0;

function openLearningModal(courseCode, moduleNumber) {
    const course = window.__CURRICULUM_DATA__.find(t => t.code === courseCode);
    if (!course) return;
    const mod = (course.modules || []).find(m => m.number == moduleNumber) || course.modules[0];
    if (!mod) return;

    currentModalCourse = course;
    currentModalModule = mod;
    currentModalLessonIdx = 0;

    document.getElementById('lm-course-code').textContent = course.code;
    document.getElementById('lm-course-name').textContent = course.name;
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
    alert('Launching sandbox instance for ' + currentModalCourse.name + ' (' + currentModalCourse.code + ')...\nVirtual Terminal Container active on port 4200.');
}

// ==========================================
// INITIAL SETUP ON DOM LOAD
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    // Initial render of 2x2 grid if modules view is requested
    const initialCourseCode = window.__ACTIVE_COURSE_CODE__ || 'CYB302';
    const course = window.__CURRICULUM_DATA__.find(t => t.code === initialCourseCode);
    if (course) {
        render2x2ModulesGrid(course);
    }

    // Topbar live search integration
    const searchInput = document.querySelector('.search-pill-box input');
    if (!searchInput) return;

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.course-row-wrapper');

        rows.forEach(row => {
            if (!query) {
                row.style.display = 'block';
                return;
            }
            const code = (row.getAttribute('data-course-code') || '').toLowerCase();
            const title = (row.querySelector('.course-title-text')?.textContent || '').toLowerCase();
            const subtitle = (row.querySelector('.course-subtitle-text')?.textContent || '').toLowerCase();

            if (code.includes(query) || title.includes(query) || subtitle.includes(query)) {
                row.style.display = 'block';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
