<?php
/**
 * Kalavanta Edutech - Student Exam Grades & Assessment Performance
 * Matches Mockup (media_1794993422673_3a553fff.jpg):
 *  1. Top 4 Metric Cards (Overall Average, Total Exams, Highest Score, Lowest Score)
 *  2. Middle Section:
 *     - Left: Performance Trend Line Chart with 6M/1Y/All period filter pills
 *     - Right: Overall Average Donut Gauge & Grade Distribution (90-100%, 80-90%, 70-80%, <70%)
 *  3. Exam Grades Table (Date, Exam Name, Subject, Score, Grade pill, Status bullet, View Details)
 *  4. Interactive Assessment Details Modal & Report Download Action
 */

$avg = (float)($overallPercentage ?? 87.5);
$examCount = (int)($totalExams ?? count($marks));

// SVG circle radius 48, circumference = 2 * PI * 48 = 301.59
$circumference = 301.59;
$clampedAvg = min(max($avg, 0), 100);
$dashOffset = round($circumference * (1 - ($clampedAvg / 100)), 2);

$dist = $distribution ?? [
    '90_100' => 4,
    '80_90' => 3,
    '70_80' => 1,
    'under_70' => 0,
];

$high = $highestScore ?? ['score' => 98.0, 'subject' => 'Database Management'];
$low = $lowestScore ?? ['score' => 72.0, 'subject' => 'Ethical Hacking'];
?>

