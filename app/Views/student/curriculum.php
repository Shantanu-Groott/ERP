<?php
/**
 * Kalavanta Edutech - Student Curriculum & Course Learning Portal
 */
$enrolledList = $enrolledCourses ?? ['CYB301', 'CYB302', 'CYB303', 'CYB304'];
?>
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Notification Alert for Instant Unlocks -->
    <?php if (!empty($_GET['unlocked'])): ?>
        <div style="background: #e6f4ea; border: 1px solid #a8dab5; border-radius: 14px; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 14px; box-shadow: 0 2px 6px rgba(28, 75, 50, 0.08);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="width: 32px; height: 32px; border-radius: 50%; background: #2d6a4f; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.95rem;">✓</span>
                <div>
                    <h4 style="font-size: 0.92rem; font-weight: 700; color: #153e28; margin: 0 0 2px 0;">Course Successfully Unlocked!</h4>
                    <p style="font-size: 0.78rem; color: #375943; margin: 0;">You now have full access to all 4 modules, command terminals, and interactive sandboxes.</p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" style="background: transparent; border: none; font-size: 1.1rem; color: #2d6a4f; cursor: pointer;">✕</button>
        </div>
    <?php endif; ?>

    <!-- Top Course Navigation Bar (Replaces cramped text with clean, elegant tabs) -->
    <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 20px; padding: 20px 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 16px;">
        
        <!-- Header row with Filter Switcher & Student Identity -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; padding-bottom: 14px; border-bottom: 1px solid #edf2ed;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #627467;">
                    Select Course:
                </span>
                <div style="display: inline-flex; background: #eaf1eb; padding: 3px; border-radius: 10px; border: 1px solid #d8e5da;">
                    <button id="filter-btn-enrolled" onclick="filterTrackPills('enrolled')" style="background: #ffffff; color: #1c4b32; font-weight: 700; font-size: 0.78rem; padding: 4px 12px; border-radius: 7px; border: none; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.06); font-family: inherit;">
                        My Enrolled Courses (<?= count($myEnrolledSubjects) ?>)
                    </button>
                    <button id="filter-btn-all" onclick="filterTrackPills('all')" style="background: transparent; color: #5a7061; font-weight: 600; font-size: 0.78rem; padding: 4px 12px; border-radius: 7px; border: none; cursor: pointer; font-family: inherit;">
                        All Catalog Courses (<?= count($subjects) ?>)
                    </button>
                </div>
            </div>

            <!-- Student Profile Badge -->
            <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 0.78rem; font-weight: 600; color: #3b5343; background: #f3f7f4; padding: 6px 14px; border-radius: 999px; border: 1px solid #dce8de;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
                <span><?= htmlspecialchars($student['class_name'] ?? 'TE Computer') ?></span>
                <span>•</span>
                <span>Roll: <?= htmlspecialchars($student['roll_no'] ?? 'COMP-2026-001') ?></span>
                <span>•</span>
                <span style="font-weight: 700; color: #1c4b32;">Shantanu</span>
            </div>
        </div>

        <!-- Clean Course Pills Grid -->
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;" id="track-pills-container">
            <?php foreach ($subjects as $s): ?>
                <?php 
                    $code = $s['code'];
                    $isActive = ($code === $selectedTrack);
                    $isSubEnrolled = in_array($code, $enrolledList, true);
                ?>
                <a href="/student/curriculum?track=<?= urlencode($code) ?>" 
                   class="track-pill-item <?= $isSubEnrolled ? 'is-enrolled' : 'is-catalog' ?>"
                   style="padding: 7px 14px; border-radius: 12px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.15s ease; display: inline-flex; align-items: center; gap: 8px; border: 1px solid; <?= $isActive ? 'background: #1c4b32; color: #ffffff; border-color: #1c4b32; box-shadow: 0 3px 8px rgba(28,75,50,0.25);' : ($isSubEnrolled ? 'background: #f7faf8; color: #234f36; border-color: #d1e2d4;' : 'background: #ffffff; color: #627467; border-color: #e2e8e3;') ?>">
                    
                    <!-- Code Tag -->
                    <span style="font-size: 0.72rem; font-weight: 800; padding: 2px 6px; border-radius: 6px; <?= $isActive ? 'background: rgba(255,255,255,0.2); color: #fff;' : ($isSubEnrolled ? 'background: #e2ede5; color: #1c4b32;' : 'background: #f1f3f1; color: #7a8d80;') ?>">
                        <?= htmlspecialchars($code) ?>
                    </span>

                    <!-- Course Title -->
                    <span style="line-height: 1.2;"><?= htmlspecialchars($s['name']) ?></span>

                    <!-- Enrolled vs Buy Tag -->
                    <?php if ($isSubEnrolled): ?>
                        <span style="font-size: 0.66rem; font-weight: 700; padding: 1px 6px; border-radius: 999px; <?= $isActive ? 'background: #2ecc71; color: #143e26;' : 'background: #e8f5e9; color: #2e7d32;' ?>">
                            ✓ Enrolled
                        </span>
                    <?php else: ?>
                        <span style="font-size: 0.66rem; font-weight: 700; padding: 1px 6px; border-radius: 999px; <?= $isActive ? 'background: #fef3c7; color: #92400e;' : 'background: #fffbeb; color: #b45309; border: 1px solid #fde68a;' ?>">
                            🔒 Buy
                        </span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Active Course Overview Banner -->
    <div style="background: <?= $isEnrolled ? 'linear-gradient(135deg, #1c4b32 0%, #285f43 100%)' : 'linear-gradient(135deg, #2c3e35 0%, #3f5549 100%)' ?>; border-radius: 20px; padding: 24px 28px; color: #ffffff; box-shadow: 0 4px 14px rgba(28, 75, 50, 0.12); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                <span style="background: rgba(255,255,255,0.2); color: #ffffff; font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                    <?= htmlspecialchars($activeSubject['code'] ?? 'CYB302') ?>
                </span>
                <span style="font-size: 0.76rem; color: #c4decb; font-weight: 600;">
                    <?= htmlspecialchars($activeSubject['department_name'] ?? 'Computer Engineering') ?> • <?= (int)($activeSubject['credits'] ?? 4) ?> Credits
                </span>
                <?php if ($isEnrolled): ?>
                    <span style="background: #2ecc71; color: #103820; font-size: 0.7rem; font-weight: 800; padding: 2px 8px; border-radius: 999px;">
                        ✓ Enrolled & Active
                    </span>
                <?php else: ?>
                    <span style="background: #f59e0b; color: #ffffff; font-size: 0.7rem; font-weight: 800; padding: 2px 8px; border-radius: 999px;">
                        🔒 Syllabus Preview (Not Enrolled)
                    </span>
                <?php endif; ?>
            </div>

            <h2 style="font-size: 1.5rem; font-weight: 800; margin: 0 0 6px 0; font-family: 'Newsreader', Georgia, serif; letter-spacing: -0.3px;">
                <?= htmlspecialchars($activeSubject['name'] ?? 'Ethical Hacking & Penetration Testing') ?>
            </h2>

            <p style="font-size: 0.84rem; color: #d6ebd9; margin: 0; max-width: 650px; line-height: 1.45;">
                <?php if ($isEnrolled): ?>
                    Lead Mentor: <strong><?= htmlspecialchars($activeSubject['instructor_name'] ?? 'Prof. Robert Miller') ?></strong>. All 4 curriculum modules, hands-on Linux terminal sandboxes, and verification quizzes are unlocked for your profile.
                <?php else: ?>
                    Lead Mentor: <strong><?= htmlspecialchars($activeSubject['instructor_name'] ?? 'Prof. Robert Miller') ?></strong>. You are currently viewing the course syllabus in preview mode. Enroll to unlock interactive virtual labs, terminal exercises, and verified certificate credentials.
                <?php endif; ?>
            </p>
        </div>

        <div>
            <?php if ($isEnrolled): ?>
                <?php
                    $totalMod = count($modules);
                    $sumProgress = array_reduce($modules, fn($c, $m) => $c + (int)($m['progress'] ?? 0), 0);
                    $avgProgress = $totalMod > 0 ? round($sumProgress / $totalMod) : 0;
                ?>
                <div style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); border-radius: 14px; padding: 14px 18px; text-align: center; min-width: 170px;">
                    <div style="font-size: 0.72rem; color: #c4decb; font-weight: 600; margin-bottom: 4px;">Track Progress</div>
                    <div style="font-size: 1.6rem; font-weight: 800; color: #ffffff; line-height: 1;"><?= $avgProgress ?>%</div>
                    <div style="background: rgba(255,255,255,0.25); height: 5px; border-radius: 3px; overflow: hidden; margin-top: 8px;">
                        <div style="background: #2ecc71; height: 100%; width: <?= $avgProgress ?>%;"></div>
                    </div>
                </div>
            <?php else: ?>
                <button onclick="openPurchaseModal()" style="background: #f59e0b; color: #1c2b20; border: none; padding: 12px 24px; border-radius: 12px; font-size: 0.88rem; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4); display: inline-flex; align-items: center; gap: 8px; transition: all 0.15s ease;" onmouseover="this.style.background='#d97706'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#f59e0b'; this.style.transform='none';">
                    <span>⚡ Buy & Unlock Course — <?= htmlspecialchars($coursePrice) ?></span>
                </button>
            <?php endif; ?>
        </div>

    </div>

    <!-- 2x2 Curriculum Module Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(440px, 1fr)); gap: 24px;">
        <?php foreach ($modules as $modIndex => $mod): ?>
            <?php
                $pct = $isEnrolled ? (int)($mod['progress'] ?? 0) : 0;
                $radius = 21;
                $circumference = 2 * M_PI * $radius; // ~131.95
                $dashoffset = $circumference - ($circumference * ($pct / 100));
            ?>
            <div style="background: #ffffff; border: 1px solid #d5e0d5; border-radius: 20px; padding: 24px 26px; box-shadow: 0 2px 8px rgba(33, 75, 52, 0.04); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.15s ease, box-shadow 0.15s ease;">
                
                <!-- Card Header: Title & Circular Donut Progress Gauge -->
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px;">
                    <div>
                        <span style="font-size: 0.72rem; font-weight: 800; color: #2d6a4f; text-transform: uppercase; letter-spacing: 0.5px;">Module <?= (int)$mod['number'] ?></span>
                        <h3 style="font-size: 1.1rem; font-weight: 700; color: #163622; line-height: 1.35; margin: 3px 0 0 0;">
                            <?= htmlspecialchars($mod['title']) ?>
                        </h3>
                    </div>

                    <!-- Circular Progress Gauge Badge -->
                    <div style="position: relative; width: 54px; height: 54px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                        <?php if ($isEnrolled): ?>
                            <svg width="54" height="54" viewBox="0 0 54 54" style="transform: rotate(-90deg);">
                                <circle cx="27" cy="27" r="<?= $radius ?>" stroke="#dbe7dc" stroke-width="4.5" fill="none" />
                                <circle cx="27" cy="27" r="<?= $radius ?>" 
                                        stroke="#245a3e" 
                                        stroke-width="4.5" 
                                        stroke-linecap="round" 
                                        fill="none" 
                                        stroke-dasharray="<?= round($circumference, 2) ?>" 
                                        stroke-dashoffset="<?= round($dashoffset, 2) ?>" 
                                        style="transition: stroke-dashoffset 0.6s ease;" />
                            </svg>
                            <span style="position: absolute; font-size: 0.82rem; font-weight: 800; color: #163622;">
                                <?= $pct ?>%
                            </span>
                        <?php else: ?>
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: #fef3c7; color: #92400e; display: flex; align-items: center; justify-content: center; font-size: 1rem;" title="Locked: Purchase course to access">
                                🔒
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Card Body: Left Graphic Illustration & Right Lessons Checklist -->
                <div style="display: flex; align-items: flex-start; gap: 20px; flex: 1;">
                    
                    <!-- Left Graphic Illustration -->
                    <div style="width: 135px; height: 130px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border-radius: 12px; background: #f8faf8; border: 1px solid #edf2ed; overflow: hidden; padding: 4px;">
                        <img src="<?= htmlspecialchars($mod['image']) ?>" 
                             alt="<?= htmlspecialchars($mod['title']) ?>" 
                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>

                    <!-- Right Lessons Checklist -->
                    <div style="display: flex; flex-direction: column; gap: 11px; flex: 1; min-width: 0;">
                        <?php foreach (($mod['lessons'] ?? []) as $lesson): ?>
                            <?php 
                                $status = $isEnrolled ? ($lesson['status'] ?? 'not_started') : 'locked'; 
                                $isDone = ($status === 'completed');
                                $isInProgress = ($status === 'in_progress');
                            ?>
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; font-size: 0.82rem; font-weight: 600; color: #1e3526;">
                                
                                <!-- Icon & Lesson Name -->
                                <div style="display: flex; align-items: center; gap: 8px; min-width: 0;">
                                    <?php if ($isDone): ?>
                                        <span style="width: 16px; height: 16px; border-radius: 50%; background: #2d6a4f; display: inline-flex; align-items: center; justify-content: center; color: #ffffff; flex-shrink: 0; font-size: 0.65rem;">
                                            ✓
                                        </span>
                                    <?php elseif ($isInProgress): ?>
                                        <span style="width: 16px; height: 16px; border: 1.5px dashed #2d6a4f; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; background: #eef6f0;">
                                        </span>
                                    <?php else: ?>
                                        <span style="width: 16px; height: 16px; border: 1.5px solid #a3b8a6; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        </span>
                                    <?php endif; ?>

                                    <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; <?= $isDone ? 'color: #1a3323;' : ($isInProgress ? 'color: #1e3526; font-weight: 700;' : 'color: #425b49;') ?>">
                                        <?= htmlspecialchars($lesson['code'] . ' ' . $lesson['title']) ?>
                                    </span>
                                </div>

                                <!-- Right Status Indicator -->
                                <div style="flex-shrink: 0; font-size: 0.74rem;">
                                    <?php if ($isDone): ?>
                                        <span style="color: #2d6a4f; font-weight: 700;">Done</span>
                                    <?php elseif ($isInProgress): ?>
                                        <span style="color: #2563eb; font-weight: 700;">In Progress</span>
                                    <?php elseif ($isEnrolled): ?>
                                        <span style="color: #7b9181; font-weight: 500;">Ready</span>
                                    <?php else: ?>
                                        <span style="color: #b45309; font-weight: 600;">Preview</span>
                                    <?php endif; ?>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>

                <!-- Card Bottom Row: Interactive Learning Button or Buy Button -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 14px; border-top: 1px solid #edf3ed;">
                    <span style="font-size: 0.74rem; color: #627467;">
                        <?= count($mod['lessons'] ?? []) ?> Structured Lessons & Practical Labs
                    </span>

                    <?php if ($isEnrolled): ?>
                        <button onclick="openLearningModal(<?= $modIndex ?>)" 
                                style="background: #153e28; color: #ffffff; padding: 8px 20px; border-radius: 10px; font-size: 0.82rem; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 2px 6px rgba(21, 62, 40, 0.2); transition: all 0.15s ease; display: inline-flex; align-items: center; gap: 6px; font-family: inherit;" 
                                onmouseover="this.style.background='#1b4d32'; this.style.transform='translateY(-1px)';" 
                                onmouseout="this.style.background='#153e28'; this.style.transform='none';">
                            <span><?= htmlspecialchars($mod['action_label'] ?? 'Start Learning') ?></span>
                            <span>&rarr;</span>
                        </button>
                    <?php else: ?>
                        <button onclick="openPurchaseModal()" 
                                style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a; padding: 7px 18px; border-radius: 10px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease; font-family: inherit;"
                                onmouseover="this.style.background='#fef3c7';"
                                onmouseout="this.style.background='#fffbeb';">
                            <span>🔒 Unlock with Course</span>
                            <span>(<?= htmlspecialchars($coursePrice) ?>)</span>
                        </button>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- ========================================================= -->
