<?php
/**
 * Kalavanta Edutech - Student Profile Page
 * Implements:
 *  - Top Profile Information Card matching mockup (media_1794916047833_867cfccf.jpg)
 *  - Edit Profile modal with update functionality
 *  - Academic Credentials & Metrics
 *  - GitHub-style Activity Contribution Calendar
 *  - Certified Achievement Badges Grid
 */
$avatarLetter = strtoupper(substr((string)$fullName, 0, 1));
?>
<div class="student-profile-page" style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Optional Success Toast -->
    <?php if (!empty($_GET['updated'])): ?>
        <div style="background: #e6f4ea; border: 1px solid #a8dab5; border-radius: 16px; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 14px; box-shadow: 0 2px 8px rgba(28, 75, 50, 0.08);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="width: 28px; height: 28px; border-radius: 50%; background: #2d6a4f; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.88rem;">✓</span>
                <div>
                    <h4 style="font-size: 0.9rem; font-weight: 700; color: #153e28; margin: 0 0 2px 0;">Profile Updated Successfully</h4>
                    <p style="font-size: 0.78rem; color: #375943; margin: 0;">Your student profile details and public credentials have been saved.</p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" style="background: transparent; border: none; font-size: 1.1rem; color: #2d6a4f; cursor: pointer;">✕</button>
        </div>
    <?php endif; ?>

    <!-- ==================================================== -->
    <!-- 1. TOP PROFILE INFORMATION CARD (Exact Match to Mockup) -->
    <!-- ==================================================== -->
    <div class="profile-card" style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 26px 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        
        <!-- Card Title -->
        <h3 style="font-size: 1.05rem; font-weight: 700; color: #183324; margin: 0 0 18px 0;">
            Profile Information
        </h3>

        <!-- Upper Row: Avatar + Name/Email + Edit Profile Pill -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            
            <!-- Left: Avatar Circle + Full Name + Email -->
            <div style="display: flex; align-items: center; gap: 16px;">
                <!-- Avatar with letter S in deep green -->
                <div style="width: 52px; height: 52px; min-width: 52px; border-radius: 50%; background: #2d6a4f; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; font-weight: 700; border: 2px solid #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <?= htmlspecialchars($avatarLetter) ?>
                </div>

                <div>
                    <h2 class="font-serif" style="font-size: 1.15rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.2;">
                        <?= htmlspecialchars($fullName) ?>
                    </h2>
                    <p style="font-size: 0.84rem; color: #627467; margin: 3px 0 0 0; font-weight: 500;">
                        <?= htmlspecialchars($email) ?>
                    </p>
                </div>
            </div>

            <!-- Right: Edit Profile Pill Button -->
            <button type="button" onclick="openEditProfileModal()" 
                    style="background: #d8ecd9; color: #1c4b32; font-weight: 600; font-size: 0.82rem; padding: 8px 20px; border-radius: 999px; border: 1px solid #c2e0c5; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; transition: all 0.15s ease; font-family: inherit;">
                <span>Edit Profile</span>
                <span style="font-size: 0.95rem;">&rarr;</span>
            </button>

        </div>

        <!-- Hairline Divider -->
        <hr style="margin: 22px 0 20px 0; border: none; border-top: 1px solid #edf2ed;">

        <!-- Lower Grid: Student ID, Track/Stream Enrolled, Roll Number, etc. -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px 24px;">
            
            <!-- Student ID (Mockup exact field) -->
            <div>
                <span style="font-size: 0.78rem; font-weight: 500; color: #718576; display: block; margin-bottom: 3px;">
                    Student ID
                </span>
                <span style="font-size: 0.96rem; font-weight: 700; color: #183324;">
                    <?= htmlspecialchars($studentId) ?>
                </span>
            </div>

            <!-- Track Enrolled (Mockup exact field) -->
            <div>
                <span style="font-size: 0.78rem; font-weight: 500; color: #718576; display: block; margin-bottom: 3px;">
                    Track Enrolled
                </span>
                <span style="font-size: 0.96rem; font-weight: 700; color: #183324;">
                    <?= htmlspecialchars($trackEnrolled) ?>
                </span>
            </div>

            <!-- Roll Number -->
            <div>
                <span style="font-size: 0.78rem; font-weight: 500; color: #718576; display: block; margin-bottom: 3px;">
                    Roll Number
                </span>
                <span style="font-size: 0.96rem; font-weight: 700; color: #183324;">
                    <?= htmlspecialchars($rollNo) ?>
                </span>
            </div>

            <!-- Class & Division -->
            <div>
                <span style="font-size: 0.78rem; font-weight: 500; color: #718576; display: block; margin-bottom: 3px;">
                    Class & Division
                </span>
                <span style="font-size: 0.96rem; font-weight: 700; color: #183324;">
                    <?= htmlspecialchars($className) ?> • Div <?= htmlspecialchars($division) ?>
                </span>
            </div>

            <!-- Department / Stream -->
            <div>
                <span style="font-size: 0.78rem; font-weight: 500; color: #718576; display: block; margin-bottom: 3px;">
                    Academic Stream
                </span>
                <span style="font-size: 0.96rem; font-weight: 700; color: #183324;">
                    <?= htmlspecialchars($departmentName) ?>
                </span>
            </div>

            <!-- Academic Year -->
            <div>
                <span style="font-size: 0.78rem; font-weight: 500; color: #718576; display: block; margin-bottom: 3px;">
                    Academic Year
                </span>
                <span style="font-size: 0.96rem; font-weight: 700; color: #183324;">
                    2026-27 (Semester V)
                </span>
            </div>

            <!-- Contact Phone -->
            <div>
                <span style="font-size: 0.78rem; font-weight: 500; color: #718576; display: block; margin-bottom: 3px;">
                    Phone Number
                </span>
                <span style="font-size: 0.96rem; font-weight: 700; color: #183324;">
                    <?= htmlspecialchars($phone) ?>
                </span>
            </div>

            <!-- Academic Standing -->
            <div>
                <span style="font-size: 0.78rem; font-weight: 500; color: #718576; display: block; margin-bottom: 3px;">
                    Academic Standing
                </span>
                <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 700; color: #2e7d32; background: #e8f5e9; padding: 3px 10px; border-radius: 999px;">
                    <span>●</span> Active • Good Standing
                </span>
            </div>

        </div>

        <!-- Student Bio Statement & External Portfolios -->
        <div style="margin-top: 22px; padding-top: 18px; border-top: 1px solid #edf2ed; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
            <div style="flex: 1; min-width: 260px;">
                <span style="font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #718576; display: block; margin-bottom: 4px;">
                    Personal Statement
                </span>
                <p style="font-size: 0.84rem; color: #3b5343; margin: 0; line-height: 1.5;">
                    <?= htmlspecialchars($bio) ?>
                </p>
            </div>

            <!-- Social Links / Repositories -->
            <div style="display: flex; align-items: center; gap: 10px;">
                <?php if (!empty($githubUrl)): ?>
                    <a href="<?= htmlspecialchars($githubUrl) ?>" target="_blank" rel="noopener noreferrer" 
                       style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 999px; background: #f3f7f4; border: 1px solid #d8e5da; color: #1c4b32; font-size: 0.78rem; font-weight: 600; text-decoration: none; transition: background 0.15s ease;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                        </svg>
                        <span>GitHub</span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($linkedinUrl)): ?>
                    <a href="<?= htmlspecialchars($linkedinUrl) ?>" target="_blank" rel="noopener noreferrer" 
                       style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 999px; background: #f3f7f4; border: 1px solid #d8e5da; color: #1c4b32; font-size: 0.78rem; font-weight: 600; text-decoration: none; transition: background 0.15s ease;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                        <span>LinkedIn</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- ==================================================== -->
    <!-- 2. ACADEMIC QUICK STATS ROW -->
    <!-- ==================================================== -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 18px;">
        
        <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 16px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #eaf1eb; display: flex; align-items: center; justify-content: center; color: #1c4b32; flex-shrink: 0;">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <span style="font-size: 1.45rem; font-weight: 800; color: #183324; line-height: 1.1; display: block;">
                    <?= htmlspecialchars($stats['cgpa']) ?>
                </span>
                <span style="font-size: 0.78rem; font-weight: 500; color: #627467;">Cumulative CGPA</span>
            </div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 16px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #eaf1eb; display: flex; align-items: center; justify-content: center; color: #1c4b32; flex-shrink: 0;">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <span style="font-size: 1.45rem; font-weight: 800; color: #183324; line-height: 1.1; display: block;">
                    <?= htmlspecialchars($stats['attendance_rate']) ?>
                </span>
                <span style="font-size: 0.78rem; font-weight: 500; color: #627467;">Class Attendance</span>
            </div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 16px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #eaf1eb; display: flex; align-items: center; justify-content: center; color: #1c4b32; flex-shrink: 0;">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <div>
                <span style="font-size: 1.45rem; font-weight: 800; color: #183324; line-height: 1.1; display: block;">
                    <?= htmlspecialchars($stats['completed_labs']) ?> Labs
                </span>
                <span style="font-size: 0.78rem; font-weight: 500; color: #627467;">Completed Exercises</span>
            </div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 16px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #eaf1eb; display: flex; align-items: center; justify-content: center; color: #1c4b32; flex-shrink: 0;">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <span style="font-size: 1.45rem; font-weight: 800; color: #183324; line-height: 1.1; display: block;">
                    <?= htmlspecialchars($stats['study_hours']) ?> hrs
                </span>
                <span style="font-size: 0.78rem; font-weight: 500; color: #627467;">Terminal Practicals</span>
            </div>
        </div>

    </div>

    <!-- ==================================================== -->
    <!-- 3. GITHUB-STYLE LEARNING ACTIVITY CALENDAR -->
    <!-- ==================================================== -->
    <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 24px 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 18px;">
            <div>
                <h3 style="font-size: 1.05rem; font-weight: 700; color: #183324; margin: 0 0 3px 0;">
                    Learning & Practical Lab Activity
                </h3>
                <p style="font-size: 0.8rem; color: #627467; margin: 0;">
                    <?= htmlspecialchars($stats['total_contributions']) ?> contributions & sandbox sessions across the past 52 weeks
                </p>
            </div>

            <!-- Streak summary pills -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 0.76rem; font-weight: 700; color: #1c4b32; background: #eaf1eb; border: 1px solid #d4e2d6; padding: 4px 12px; border-radius: 999px;">
                    🔥 Current Streak: <?= htmlspecialchars($stats['current_streak']) ?> Days
                </span>
                <span style="font-size: 0.76rem; font-weight: 600; color: #4b6352; background: #f8faf8; border: 1px solid #e2ece4; padding: 4px 12px; border-radius: 999px;">
                    🏆 Longest Streak: <?= htmlspecialchars($stats['longest_streak']) ?> Days
                </span>
            </div>
        </div>

        <!-- Heatmap Container (Horizontal Scroll on Mobile) -->
        <div style="overflow-x: auto; padding-bottom: 10px; scrollbar-width: thin;">
            <div style="min-width: 760px; display: flex; flex-direction: column; gap: 6px;">
                
                <!-- Month Labels Across Top -->
                <div style="display: flex; margin-left: 32px; font-size: 0.72rem; color: #718576; font-weight: 600; height: 18px; position: relative;">
                    <?php 
                        $months = $activityData['months'] ?? [];
                        foreach ($months as $weekIdx => $monthName): 
                            $leftOffset = $weekIdx * 14.5;
                    ?>
                        <span style="position: absolute; left: <?= $leftOffset ?>px;">
                            <?= htmlspecialchars($monthName) ?>
                        </span>
                    <?php endforeach; ?>
                </div>

                <!-- Main Heatmap Grid: Day labels + 52 Week Columns -->
                <div style="display: flex; align-items: flex-start; gap: 6px;">
                    
                    <!-- Weekday labels on the left (Mon, Wed, Fri) -->
                    <div style="display: flex; flex-direction: column; gap: 4px; font-size: 0.65rem; color: #718576; font-weight: 600; padding-top: 13px; width: 24px; text-align: right; flex-shrink: 0;">
                        <span style="height: 11px; line-height: 11px;">Mon</span>
                        <span style="height: 11px; line-height: 11px; margin-top: 11px;">Wed</span>
                        <span style="height: 11px; line-height: 11px; margin-top: 11px;">Fri</span>
                    </div>

                    <!-- 52 Columns of 7 Squares -->
                    <div style="display: flex; gap: 3.5px; flex: 1;">
                        <?php 
                            $weeks = $activityData['weeks'] ?? [];
                            // Color mapping: Level 0 to 4 matching Kalavanta palette
                            $levelColors = [
                                0 => '#ebedf0',
                                1 => '#a8dab5',
                                2 => '#52b788',
                                3 => '#2d6a4f',
                                4 => '#143724',
                            ];
                            foreach ($weeks as $w): 
                        ?>
                            <div style="display: flex; flex-direction: column; gap: 3.5px;">
                                <?php foreach ($w as $day): 
                                    $c = $levelColors[$day['level']] ?? '#ebedf0';
                                    $tooltipText = $day['count'] > 0 
                                        ? "{$day['count']} practical tasks on {$day['display_date']}"
                                        : "No activity on {$day['display_date']}";
                                ?>
                                    <div class="calendar-cell"
                                         data-tooltip="<?= htmlspecialchars($tooltipText) ?>"
                                         style="width: 11px; height: 11px; border-radius: 2.5px; background: <?= $c ?>; cursor: pointer; transition: transform 0.1s ease;">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>
        </div>

        <!-- Legend Bar -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px; padding-top: 12px; border-top: 1px solid #edf2ed; font-size: 0.74rem; color: #627467;">
            <span>Learn how we calculate lab contributions</span>
            <div style="display: flex; align-items: center; gap: 5px;">
                <span>Less</span>
                <span style="width: 10px; height: 10px; border-radius: 2px; background: #ebedf0; display: inline-block;"></span>
                <span style="width: 10px; height: 10px; border-radius: 2px; background: #a8dab5; display: inline-block;"></span>
                <span style="width: 10px; height: 10px; border-radius: 2px; background: #52b788; display: inline-block;"></span>
                <span style="width: 10px; height: 10px; border-radius: 2px; background: #2d6a4f; display: inline-block;"></span>
                <span style="width: 10px; height: 10px; border-radius: 2px; background: #143724; display: inline-block;"></span>
                <span>More</span>
            </div>
        </div>

    </div>

    <!-- ==================================================== -->
    <!-- 4. CERTIFIED ACHIEVEMENT BADGES SECTION -->
    <!-- ==================================================== -->
    <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 24px 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        
        <div style="margin-bottom: 20px;">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: #183324; margin: 0 0 3px 0;">
                Certified Achievement Badges
            </h3>
            <p style="font-size: 0.8rem; color: #627467; margin: 0;">
                Milestone credentials and validated skill competencies earned during academic cohort
            </p>
        </div>

        <!-- Badges Grid: 6 Distinct Technical & Academic Badges -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 16px;">
            <?php foreach ($badges as $b): ?>
                <div class="achievement-badge-card" style="border: 1px solid #e2ece4; border-radius: 18px; padding: 18px 20px; background: #fbfdfb; display: flex; flex-direction: column; justify-content: space-between; gap: 14px; transition: transform 0.15s ease, box-shadow 0.15s ease;">
                    
                    <div style="display: flex; align-items: flex-start; gap: 14px;">
                        
                        <!-- Badge Icon Emblem -->
                        <div style="width: 48px; height: 48px; min-width: 48px; border-radius: 14px; background: <?= htmlspecialchars($b['badge_bg']) ?>; color: <?= htmlspecialchars($b['badge_color']) ?>; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                            <?php if ($b['icon'] === 'shield'): ?>
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                                </svg>
                            <?php elseif ($b['icon'] === 'hacker'): ?>
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            <?php elseif ($b['icon'] === 'key'): ?>
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="7.5" cy="15.5" r="4.5"/>
                                    <path d="M10.7 12.3L19 4"/>
                                    <path d="M15 4l4 4"/>
                                </svg>
                            <?php elseif ($b['icon'] === 'target'): ?>
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <circle cx="12" cy="12" r="6"/>
                                    <circle cx="12" cy="12" r="2"/>
                                </svg>
                            <?php elseif ($b['icon'] === 'trophy'): ?>
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            <?php else: ?>
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                </svg>
                            <?php endif; ?>
                        </div>

                        <!-- Badge Information -->
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 2px;">
                                <h4 style="font-size: 0.95rem; font-weight: 700; color: #183324; margin: 0;">
                                    <?= htmlspecialchars($b['title']) ?>
                                </h4>
                            </div>
                            <span style="font-size: 0.7rem; font-weight: 700; color: <?= htmlspecialchars($b['badge_color']) ?>; text-transform: uppercase; letter-spacing: 0.5px;">
                                <?= htmlspecialchars($b['category']) ?>
                            </span>
                            <p style="font-size: 0.78rem; color: #4b6352; margin: 6px 0 0 0; line-height: 1.4;">
                                <?= htmlspecialchars($b['description']) ?>
                            </p>
                        </div>

                    </div>

                    <!-- Footer: Date Earned & Verified Status -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 1px solid #edf2ed; font-size: 0.72rem;">
                        <span style="color: #627467; font-weight: 600;">
                            <?= htmlspecialchars($b['earned_date']) ?>
                        </span>
                        <span style="font-weight: 700; color: #2e7d32; display: inline-flex; align-items: center; gap: 4px;">
                            <span>✓</span> <?= htmlspecialchars($b['status']) ?>
                        </span>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>