<div class="exam-grades-container" style="display: flex; flex-direction: column; gap: 22px;">

    <!-- ==================================================== -->
    <!-- 1. TOP 4 METRIC CARDS ROW                            -->
    <!-- ==================================================== -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px;">
        
        <!-- Card 1: Overall Average -->
        <div class="metric-card" style="background: #ffffff; border: 1px solid #d9ebd9; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #eaf5ee; color: #2d6a4f; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <!-- Trophy Icon -->
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 4h-2V3a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v1H5a3 3 0 0 0-3 3v2a5 5 0 0 0 4.1 4.9A6.002 6.002 0 0 0 11 16.9V19H9a1 1 0 0 0 0 2h6a1 1 0 0 0 0-2h-2v-2.1a6.002 6.002 0 0 0 4.9-3A5 5 0 0 0 22 9V7a3 3 0 0 0-3-3zM5 9V7h2v4.8A3.003 3.003 0 0 1 5 9zm14 0a3.003 3.003 0 0 1-2 2.8V7h2v2z"/>
                        </svg>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 600; color: #627467;">Overall Average</span>
                </div>
                <div style="font-size: 1.55rem; font-weight: 800; color: #183324; margin: 8px 0 2px 0; font-variant-numeric: tabular-nums; line-height: 1;">
                    <?= number_format($avg, 1) ?>%
                </div>
                <div style="font-size: 0.72rem; color: #2d6a4f; font-weight: 700;">
                    &uarr; +2.3% from last term
                </div>
            </div>
            <!-- Green Wave Sparkline -->
            <div style="flex-shrink: 0; padding-top: 10px;">
                <svg width="56" height="32" viewBox="0 0 56 32" fill="none">
                    <path d="M2 24C10 20 18 26 26 16C34 6 44 14 54 4" stroke="#40916c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <!-- Card 2: Total Exams -->
        <div class="metric-card" style="background: #ffffff; border: 1px solid #dde7f3; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #e8f0fe; color: #1a73e8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <!-- Checkmark Icon -->
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 600; color: #627467;">Total Exams</span>
                </div>
                <div style="font-size: 1.55rem; font-weight: 800; color: #183324; margin: 8px 0 2px 0; font-variant-numeric: tabular-nums; line-height: 1;">
                    <?= $examCount ?>
                </div>
                <div style="font-size: 0.72rem; color: #1a73e8; font-weight: 700;">
                    &uarr; 1 new
                </div>
            </div>
            <!-- Calendar Icon -->
            <div style="flex-shrink: 0; color: #b8d4f7;">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <!-- Card 3: Highest Score -->
        <div class="metric-card" style="background: #ffffff; border: 1px solid #fce8d5; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #fef0e6; color: #ea580c; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <!-- Target/Bullseye Icon -->
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <circle cx="12" cy="12" r="9" />
                            <circle cx="12" cy="12" r="5" />
                            <circle cx="12" cy="12" r="1" fill="currentColor" />
                        </svg>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 600; color: #627467;">Highest Score</span>
                </div>
                <div style="font-size: 1.55rem; font-weight: 800; color: #183324; margin: 8px 0 2px 0; font-variant-numeric: tabular-nums; line-height: 1;">
                    <?= number_format($high['score'], 1) ?>%
                </div>
                <div style="font-size: 0.72rem; color: #718576; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px;">
                    in <?= htmlspecialchars($high['subject']) ?>
                </div>
            </div>
            <!-- Star Icon -->
            <div style="flex-shrink: 0; color: #fbd0a8;">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
        </div>

        <!-- Card 4: Lowest Score -->
        <div class="metric-card" style="background: #ffffff; border: 1px solid #eeddfa; border-radius: 18px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; gap: 14px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #f5ebfc; color: #9333ea; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <!-- Chart Bar Icon -->
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span style="font-size: 0.78rem; font-weight: 600; color: #627467;">Lowest Score</span>
                </div>
                <div style="font-size: 1.55rem; font-weight: 800; color: #183324; margin: 8px 0 2px 0; font-variant-numeric: tabular-nums; line-height: 1;">
                    <?= number_format($low['score'], 1) ?>%
                </div>
                <div style="font-size: 0.72rem; color: #718576; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px;">
                    in <?= htmlspecialchars($low['subject']) ?>
                </div>
            </div>
            <!-- Trend Down Icon -->
            <div style="flex-shrink: 0; color: #dfbcf7;">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                </svg>
            </div>
        </div>

    </div>

    <!-- ==================================================== -->
    <!-- 2. MIDDLE SECTION: PERFORMANCE TREND + GRADE DONUT   -->
    <!-- ==================================================== -->
    <div style="display: grid; grid-template-columns: minmax(460px, 1.8fr) minmax(320px, 1.2fr); gap: 20px; align-items: stretch;" class="trend-donut-grid">
        
        <!-- Left: Performance Trend Card -->
        <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 22px 26px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
            
            <!-- Trend Header: Title & Period Filter Pills -->
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 18px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#2d6a4f" stroke-width="2.3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <h3 style="font-size: 0.98rem; font-weight: 700; color: #183324; margin: 0;">Performance Trend</h3>
                </div>

                <div class="period-pills-group" style="display: flex; gap: 4px; background: #f3f7f4; padding: 3px; border-radius: 999px; border: 1px solid #e0ece2;">
                    <button type="button" class="trend-pill-btn active" data-period="6m" onclick="switchTrendPeriod('6m', this)">Last 6 Months</button>
                    <button type="button" class="trend-pill-btn" data-period="1y" onclick="switchTrendPeriod('1y', this)">1 Year</button>
                    <button type="button" class="trend-pill-btn" data-period="all" onclick="switchTrendPeriod('all', this)">All Time</button>
                </div>
            </div>

            <!-- SVG Smooth Trend Spline Chart -->
            <div id="trend-chart-container" style="width: 100%; position: relative; overflow: hidden;">
                <svg viewBox="0 0 620 220" style="width: 100%; height: auto; display: block;" id="trendSvg">
                    <defs>
                        <!-- Translucent soft green area gradient -->
                        <linearGradient id="trendGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#2d6a4f" stop-opacity="0.16"/>
                            <stop offset="100%" stop-color="#2d6a4f" stop-opacity="0.01"/>
                        </linearGradient>
                    </defs>

                    <!-- Y-Axis Grid Lines & Labels -->
                    <!-- 100% -->
                    <text x="0" y="24" fill="#94a3b8" font-size="10" font-weight="600" font-family="'Plus Jakarta Sans', sans-serif">100%</text>
                    <line x1="38" y1="20" x2="610" y2="20" stroke="#f0f4f1" stroke-dasharray="4 4" stroke-width="1"/>

                    <!-- 75% -->
                    <text x="6" y="64" fill="#94a3b8" font-size="10" font-weight="600" font-family="'Plus Jakarta Sans', sans-serif">75%</text>
                    <line x1="38" y1="60" x2="610" y2="60" stroke="#f0f4f1" stroke-dasharray="4 4" stroke-width="1"/>

                    <!-- 50% -->
                    <text x="6" y="104" fill="#94a3b8" font-size="10" font-weight="600" font-family="'Plus Jakarta Sans', sans-serif">50%</text>
                    <line x1="38" y1="100" x2="610" y2="100" stroke="#f0f4f1" stroke-dasharray="4 4" stroke-width="1"/>

                    <!-- 25% -->
                    <text x="6" y="144" fill="#94a3b8" font-size="10" font-weight="600" font-family="'Plus Jakarta Sans', sans-serif">25%</text>
                    <line x1="38" y1="140" x2="610" y2="140" stroke="#f0f4f1" stroke-dasharray="4 4" stroke-width="1"/>

                    <!-- 0% -->
                    <text x="12" y="184" fill="#94a3b8" font-size="10" font-weight="600" font-family="'Plus Jakarta Sans', sans-serif">0%</text>
                    <line x1="38" y1="180" x2="610" y2="180" stroke="#e2ece4" stroke-width="1"/>

                    <!-- Area fill under spline -->
                    <path id="trendAreaPath" 
                          d="M60 180 L60 58.4 Q110 54, 160 51.2 T260 44 T360 48.8 T460 39.2 T560 40 L560 180 Z" 
                          fill="url(#trendGrad)" />

                    <!-- Smooth green spline line -->
                    <path id="trendLinePath" 
                          d="M60 58.4 Q110 54, 160 51.2 T260 44 T360 48.8 T460 39.2 T560 40" 
                          fill="none" stroke="#2d6a4f" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />

                    <!-- Point 1: Nov 76.0% (X: 60, Y: 58.4) -->
                    <text x="60" y="46" fill="#183324" font-size="11" font-weight="700" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">76.0%</text>
                    <circle cx="60" cy="58.4" r="4.5" fill="#ffffff" stroke="#2d6a4f" stroke-width="2.5"/>
                    <text x="60" y="202" fill="#718576" font-size="11" font-weight="600" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">Nov</text>

                    <!-- Point 2: Dec 80.5% (X: 160, Y: 51.2) -->
                    <text x="160" y="38" fill="#183324" font-size="11" font-weight="700" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">80.5%</text>
                    <circle cx="160" cy="51.2" r="4.5" fill="#ffffff" stroke="#2d6a4f" stroke-width="2.5"/>
                    <text x="160" y="202" fill="#718576" font-size="11" font-weight="600" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">Dec</text>

                    <!-- Point 3: Jan 85.0% (X: 260, Y: 44) -->
                    <text x="260" y="30" fill="#183324" font-size="11" font-weight="700" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">85.0%</text>
                    <circle cx="260" cy="44" r="4.5" fill="#ffffff" stroke="#2d6a4f" stroke-width="2.5"/>
                    <text x="260" y="202" fill="#718576" font-size="11" font-weight="600" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">Jan</text>

                    <!-- Point 4: Feb 82.0% (X: 360, Y: 48.8) -->
                    <text x="360" y="36" fill="#183324" font-size="11" font-weight="700" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">82.0%</text>
                    <circle cx="360" cy="48.8" r="4.5" fill="#ffffff" stroke="#2d6a4f" stroke-width="2.5"/>
                    <text x="360" y="202" fill="#718576" font-size="11" font-weight="600" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">Feb</text>

                    <!-- Point 5: Mar 88.0% (X: 460, Y: 39.2) -->
                    <text x="460" y="26" fill="#183324" font-size="11" font-weight="700" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">88.0%</text>
                    <circle cx="460" cy="39.2" r="4.5" fill="#ffffff" stroke="#2d6a4f" stroke-width="2.5"/>
                    <text x="460" y="202" fill="#718576" font-size="11" font-weight="600" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">Mar</text>

                    <!-- Point 6: Apr 87.5% (X: 560, Y: 40) with Green Active Badge -->
                    <rect x="536" y="16" width="48" height="18" rx="9" fill="#1c4b32"/>
                    <text x="560" y="29" fill="#ffffff" font-size="10" font-weight="800" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">87.5%</text>
                    <circle cx="560" cy="40" r="5" fill="#ffffff" stroke="#1c4b32" stroke-width="3"/>
                    <text x="560" y="202" fill="#1c4b32" font-size="11" font-weight="700" text-anchor="middle" font-family="'Plus Jakarta Sans', sans-serif">Apr</text>
                </svg>
            </div>

        </div>

        <!-- Right: Overall Average Donut Gauge & Distribution Card -->
        <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 26px 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-around; flex-wrap: wrap; gap: 20px;">
            
            <!-- Circular Donut Gauge -->
            <div style="position: relative; width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="120" height="120" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="48" stroke="#e2ece4" stroke-width="8.5" fill="none" />
                    <circle cx="60" cy="60" r="48" stroke="#2d6a4f" stroke-width="8.5" stroke-linecap="round" fill="none"
                            stroke-dasharray="301.59" 
                            stroke-dashoffset="<?= $dashOffset ?>"
                            style="transform: rotate(-90deg); transform-origin: 50% 50%; transition: stroke-dashoffset 0.6s ease;" />
                </svg>
                <div style="position: absolute; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                    <span style="font-size: 1.45rem; font-weight: 800; color: #183324; font-variant-numeric: tabular-nums; line-height: 1;">
                        <?= number_format($avg, 1) ?>%
                    </span>
                    <span style="font-size: 0.65rem; font-weight: 600; color: #718576; text-transform: capitalize; margin-top: 4px;">
                        Overall<br>Average
                    </span>
                </div>
            </div>

            <!-- Grade Distribution Legend -->
            <div style="display: flex; flex-direction: column; gap: 12px; font-size: 0.82rem; min-width: 145px;">
                <!-- 90% - 100% -->
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="width: 7px; height: 7px; border-radius: 50%; background: #2d6a4f; flex-shrink: 0;"></span>
                        <span style="color: #183324; font-weight: 600;">90% &ndash; 100%</span>
                    </div>
                    <strong style="color: #183324; font-weight: 700; font-variant-numeric: tabular-nums;"><?= $dist['90_100'] ?></strong>
                </div>

                <!-- 80% - 90% -->
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="width: 7px; height: 7px; border-radius: 50%; background: #52b788; flex-shrink: 0;"></span>
                        <span style="color: #183324; font-weight: 600;">80% &ndash; 90%</span>
                    </div>
                    <strong style="color: #183324; font-weight: 700; font-variant-numeric: tabular-nums;"><?= $dist['80_90'] ?></strong>
                </div>

                <!-- 70% - 80% -->
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="width: 7px; height: 7px; border-radius: 50%; background: #f59e0b; flex-shrink: 0;"></span>
                        <span style="color: #183324; font-weight: 600;">70% &ndash; 80%</span>
                    </div>
                    <strong style="color: #183324; font-weight: 700; font-variant-numeric: tabular-nums;"><?= $dist['70_80'] ?></strong>
                </div>

                <!-- < 70% -->
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="width: 7px; height: 7px; border-radius: 50%; background: #dc2626; flex-shrink: 0;"></span>
                        <span style="color: #183324; font-weight: 600;">&lt; 70%</span>
                    </div>
                    <strong style="color: #183324; font-weight: 700; font-variant-numeric: tabular-nums;"><?= $dist['under_70'] ?></strong>
                </div>
            </div>

        </div>

    </div>

    <!-- ==================================================== -->
    <!-- 3. EXAM GRADES TABLE CARD (8 Total)                  -->
    <!-- ==================================================== -->
    <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 22px 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        
        <!-- Table Header & Download Action -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#2d6a4f" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <h3 style="font-size: 0.98rem; font-weight: 700; color: #183324; margin: 0;">
                    Exam Grades (<span id="exam-total-count"><?= $examCount ?></span> Total)
                </h3>
            </div>

            <!-- Download Report Button -->
            <button type="button" onclick="triggerReportDownload()" 
                    style="background: #eaf1eb; color: #1c4b32; font-weight: 600; font-size: 0.8rem; padding: 7px 18px; border-radius: 999px; border: 1px solid #d4e2d6; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; font-family: inherit; transition: all 0.15s ease;">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Download Report</span>
            </button>
        </div>

        <!-- Responsive Table Container -->
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="exam-grades-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.84rem;">
                <thead>
                    <tr style="border-bottom: 1px solid #edf2ed;">
                        <th style="padding: 12px 14px; font-size: 0.76rem; font-weight: 700; color: #718576;">Date</th>
                        <th style="padding: 12px 14px; font-size: 0.76rem; font-weight: 700; color: #718576;">Exam Name</th>
                        <th style="padding: 12px 14px; font-size: 0.76rem; font-weight: 700; color: #718576;">Subject</th>
                        <th style="padding: 12px 14px; font-size: 0.76rem; font-weight: 700; color: #718576;">Score</th>
                        <th style="padding: 12px 14px; font-size: 0.76rem; font-weight: 700; color: #718576; text-align: center;">Grade</th>
                        <th style="padding: 12px 14px; font-size: 0.76rem; font-weight: 700; color: #718576;">Status</th>
                        <th style="padding: 12px 14px; font-size: 0.76rem; font-weight: 700; color: #718576; text-align: right;">View Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($marks)): ?>
                        <tr>
                            <td colspan="7" style="padding: 40px; text-align: center; color: #627467; font-weight: 500;">
                                No published examination records found for this student.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($marks as $m): 
                            $status = $m['status'];
                            $score = (float)$m['score'];
                            $dotColor = '#2d6a4f';
                            if ($status === 'Good') $dotColor = '#52b788';
                            elseif ($status === 'Passed') $dotColor = '#0284c7';
                            elseif ($status === 'Needs Review') $dotColor = '#dc2626';

                            // Grade pill style
                            $gradeBg = '#e8f5e9';
                            $gradeColor = '#2e7d32';
                            if (str_starts_with($m['grade'], 'B')) {
                                $gradeBg = '#fef3c7';
                                $gradeColor = '#b45309';
                            } elseif (str_starts_with($m['grade'], 'C')) {
                                $gradeBg = '#fee2e2';
                                $gradeColor = '#b91c1c';
                            }
                        ?>
                            <tr class="exam-row" style="border-bottom: 1px solid #f2f6f3; transition: background 0.15s ease;">
                                <td style="padding: 16px 14px; font-weight: 600; color: #3b5343; white-space: nowrap;">
                                    <?= htmlspecialchars($m['date']) ?>
                                </td>
                                <td style="padding: 16px 14px;">
                                    <strong style="color: #183324; font-size: 0.88rem; display: block;">
                                        <?= htmlspecialchars($m['exam_name']) ?>
                                    </strong>
                                </td>
                                <td style="padding: 16px 14px; color: #627467; font-weight: 500; white-space: nowrap;">
                                    <?= htmlspecialchars($m['subject']) ?>
                                </td>
                                <td style="padding: 16px 14px; font-weight: 800; color: #183324; font-variant-numeric: tabular-nums; white-space: nowrap;">
                                    <?= number_format($score, 1) ?>%
                                </td>
                                <td style="padding: 16px 14px; text-align: center; white-space: nowrap;">
                                    <span style="display: inline-block; padding: 3px 10px; border-radius: 999px; background: <?= $gradeBg ?>; color: <?= $gradeColor ?>; font-weight: 800; font-size: 0.76rem; min-width: 32px;">
                                        <?= htmlspecialchars($m['grade']) ?>
                                    </span>
                                </td>
                                <td style="padding: 16px 14px; white-space: nowrap;">
                                    <div style="display: flex; align-items: center; gap: 7px; font-weight: 600; font-size: 0.82rem; color: #183324;">
                                        <span style="width: 7px; height: 7px; border-radius: 50%; background: <?= $dotColor ?>; flex-shrink: 0;"></span>
                                        <span><?= htmlspecialchars($status) ?></span>
                                    </div>
                                </td>
                                <td style="padding: 16px 14px; text-align: right; white-space: nowrap;">
                                    <button type="button" 
                                            class="action-view-btn"
                                            onclick='openExamModal(<?= json_encode($m, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                        <span>View</span>
                                        <span style="font-size: 0.9rem;">&rarr;</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- ==================================================== -->