<!-- INTERACTIVE LEARNING MODAL (Study Viewer & Sandbox Labs) -->
<!-- ========================================================= -->
<div id="learningModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(12, 28, 18, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 18px;">
    
    <div style="background: #ffffff; width: 100%; max-width: 960px; max-height: 90vh; border-radius: 22px; box-shadow: 0 16px 40px rgba(0,0,0,0.22); border: 1px solid #cfe2d3; display: flex; flex-direction: column; overflow: hidden; animation: modalPop 0.2s ease-out;">
        
        <!-- Modal Top Bar -->
        <div style="background: #1c4b32; color: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #153e28;">
            <div>
                <span id="modal-track-badge" style="background: rgba(255,255,255,0.2); font-size: 0.72rem; font-weight: 800; padding: 2px 7px; border-radius: 5px;">
                    CYB302
                </span>
                <h3 id="modal-module-title" style="font-size: 1.15rem; font-weight: 800; margin: 4px 0 0 0; line-height: 1.3;">
                    Module Title
                </h3>
            </div>
            
            <div style="display: flex; align-items: center; gap: 14px;">
                <span id="modal-module-progress" style="background: #2ecc71; color: #113a21; font-size: 0.74rem; font-weight: 800; padding: 3px 10px; border-radius: 999px;">
                    75% Completed
                </span>
                <button onclick="closeLearningModal()" style="background: rgba(255,255,255,0.15); border: none; color: #ffffff; width: 32px; height: 32px; border-radius: 50%; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                    ✕
                </button>
            </div>
        </div>

        <!-- Modal Split Content: Left Lesson Index + Right Technical Material -->
        <div style="display: flex; flex: 1; min-height: 0; overflow: hidden;">
            
            <!-- Left Pane: Lessons Navigation -->
            <div style="width: 290px; background: #f7faf8; border-right: 1px solid #dce8de; overflow-y: auto; padding: 16px 14px; display: flex; flex-direction: column; gap: 8px;" id="modal-lessons-list">
                <!-- Dynamically populated via JS -->
            </div>

            <!-- Right Pane: Active Lesson Technical Content -->
            <div style="flex: 1; overflow-y: auto; padding: 24px 30px; display: flex; flex-direction: column; gap: 20px; background: #ffffff;" id="modal-lesson-body">
                
                <!-- Lesson Header -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span id="active-lesson-code" style="font-size: 0.74rem; font-weight: 800; color: #2d6a4f; text-transform: uppercase;">
                            LESSON 2.1
                        </span>
                        <span id="active-lesson-duration" style="font-size: 0.72rem; color: #7a8d80; font-weight: 600;">
                            30 mins
                        </span>
                    </div>
                    <h2 id="active-lesson-title" style="font-size: 1.35rem; font-weight: 800; color: #143722; margin: 0; font-family: 'Newsreader', Georgia, serif;">
                        Understanding Packet Tracing & Flags
                    </h2>
                </div>

                <!-- Summary Box -->
                <div style="background: #f4f8f5; border-left: 4px solid #2d6a4f; padding: 12px 16px; border-radius: 4px 10px 10px 4px;">
                    <h5 style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; color: #2d6a4f; margin: 0 0 4px 0; letter-spacing: 0.5px;">Executive Overview</h5>
                    <p id="active-lesson-summary" style="font-size: 0.82rem; color: #375040; margin: 0; line-height: 1.45;">
                        Overview text...
                    </p>
                </div>

                <!-- Key Concepts -->
                <div>
                    <h4 style="font-size: 0.88rem; font-weight: 700; color: #163622; margin: 0 0 8px 0;">
                        Key Technical Takeaways
                    </h4>
                    <ul id="active-lesson-keypoints" style="margin: 0; padding-left: 20px; font-size: 0.82rem; color: #435b4b; line-height: 1.55; display: flex; flex-direction: column; gap: 6px;">
                        <!-- Injected via JS -->
                    </ul>
                </div>

                <!-- Command / Terminal Box -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <h4 style="font-size: 0.88rem; font-weight: 700; color: #163622; margin: 0;">
                            CLI / Terminal Reference Command
                        </h4>
                        <button onclick="copyCommand()" id="copy-btn" style="background: #eef3ee; border: 1px solid #d5e2d6; color: #1c4b32; font-size: 0.72rem; font-weight: 700; padding: 3px 9px; border-radius: 6px; cursor: pointer;">
                            Copy Syntax
                        </button>
                    </div>
                    <pre id="active-lesson-commands" style="background: #112417; color: #4ade80; padding: 14px 16px; border-radius: 10px; font-family: 'Consolas', 'Fira Code', monospace; font-size: 0.8rem; overflow-x: auto; margin: 0; line-height: 1.45;"></pre>
                </div>

                <!-- Hands-on Lab Exercise -->
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px 16px;">
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                        <span style="font-size: 0.76rem; font-weight: 800; color: #1e40af; text-transform: uppercase;">
                            ⚡ Practical Lab Exercise
                        </span>
                    </div>
                    <p id="active-lesson-lab" style="font-size: 0.82rem; color: #1e3a8a; margin: 0; line-height: 1.45;">
                        Lab instructions...
                    </p>
                </div>

                <!-- Footer Action Controls -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 16px; border-top: 1px solid #edf2ed;">
                    <button onclick="toggleLessonCompletion()" id="btn-toggle-complete" style="background: #e8f5e9; color: #1e4620; border: 1px solid #a8dab5; padding: 8px 16px; border-radius: 9px; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-family: inherit;">
                        <span id="complete-check-icon">✓</span>
                        <span id="complete-btn-text">Mark Lesson Completed</span>
                    </button>

                    <div style="display: flex; gap: 10px;">
                        <a href="/student/live-class" style="background: #1c4b32; color: #ffffff; text-decoration: none; padding: 8px 16px; border-radius: 9px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(28, 75, 50, 0.2);">
                            <span>Launch Virtual Lab ↗</span>
                        </a>
                        <button onclick="nextLesson()" style="background: #f0f6f1; color: #2d6a4f; border: 1px solid #cfe0d2; padding: 8px 16px; border-radius: 9px; font-size: 0.8rem; font-weight: 700; cursor: pointer; font-family: inherit;">
                            Next Lesson &rarr;
                        </button>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- ========================================================= -->
