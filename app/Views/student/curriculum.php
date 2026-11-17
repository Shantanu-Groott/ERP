<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Track Selector Pills (Allows seamless browsing across all enrolled cybersecurity & tech courses) -->
    <?php if (!empty($subjects)): ?>
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; background: #ffffff; padding: 12px 18px; border-radius: 16px; border: 1px solid var(--border-sage); box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #627467; margin-right: 6px;">
                    Tracks:
                </span>
                <?php foreach ($subjects as $s): ?>
                    <?php $isActive = ($s['code'] === ($selectedTrack ?? 'CYB302')); ?>
                    <a href="/student/curriculum?track=<?= urlencode($s['code']) ?>" 
                       style="padding: 6px 14px; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; text-decoration: none; transition: all 0.15s ease; display: inline-flex; align-items: center; gap: 6px; <?= $isActive ? 'background: #285f43; color: #ffffff; box-shadow: 0 2px 6px rgba(40,95,67,0.25);' : 'background: #eef3ee; color: #2e4a36;' ?>">
                        <span><?= htmlspecialchars($s['code']) ?></span>
                        <span style="font-weight: 500; font-size: 0.75rem; opacity: 0.9;"><?= htmlspecialchars($s['name']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.78rem; font-weight: 600; color: #4b6352;">
                <span><?= htmlspecialchars($student['class_name'] ?? 'TE Computer') ?></span>
                <span>•</span>
                <span>Roll: <?= htmlspecialchars($student['roll_no'] ?? 'COMP-2026-001') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- 2x2 Curriculum Module Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(440px, 1fr)); gap: 24px;">
        <?php foreach ($modules as $mod): ?>
            <?php
                $pct = (int)($mod['progress'] ?? 0);
                // SVG circular progress parameters
                $radius = 21;
                $circumference = 2 * M_PI * $radius; // ~131.95
                $dashoffset = $circumference - ($circumference * ($pct / 100));
            ?>
            <div style="background: #ffffff; border: 1px solid #d5e0d5; border-radius: 20px; padding: 24px 26px; box-shadow: 0 2px 8px rgba(33, 75, 52, 0.04); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.15s ease, box-shadow 0.15s ease;">
                
                <!-- Card Header: Title & Circular Donut Progress Gauge -->
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px;">
                    <h3 style="font-size: 1.14rem; font-weight: 700; color: #163622; line-height: 1.35; margin: 0;">
                        <?= htmlspecialchars($mod['title']) ?>
                    </h3>

                    <!-- Circular Progress Gauge Badge -->
                    <div style="position: relative; width: 54px; height: 54px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                        <svg width="54" height="54" viewBox="0 0 54 54" style="transform: rotate(-90deg);">
                            <!-- Track Background -->
                            <circle cx="27" cy="27" r="<?= $radius ?>" stroke="#dbe7dc" stroke-width="4.5" fill="none" />
                            <!-- Progress Stroke -->
                            <circle cx="27" cy="27" r="<?= $radius ?>" 
                                    stroke="#245a3e" 
                                    stroke-width="4.5" 
                                    stroke-linecap="round" 
                                    fill="none" 
                                    stroke-dasharray="<?= round($circumference, 2) ?>" 
                                    stroke-dashoffset="<?= round($dashoffset, 2) ?>" 
                                    style="transition: stroke-dashoffset 0.6s ease;" />
                        </svg>
                        <span style="position: absolute; font-size: 0.82rem; font-weight: 800; color: #163622; font-family: 'Plus Jakarta Sans', sans-serif;">
                            <?= $pct ?>%
                        </span>
                    </div>
                </div>

                <!-- Card Body: Left Graphic Illustration & Right Checklist -->
                <div style="display: flex; align-items: flex-start; gap: 20px; flex: 1;">
                    
                    <!-- Left Graphic Illustration -->
                    <div style="width: 135px; height: 130px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border-radius: 12px; background: #f8faf8;">
                        <img src="<?= htmlspecialchars($mod['image']) ?>" 
                             alt="<?= htmlspecialchars($mod['title']) ?>" 
                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>

                    <!-- Right Lessons Checklist -->
                    <div style="display: flex; flex-direction: column; gap: 12px; flex: 1; min-width: 0;">
                        <?php foreach (($mod['lessons'] ?? []) as $lesson): ?>
                            <?php 
                                $status = $lesson['status'] ?? 'not_started'; 
                                $isDone = ($status === 'completed');
                                $isInProgress = ($status === 'in_progress');
                            ?>
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; font-size: 0.83rem; font-weight: 600; color: #1e3526;">
                                
                                <!-- Icon & Lesson Name -->
                                <div style="display: flex; align-items: center; gap: 9px; min-width: 0;">
                                    <?php if ($isDone): ?>
                                        <span style="width: 17px; height: 17px; border-radius: 50%; background: #347a57; display: inline-flex; align-items: center; justify-content: center; color: #ffffff; flex-shrink: 0;">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </span>
                                    <?php elseif ($isInProgress): ?>
                                        <span style="width: 16px; height: 16px; border: 1.5px dashed #347a57; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; background: #eef6f0;">
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
                                <div style="flex-shrink: 0; font-size: 0.76rem;">
                                    <?php if ($isDone): ?>
                                        <span style="color: #347a57; display: inline-flex; align-items: center;">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </span>
                                    <?php elseif ($isInProgress): ?>
                                        <span style="color: #40916c; font-weight: 700;">In Progress</span>
                                    <?php else: ?>
                                        <span style="color: #7b9181; font-weight: 600;">Not Started</span>
                                    <?php endif; ?>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>

                <!-- Card Bottom Row: Action Button -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px; padding-top: 14px; border-top: 1px solid #edf3ed;">
                    <?php if (!empty($mod['action_label'])): ?>
                        <a href="<?= htmlspecialchars($mod['action_url'] ?? '#') ?>" 
                           style="background: #153e28; color: #ffffff; padding: 7px 22px; border-radius: 8px; font-size: 0.83rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(21, 62, 40, 0.2); transition: all 0.15s ease;">
                            <?= htmlspecialchars($mod['action_label']) ?>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</div>