<!-- 4. INTERACTIVE EXAM ASSESSMENT MODAL                 -->
<!-- ==================================================== -->
<div id="examDetailsModal" class="exam-modal-overlay" style="display: none;">
    <div class="exam-modal-container">
        
        <!-- Modal Header -->
        <div class="exam-modal-header">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 38px; height: 38px; border-radius: 12px; background: #eaf1eb; color: #1c4b32; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 style="font-size: 1.05rem; font-weight: 700; color: #183324; margin: 0;">Assessment Transcript &amp; Evaluation</h3>
                    <p style="font-size: 0.76rem; color: #627467; margin: 2px 0 0 0;">Official Academic Grading Seal &bull; Kalavanta ERP</p>
                </div>
            </div>
            <button type="button" onclick="closeExamModal()" class="btn-close-modal" aria-label="Close">&times;</button>
        </div>

        <!-- Modal Body -->
        <div class="exam-modal-body">
            
            <!-- Assessment Title Highlight Box -->
            <div style="background: #f7faf7; border: 1px solid #e0ece2; border-radius: 14px; padding: 16px 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <div>
                    <span id="modal-exam-code" style="font-size: 0.72rem; font-weight: 800; color: #1c4b32; font-family: 'JetBrains Mono', monospace; display: block; margin-bottom: 2px;">
                        CYB301
                    </span>
                    <h4 id="modal-exam-title" style="font-size: 1.15rem; font-weight: 700; color: #183324; margin: 0;">
                        Network Defense Essentials
                    </h4>
                </div>
                <div style="text-align: right;">
                    <span id="modal-score-num" style="font-size: 1.6rem; font-weight: 800; color: #1c4b32; font-variant-numeric: tabular-nums; line-height: 1; display: block;">
                        94.0%
                    </span>
                    <span id="modal-grade-badge" style="display: inline-block; margin-top: 3px; padding: 2px 8px; border-radius: 999px; background: #e8f5e9; color: #2e7d32; font-weight: 800; font-size: 0.74rem;">
                        Grade A+
                    </span>
                </div>
            </div>

            <!-- Details Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <span style="font-size: 0.75rem; color: #718576; font-weight: 600; display: block; margin-bottom: 2px;">Examination Date</span>
                    <strong id="modal-exam-date" style="font-size: 0.88rem; color: #183324;">Apr 10, 2025</strong>
                </div>

                <div>
                    <span style="font-size: 0.75rem; color: #718576; font-weight: 600; display: block; margin-bottom: 2px;">Academic Stream</span>
                    <strong id="modal-exam-subject" style="font-size: 0.88rem; color: #183324;">Cyber Security</strong>
                </div>

                <div>
                    <span style="font-size: 0.75rem; color: #718576; font-weight: 600; display: block; margin-bottom: 2px;">Evaluation Status</span>
                    <span id="modal-status-text" style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 700; color: #2d6a4f;">
                        ● Excellent Performance
                    </span>
                </div>

                <div>
                    <span style="font-size: 0.75rem; color: #718576; font-weight: 600; display: block; margin-bottom: 2px;">Cohort Percentile</span>
                    <strong style="font-size: 0.88rem; color: #183324;">Top 4% in Division</strong>
                </div>

                <div style="grid-column: 1 / -1;">
                    <span style="font-size: 0.75rem; color: #718576; font-weight: 600; display: block; margin-bottom: 2px;">Lead Mentor &amp; Evaluator</span>
                    <strong style="font-size: 0.88rem; color: #183324;">Prof. Robert Miller &bull; Lead Faculty Lead</strong>
                </div>
            </div>

            <!-- Question/Section Breakdown -->
            <div style="background: #ffffff; border: 1px solid #edf2ed; border-radius: 12px; padding: 14px 16px;">
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #627467; display: block; margin-bottom: 10px;">
                    Assessment Sectional Breakdown
                </span>
                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.8rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #3b5343;">Section A: Practical Packet &amp; Firewall Hardening</span>
                        <strong style="color: #183324;">48.0 / 50.0 (96%)</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #3b5343;">Section B: Theoretical Defensive Protocol Design</span>
                        <strong style="color: #183324;">46.0 / 50.0 (92%)</strong>
                    </div>
                </div>
            </div>

            <!-- Security & Verification Seal -->
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.72rem; color: #627467; background: #f3f7f4; padding: 8px 12px; border-radius: 8px;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#2d6a4f" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Tamper-proof academic grade record registered in Kalavanta Edutech ERP Ledger</span>
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="exam-modal-footer">
            <button type="button" onclick="closeExamModal()" class="btn-modal-dismiss">
                Close
            </button>
            <button type="button" onclick="triggerReportDownload()" class="btn-modal-download">
                <span>Download PDF Transcript</span>
                <span>&rarr;</span>
            </button>
        </div>

    </div>