<!-- COURSE PURCHASE / UNLOCK MODAL                           -->
<!-- ========================================================= -->
<div id="purchaseModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(12, 28, 18, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 18px;">
    
    <div style="background: #ffffff; width: 100%; max-width: 520px; border-radius: 22px; box-shadow: 0 16px 40px rgba(0,0,0,0.22); border: 1px solid #cfe2d3; padding: 28px; display: flex; flex-direction: column; gap: 20px; animation: modalPop 0.2s ease-out;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #fef3c7; color: #92400e; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                    🎓
                </div>
                <div>
                    <span style="font-size: 0.72rem; font-weight: 800; color: #2d6a4f; text-transform: uppercase;">
                        Instant Course Enrollment
                    </span>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #153e28; margin: 2px 0 0 0; line-height: 1.25;">
                        <?= htmlspecialchars($activeSubject['name']) ?>
                    </h3>
                </div>
            </div>
            <button onclick="closePurchaseModal()" style="background: #f0f6f1; border: none; color: #2d6a4f; width: 30px; height: 30px; border-radius: 50%; font-size: 0.95rem; cursor: pointer;">
                ✕
            </button>
        </div>

        <div style="background: #f7faf8; border: 1px solid #dce8de; border-radius: 14px; padding: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid #edf2ed;">
                <span style="font-size: 0.8rem; color: #5a7061; font-weight: 600;">Academic Enrollment Fee</span>
                <span style="font-size: 1.4rem; font-weight: 800; color: #1c4b32;"><?= htmlspecialchars($coursePrice) ?></span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.78rem; color: #375943; font-weight: 600;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="color: #2d6a4f; font-weight: 800;">✓</span>
                    <span>All 4 Curriculum Modules & Interactive Study Materials</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="color: #2d6a4f; font-weight: 800;">✓</span>
                    <span>Full Access to Linux Virtual Terminals & Cloud Sandboxes</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="color: #2d6a4f; font-weight: 800;">✓</span>
                    <span>Verified Academic Certificate upon 100% Completion</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="color: #2d6a4f; font-weight: 800;">✓</span>
                    <span>Direct Project Grading by Prof. Robert Miller</span>
                </div>
            </div>
        </div>

        <form action="/student/courses/buy" method="POST" style="margin: 0;">
            <input type="hidden" name="code" value="<?= htmlspecialchars($activeSubject['code']) ?>">
            <button type="submit" style="width: 100%; background: #1c4b32; color: #ffffff; border: none; padding: 13px; border-radius: 12px; font-size: 0.92rem; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(28, 75, 50, 0.25); display: flex; align-items: center; justify-content: center; gap: 8px; font-family: inherit; transition: background 0.15s;" onmouseover="this.style.background='#133724'" onmouseout="this.style.background='#1c4b32'">
                <span>Confirm Enrollment & Instant Unlock &rarr;</span>
            </button>
        </form>

        <p style="font-size: 0.72rem; color: #7a8d80; text-align: center; margin: 0;">
            Billing applied to student ledger (Roll: <?= htmlspecialchars($student['roll_no'] ?? 'COMP-2026-001') ?>). Instant access granted upon confirmation.
        </p>

    </div>