</div>

<!-- ==================================================== -->
<!-- EDIT PROFILE MODAL -->
<!-- ==================================================== -->
<div id="editProfileModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(18, 38, 26, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    
    <div style="background: #ffffff; border-radius: 24px; width: 100%; max-width: 540px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2); animation: modalFadeIn 0.2s ease-out;">
        
        <div style="background: #1c4b32; color: #ffffff; padding: 20px 24px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 1.15rem; font-weight: 700; margin: 0; line-height: 1.2;">Edit Student Profile</h3>
                <p style="font-size: 0.78rem; color: #c4decb; margin: 3px 0 0 0;">Update your public contact info, bio, and social links</p>
            </div>
            <button onclick="closeEditProfileModal()" style="background: rgba(255,255,255,0.15); border: none; color: #ffffff; width: 32px; height: 32px; border-radius: 50%; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                ✕
            </button>
        </div>

        <form action="/student/profile/update" method="POST" style="padding: 24px; display: flex; flex-direction: column; gap: 16px; margin: 0;">
            <?= \App\Core\Csrf::field() ?>

            <!-- Full Name -->
            <div>
                <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #3b5343; margin-bottom: 5px;">
                    Full Name
                </label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($fullName) ?>" required
                       style="width: 100%; padding: 10px 14px; border: 1px solid #d4e2d6; border-radius: 10px; font-size: 0.88rem; font-family: inherit; color: #183324; box-sizing: border-box;">
            </div>

            <!-- Email Address -->
            <div>
                <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #3b5343; margin-bottom: 5px;">
                    Email Address
                </label>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required
                       style="width: 100%; padding: 10px 14px; border: 1px solid #d4e2d6; border-radius: 10px; font-size: 0.88rem; font-family: inherit; color: #183324; box-sizing: border-box;">
            </div>

            <!-- Phone Number -->
            <div>
                <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #3b5343; margin-bottom: 5px;">
                    Phone Number
                </label>
                <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>"
                       style="width: 100%; padding: 10px 14px; border: 1px solid #d4e2d6; border-radius: 10px; font-size: 0.88rem; font-family: inherit; color: #183324; box-sizing: border-box;">
            </div>

            <!-- Bio Statement -->
            <div>
                <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #3b5343; margin-bottom: 5px;">
                    Personal Bio / Learning Goals
                </label>
                <textarea name="bio" rows="3" style="width: 100%; padding: 10px 14px; border: 1px solid #d4e2d6; border-radius: 10px; font-size: 0.84rem; font-family: inherit; color: #183324; box-sizing: border-box; resize: vertical; line-height: 1.4;"><?= htmlspecialchars($bio) ?></textarea>
            </div>

            <!-- GitHub & LinkedIn Links -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #3b5343; margin-bottom: 5px;">
                        GitHub Profile
                    </label>
                    <input type="url" name="github_url" value="<?= htmlspecialchars($githubUrl) ?>" placeholder="https://github.com/..."
                           style="width: 100%; padding: 10px 14px; border: 1px solid #d4e2d6; border-radius: 10px; font-size: 0.84rem; font-family: inherit; color: #183324; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #3b5343; margin-bottom: 5px;">
                        LinkedIn Profile
                    </label>
                    <input type="url" name="linkedin_url" value="<?= htmlspecialchars($linkedinUrl) ?>" placeholder="https://linkedin.com/in/..."
                           style="width: 100%; padding: 10px 14px; border: 1px solid #d4e2d6; border-radius: 10px; font-size: 0.84rem; font-family: inherit; color: #183324; box-sizing: border-box;">
                </div>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="button" onclick="closeEditProfileModal()" style="flex: 1; padding: 11px; border-radius: 10px; background: #f1f4f2; color: #5a7061; border: none; font-weight: 600; font-size: 0.84rem; cursor: pointer; font-family: inherit;">
                    Cancel
                </button>
                <button type="submit" style="flex: 2; padding: 11px; border-radius: 10px; background: #1c4b32; color: #ffffff; border: none; font-weight: 700; font-size: 0.86rem; cursor: pointer; font-family: inherit; box-shadow: 0 2px 8px rgba(28,75,50,0.25);">
                    Save Changes &rarr;
                </button>
            </div>
        </form>

    </div>

</div>

<!-- Activity Tooltip & Modal Styling -->
<style>
@keyframes modalFadeIn {
    from { opacity: 0; transform: translateY(14px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.calendar-cell:hover {
    transform: scale(1.35);
    outline: 1.5px solid #1c4b32;
    z-index: 10;
}
.achievement-badge-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(28, 75, 50, 0.06);
    background: #ffffff !important;
}
/* Tooltip on Calendar Cells */
.calendar-cell {
    position: relative;
}
.calendar-cell:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 130%;
    left: 50%;
    transform: translateX(-50%);
    background: #141e17;
    color: #ffffff;
    font-size: 0.68rem;
    padding: 4px 8px;
    border-radius: 6px;
    white-space: nowrap;
    z-index: 99;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    pointer-events: none;
}
</style>

<script>
function openEditProfileModal() {
    const modal = document.getElementById('editProfileModal');
    if (modal) modal.style.display = 'flex';
}
function closeEditProfileModal() {
    const modal = document.getElementById('editProfileModal');
    if (modal) modal.style.display = 'none';
}
</script>