</div>

<!-- ==================================================== -->
<!-- STYLES                                               -->
<!-- ==================================================== -->
<style>
/* Period Pills */
.trend-pill-btn {
    border: none;
    background: transparent;
    color: #526757;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 999px;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.15s ease;
    white-space: nowrap;
}
.trend-pill-btn.active {
    background: #1c4b32 !important;
    color: #ffffff !important;
    box-shadow: 0 1px 3px rgba(28, 75, 50, 0.2);
}
.trend-pill-btn:hover:not(.active) {
    background: #e2ece4;
    color: #1c4b32;
}

/* Action View Button in Table */
.action-view-btn {
    padding: 6px 14px;
    border-radius: 999px;
    background: #eaf1eb;
    color: #1c4b32;
    font-weight: 600;
    font-size: 0.78rem;
    border: 1px solid #d4e2d6;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-family: inherit;
    transition: all 0.15s ease;
}
.action-view-btn:hover {
    background: #1c4b32;
    color: #ffffff;
    border-color: #1c4b32;
}

/* Exam Row Hover */
.exam-row:hover {
    background: #fafcfb !important;
}

/* Modal Overlay & Styling */
.exam-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(18, 38, 26, 0.45);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.exam-modal-container {
    background: #ffffff;
    border-radius: 22px;
    max-width: 580px;
    width: 100%;
    box-shadow: 0 20px 45px rgba(0,0,0,0.18);
    overflow: hidden;
    border: 1px solid #dce8de;
    animation: examModalUp 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes examModalUp {
    from { opacity: 0; transform: translateY(12px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.exam-modal-header {
    background: #f4f8f5;
    padding: 20px 24px;
    border-bottom: 1px solid #e2ece4;
    display: flex;
    justify-content: space-between;
    align-items: center;
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
.exam-modal-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.exam-modal-footer {
    padding: 16px 24px;
    background: #fafcfa;
    border-top: 1px solid #edf2ed;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
}
.btn-modal-dismiss {
    background: #f3f7f4;
    color: #3b5343;
    border: 1px solid #d5e0d5;
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: background 0.15s ease;
}
.btn-modal-dismiss:hover {
    background: #e5ece6;
}
.btn-modal-download {
    background: #1c4b32;
    color: #ffffff;
    border: none;
    padding: 8px 20px;
    border-radius: 999px;
    font-size: 0.82rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: inherit;
    cursor: pointer;
    transition: background 0.15s ease;
}
.btn-modal-download:hover {
    background: #143725;
}

/* Responsive */
@media (max-width: 900px) {
    .trend-donut-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<!-- ==================================================== -->
<!-- JAVASCRIPT INTERACTIONS                              -->
<!-- ==================================================== -->
<script>
// Switch Period on Performance Trend
function switchTrendPeriod(period, btn) {
    document.querySelectorAll('.trend-pill-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');

    // Smooth update of trend graph
    const pathLine = document.getElementById('trendLinePath');
    const pathArea = document.getElementById('trendAreaPath');

    if (period === '1y') {
        if (pathLine) pathLine.setAttribute('d', 'M60 62 Q110 50, 160 48 T260 40 T360 44 T460 36 T560 40');
        if (pathArea) pathArea.setAttribute('d', 'M60 180 L60 62 Q110 50, 160 48 T260 40 T360 44 T460 36 T560 40 L560 180 Z');
    } else if (period === 'all') {
        if (pathLine) pathLine.setAttribute('d', 'M60 68 Q110 56, 160 50 T260 42 T360 40 T460 38 T560 40');
        if (pathArea) pathArea.setAttribute('d', 'M60 180 L60 68 Q110 56, 160 50 T260 42 T360 40 T460 38 T560 40 L560 180 Z');
    } else {
        if (pathLine) pathLine.setAttribute('d', 'M60 58.4 Q110 54, 160 51.2 T260 44 T360 48.8 T460 39.2 T560 40');
        if (pathArea) pathArea.setAttribute('d', 'M60 180 L60 58.4 Q110 54, 160 51.2 T260 44 T360 48.8 T460 39.2 T560 40 L560 180 Z');
    }
}

// Open Exam Assessment Modal
function openExamModal(data) {
    if (!data) return;

    document.getElementById('modal-exam-code').textContent = data.subject_code || 'CYB301';
    document.getElementById('modal-exam-title').textContent = data.clean_name || data.exam_name || 'Assessment';
    document.getElementById('modal-score-num').textContent = parseFloat(data.score).toFixed(1) + '%';
    document.getElementById('modal-grade-badge').textContent = 'Grade ' + (data.grade || 'A+');
    document.getElementById('modal-exam-date').textContent = data.date || 'Apr 10, 2025';
    document.getElementById('modal-exam-subject').textContent = data.subject || 'Cyber Security';
    document.getElementById('modal-status-text').textContent = '● ' + (data.status || 'Excellent') + ' Performance';

    const modal = document.getElementById('examDetailsModal');
    if (modal) modal.style.display = 'flex';
}

function closeExamModal() {
    const modal = document.getElementById('examDetailsModal');
    if (modal) modal.style.display = 'none';
}

// Download Report Trigger
function triggerReportDownload() {
    window.print();
}

// Close Modal on backdrop click or escape
window.addEventListener('click', function(e) {
    const modal = document.getElementById('examDetailsModal');
    if (e.target === modal) closeExamModal();
});
window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeExamModal();
});
</script>