</div>

<!-- Client-side Course & Learning State -->
<script>
    var currentModules = <?= json_encode($modules, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    var activeCourseCode = <?= json_encode($selectedTrack) ?>;
    var activeModIndex = 0;
    var activeLessonIndex = 0;

    // Filter track pills between Enrolled vs All Catalog
    function filterTrackPills(filter) {
        var btnEnrolled = document.getElementById('filter-btn-enrolled');
        var btnAll = document.getElementById('filter-btn-all');
        var catalogItems = document.querySelectorAll('.track-pill-item.is-catalog');

        if (filter === 'enrolled') {
            btnEnrolled.style.background = '#ffffff';
            btnEnrolled.style.color = '#1c4b32';
            btnEnrolled.style.fontWeight = '700';
            btnEnrolled.style.boxShadow = '0 1px 2px rgba(0,0,0,0.06)';

            btnAll.style.background = 'transparent';
            btnAll.style.color = '#5a7061';
            btnAll.style.fontWeight = '600';
            btnAll.style.boxShadow = 'none';

            catalogItems.forEach(function(el) {
                el.style.display = 'none';
            });
        } else {
            btnAll.style.background = '#ffffff';
            btnAll.style.color = '#1c4b32';
            btnAll.style.fontWeight = '700';
            btnAll.style.boxShadow = '0 1px 2px rgba(0,0,0,0.06)';

            btnEnrolled.style.background = 'transparent';
            btnEnrolled.style.color = '#5a7061';
            btnEnrolled.style.fontWeight = '600';
            btnEnrolled.style.boxShadow = 'none';

            catalogItems.forEach(function(el) {
                el.style.display = 'inline-flex';
            });
        }
    }

    // Learning Modal Handlers
    function openLearningModal(modIdx) {
        activeModIndex = modIdx;
        activeLessonIndex = 0;
        var mod = currentModules[modIdx];
        if (!mod) return;

        document.getElementById('modal-track-badge').innerText = activeCourseCode;
        document.getElementById('modal-module-title').innerText = mod.title;
        document.getElementById('modal-module-progress').innerText = (mod.progress || 0) + '% Completed';

        renderLessonIndex();
        renderActiveLesson();

        var modal = document.getElementById('learningModal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeLearningModal() {
        var modal = document.getElementById('learningModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function renderLessonIndex() {
        var listContainer = document.getElementById('modal-lessons-list');
        listContainer.innerHTML = '';
        var mod = currentModules[activeModIndex];
        if (!mod || !mod.lessons) return;

        mod.lessons.forEach(function(lesson, idx) {
            var isCur = (idx === activeLessonIndex);
            var isDone = (lesson.status === 'completed');

            var item = document.createElement('div');
            item.onclick = function() {
                activeLessonIndex = idx;
                renderLessonIndex();
                renderActiveLesson();
            };
            item.style.padding = '10px 12px';
            item.style.borderRadius = '10px';
            item.style.cursor = 'pointer';
            item.style.transition = 'all 0.15s ease';
            item.style.display = 'flex';
            item.style.alignItems = 'center';
            item.style.gap = '8px';
            item.style.fontSize = '0.78rem';
            item.style.fontWeight = isCur ? '700' : '600';
            item.style.border = isCur ? '1px solid #2d6a4f' : '1px solid #e2ede5';
            item.style.background = isCur ? '#ffffff' : '#f7faf8';
            item.style.color = isCur ? '#143722' : '#3d5646';

            var icon = isDone ? '✓' : (idx + 1);
            var iconBg = isDone ? '#2d6a4f' : (isCur ? '#e2ede5' : '#eef3ef');
            var iconColor = isDone ? '#ffffff' : '#1c4b32';

            item.innerHTML = '<span style="width: 22px; height: 22px; border-radius: 50%; background: ' + iconBg + '; color: ' + iconColor + '; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 800; flex-shrink: 0;">' + icon + '</span>' +
                             '<div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' +
                                 '<span style="opacity: 0.75; font-size: 0.7rem;">' + (lesson.code || '') + '</span> ' +
                                 (lesson.title || '') +
                             '</div>';

            listContainer.appendChild(item);
        });
    }

    function renderActiveLesson() {
        var mod = currentModules[activeModIndex];
        if (!mod || !mod.lessons) return;
        var lesson = mod.lessons[activeLessonIndex];
        if (!lesson) return;

        document.getElementById('active-lesson-code').innerText = 'LESSON ' + (lesson.code || (activeLessonIndex + 1));
        document.getElementById('active-lesson-duration').innerText = lesson.duration || '25 mins';
        document.getElementById('active-lesson-title').innerText = lesson.title || 'Technical Lesson';
        document.getElementById('active-lesson-summary').innerText = lesson.summary || 'Study notes...';

        var keyPointsEl = document.getElementById('active-lesson-keypoints');
        keyPointsEl.innerHTML = '';
        (lesson.key_points || []).forEach(function(kp) {
            var li = document.createElement('li');
            li.innerText = kp;
            keyPointsEl.appendChild(li);
        });

        document.getElementById('active-lesson-commands').innerText = lesson.commands || '# No terminal commands needed for this theoretical overview.';
        document.getElementById('active-lesson-lab').innerText = lesson.lab_instructions || 'Complete the quiz review in your student workbook.';

        // Complete button status
        var btnToggle = document.getElementById('btn-toggle-complete');
        var btnText = document.getElementById('complete-btn-text');
        var checkIcon = document.getElementById('complete-check-icon');

        if (lesson.status === 'completed') {
            btnToggle.style.background = '#e8f5e9';
            btnToggle.style.color = '#1e4620';
            btnToggle.style.borderColor = '#a8dab5';
            btnText.innerText = 'Completed ✓';
            checkIcon.innerText = '✓';
        } else {
            btnToggle.style.background = '#f0f6f1';
            btnToggle.style.color = '#2d6a4f';
            btnToggle.style.borderColor = '#cfe0d2';
            btnText.innerText = 'Mark Lesson Completed';
            checkIcon.innerText = '○';
        }
    }

    function toggleLessonCompletion() {
        var mod = currentModules[activeModIndex];
        if (!mod || !mod.lessons) return;
        var lesson = mod.lessons[activeLessonIndex];
        if (!lesson) return;

        if (lesson.status === 'completed') {
            lesson.status = 'in_progress';
        } else {
            lesson.status = 'completed';
        }

        renderLessonIndex();
        renderActiveLesson();
    }

    function nextLesson() {
        var mod = currentModules[activeModIndex];
        if (!mod || !mod.lessons) return;
        if (activeLessonIndex < mod.lessons.length - 1) {
            activeLessonIndex++;
            renderLessonIndex();
            renderActiveLesson();
        } else {
            alert('You have reached the end of Module ' + mod.number + '!');
        }
    }

    function copyCommand() {
        var text = document.getElementById('active-lesson-commands').innerText;
        navigator.clipboard.writeText(text).then(function() {
            var copyBtn = document.getElementById('copy-btn');
            copyBtn.innerText = 'Copied!';
            setTimeout(function() { copyBtn.innerText = 'Copy Syntax'; }, 2000);
        });
    }

    // Purchase Modal Handlers
    function openPurchaseModal() {
        var modal = document.getElementById('purchaseModal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePurchaseModal() {
        var modal = document.getElementById('purchaseModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Keyboard & click outside listener
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLearningModal();
            closePurchaseModal();
        }
    });
</script>

<style>
    @keyframes modalPop {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
