<div style="display: flex; flex-direction: column; gap: 32px;">
    
    <!-- Top Row: Quick Stats & Green Student Hub Banner -->
    <div style="display: flex; justify-content: space-between; align-items: stretch; gap: 24px; flex-wrap: wrap;">
        
        <!-- Left: Quick Stats Cards (Matching Theme Cards) -->
        <div style="flex: 1; min-width: 320px;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e2d24; margin-bottom: 14px;">Quick Stats</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 14px;">
                
                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #627467; margin-bottom: 6px;">Enrolled Tracks</div>
                    <div style="font-size: 1.85rem; font-weight: 700; color: #183324; line-height: 1;">
                        <?= !empty($subjects) ? count($subjects) : 4 ?>
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #627467; margin-bottom: 6px;">Attendance Rate</div>
                    <div style="font-size: 1.65rem; font-weight: 700; color: #183324; line-height: 1.2;">
                        <?= !empty($attendanceStats['percentage']) ? $attendanceStats['percentage'] . '%' : '92%' ?>
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #627467; margin-bottom: 6px;">Completed Labs</div>
                    <div style="font-size: 1.85rem; font-weight: 700; color: #183324; line-height: 1;">
                        <?= !empty($recentMarks) ? (count($recentMarks) * 6 + 10) : 22 ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right: Student Hub Promo Banner Card (Using Uploaded High-Res Asset & DB Live Class) -->
        <div style="width: 100%; max-width: 380px; min-height: 170px; background: #cbe0d2 url('/assets/img/student-hub-bg.png') no-repeat right center / cover; border-radius: 20px; padding: 22px 24px; display: flex; flex-direction: column; justify-content: space-between; position: relative; border: 1px solid #b5d5bf; box-shadow: 0 2px 8px rgba(33, 75, 52, 0.06);">
            <div>
                <?php if ($activeLiveClass): ?>
                    
                    <h4 style="font-size: 1.15rem; font-weight: 800; color: #153e28; margin-bottom: 4px;">Student Hub</h4>
                    <p style="font-size: 0.8rem; color: #234f36; line-height: 1.4; max-width: 215px; font-weight: 600;">
                        <?= htmlspecialchars($activeLiveClass['title']) ?>
                    </p>
                <?php else: ?>
                    <h4 style="font-size: 1.2rem; font-weight: 800; color: #153e28; margin-bottom: 6px;">Student Hub</h4>
                    <p style="font-size: 0.82rem; color: #234f36; line-height: 1.45; max-width: 210px; font-weight: 500;">
                        Join the upcoming workshop on Offensive Security & Penetration Testing.
                    </p>
                <?php endif; ?>
            </div>
            <div style="margin-top: 14px;">
                <a href="/student/live-class" style="display: inline-block; background: #1c4b32; color: #ffffff; padding: 9px 20px; border-radius: 12px; font-size: 0.82rem; font-weight: 700; text-decoration: none; box-shadow: 0 2px 6px rgba(28, 75, 50, 0.3); transition: background 0.15s;" onmouseover="this.style.background='#133724'" onmouseout="this.style.background='#1c4b32'">
                    <?= $activeLiveClass ? 'Join Live Class &rarr;' : 'Live Class Hub &rarr;' ?>
                </a>
            </div>
        </div>

    </div>

    <!-- Section 2: Cybersecurity Courses (Replaces Recent Diagrams) -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e2d24; margin: 0;">Cybersecurity Courses</h3>
            <a href="/student/curriculum" style="font-size: 0.82rem; font-weight: 600; color: #2d6a4f; text-decoration: none;">View All Tracks &rarr;</a>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px;">
            
            <!-- Course Card 1: Network Defense Essentials -->
            <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.15s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.borderColor='#b2cbb7';" onmouseout="this.style.transform='none'; this.style.borderColor='#d8e2d8';" onclick="window.location='/student/curriculum'">
                <div style="background: #e2f0e5; border: 1px solid #cfe2d3; border-radius: 14px; height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 4px;">
                    <img src="/assets/img/course-network.png" alt="Network Defense Essentials" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; border-radius: 10px;">
                </div>
                <div style="margin-top: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <h4 style="font-size: 0.92rem; font-weight: 700; color: #183324; margin: 0 0 4px 0; line-height: 1.3;">Network Defense Essentials</h4>
                        <span style="color: #92a498; font-size: 1rem; cursor: pointer;" title="Options">•••</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.74rem; color: #627467; margin-top: 8px; margin-bottom: 6px;">
                        <span>Progress</span>
                        <span style="font-weight: 700; color: #1c4b32;">8 / 12 Labs (67%)</span>
                    </div>
                    <div style="background: #e5ece6; height: 5px; border-radius: 3px; overflow: hidden;">
                        <div style="background: #2d6a4f; height: 100%; width: 67%; border-radius: 3px;"></div>
                    </div>
                    <div style="margin-top: 8px; font-size: 0.72rem; color: #7a8d80;">Last edited... 3 hours ago</div>
                </div>
            </div>

            <!-- Course Card 2: Ethical Hacking & Pen Testing -->
            <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.15s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.borderColor='#b2cbb7';" onmouseout="this.style.transform='none'; this.style.borderColor='#d8e2d8';" onclick="window.location='/student/curriculum'">
                <div style="background: #e2f0e5; border: 1px solid #cfe2d3; border-radius: 14px; height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 4px;">
                    <img src="/assets/img/course-hacking.png" alt="Ethical Hacking & Pen Testing" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; border-radius: 10px;">
                </div>
                <div style="margin-top: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <h4 style="font-size: 0.92rem; font-weight: 700; color: #183324; margin: 0 0 4px 0; line-height: 1.3;">Ethical Hacking & Pen Testing</h4>
                        <span style="color: #92a498; font-size: 1rem; cursor: pointer;" title="Options">•••</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.74rem; color: #627467; margin-top: 8px; margin-bottom: 6px;">
                        <span>Progress</span>
                        <span style="font-weight: 700; color: #1c4b32;">5 / 10 Labs (50%)</span>
                    </div>
                    <div style="background: #e5ece6; height: 5px; border-radius: 3px; overflow: hidden;">
                        <div style="background: #2d6a4f; height: 100%; width: 50%; border-radius: 3px;"></div>
                    </div>
                    <div style="margin-top: 8px; font-size: 0.72rem; color: #7a8d80;">Last edited... 3 hours ago</div>
                </div>
            </div>

            <!-- Course Card 3: Cryptography & Data Security -->
            <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.15s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.borderColor='#b2cbb7';" onmouseout="this.style.transform='none'; this.style.borderColor='#d8e2d8';" onclick="window.location='/student/curriculum'">
                <div style="background: #e2f0e5; border: 1px solid #cfe2d3; border-radius: 14px; height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 4px;">
                    <img src="/assets/img/course-crypto.png" alt="Cryptographich & Data Security" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; border-radius: 10px;">
                </div>
                <div style="margin-top: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <h4 style="font-size: 0.92rem; font-weight: 700; color: #183324; margin: 0 0 4px 0; line-height: 1.3;">Cryptographic & Data Security</h4>
                        <span style="color: #92a498; font-size: 1rem; cursor: pointer;" title="Options">•••</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.74rem; color: #627467; margin-top: 8px; margin-bottom: 6px;">
                        <span>Progress</span>
                        <span style="font-weight: 700; color: #1c4b32;">6 / 8 Labs (75%)</span>
                    </div>
                    <div style="background: #e5ece6; height: 5px; border-radius: 3px; overflow: hidden;">
                        <div style="background: #2d6a4f; height: 100%; width: 75%; border-radius: 3px;"></div>
                    </div>
                    <div style="margin-top: 8px; font-size: 0.72rem; color: #7a8d80;">Last edited... 3 hours ago</div>
                </div>
            </div>

            <!-- Course Card 4: Incident Response & Forensics -->
            <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.15s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.borderColor='#b2cbb7';" onmouseout="this.style.transform='none'; this.style.borderColor='#d8e2d8';" onclick="window.location='/student/curriculum'">
                <div style="background: #e2f0e5; border: 1px solid #cfe2d3; border-radius: 14px; height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 4px;">
                    <img src="/assets/img/course-incident.png" alt="Incident Response & Forensics" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; border-radius: 10px;">
                </div>
                <div style="margin-top: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <h4 style="font-size: 0.92rem; font-weight: 700; color: #183324; margin: 0 0 4px 0; line-height: 1.3;">Incident Response & Forensics</h4>
                        <span style="color: #92a498; font-size: 1rem; cursor: pointer;" title="Options">•••</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.74rem; color: #627467; margin-top: 8px; margin-bottom: 6px;">
                        <span>Progress</span>
                        <span style="font-weight: 700; color: #1c4b32;">3 / 9 Labs (33%)</span>
                    </div>
                    <div style="background: #e5ece6; height: 5px; border-radius: 3px; overflow: hidden;">
                        <div style="background: #2d6a4f; height: 100%; width: 33%; border-radius: 3px;"></div>
                    </div>
                    <div style="margin-top: 8px; font-size: 0.72rem; color: #7a8d80;">Last edited... 3 hours ago</div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Row: Campus Bulletins vs Recent Activity (Minimalist & User-Friendly) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 24px; align-items: stretch;">
        
        <!-- Left Column: Campus Bulletins -->
        <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <!-- Card Header -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #edf2ed;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: #eaf3ec; color: #1c4b32; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div>
                            <h3 style="font-size: 1.08rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.2;">Campus Bulletins</h3>
                            <span style="font-size: 0.72rem; color: #7a8d80;">Official institutional announcements</span>
                        </div>
                    </div>
                    
                    <a href="/student/notices" style="font-size: 0.78rem; font-weight: 600; color: #2d6a4f; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 8px; background: #f0f6f1; transition: background 0.15s;" onmouseover="this.style.background='#e2ede4'" onmouseout="this.style.background='#f0f6f1'">
                        <span>All Bulletins</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <!-- Bulletins List -->
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <?php if (!empty($notices)): ?>
                        <?php foreach ($notices as $notice): ?>
                            <?php 
                                $titleLower = strtolower($notice['title']);
                                $isHackathon = strpos($titleLower, 'hackathon') !== false;
                                $isMaintenance = strpos($titleLower, 'maintenance') !== false || strpos($titleLower, 'sandbox') !== false;
                                $isReview = strpos($titleLower, 'review') !== false || strpos($titleLower, 'guidelines') !== false;
                                
                                if ($isHackathon) {
                                    $badgeText = 'Competition';
                                    $badgeBg = '#eef2ff';
                                    $badgeColor = '#3730a3';
                                } elseif ($isMaintenance) {
                                    $badgeText = 'System';
                                    $badgeBg = '#fff7ed';
                                    $badgeColor = '#9a3412';
                                } elseif ($isReview) {
                                    $badgeText = 'Academic';
                                    $badgeBg = '#f0fdf4';
                                    $badgeColor = '#166534';
                                } else {
                                    $badgeText = 'Notice';
                                    $badgeBg = '#f3f4f6';
                                    $badgeColor = '#374151';
                                }
                            ?>
                            <div style="padding: 12px 14px; border: 1px solid #eef3ee; border-radius: 12px; background: #fafcfa; transition: all 0.15s ease; cursor: pointer;" onmouseover="this.style.background='#ffffff'; this.style.borderColor='#b8d5bf'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.03)';" onmouseout="this.style.background='#fafcfa'; this.style.borderColor='#eef3ee'; this.style.boxShadow='none';" onclick="window.location='/student/notices'">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; gap: 8px;">
                                    <span style="font-size: 0.67rem; font-weight: 700; padding: 2px 7px; border-radius: 5px; background: <?= $badgeBg ?>; color: <?= $badgeColor ?>; text-transform: uppercase; letter-spacing: 0.3px;">
                                        <?= $badgeText ?>
                                    </span>
                                    <span style="font-size: 0.7rem; color: #8a9c8f; font-weight: 500;">
                                        <?= date('M d, Y', strtotime($notice['created_at'])) ?>
                                    </span>
                                </div>
                                <h4 style="font-size: 0.86rem; font-weight: 600; color: #183324; margin: 0 0 4px 0; line-height: 1.35;">
                                    <?= htmlspecialchars($notice['title']) ?>
                                </h4>
                                <p style="font-size: 0.74rem; color: #5b6f60; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= htmlspecialchars($notice['body']) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="padding: 28px 16px; text-align: center; color: #7a8d80; font-size: 0.82rem;">
                            No pending campus notices.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card Footer -->
            <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #edf2ed; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.72rem; color: #7a8d80;">Updated daily by Academic Dean Office</span>
                <a href="/student/notices" style="font-size: 0.78rem; font-weight: 700; color: #2d6a4f; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                    <span>Open Bulletins Desk</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Right Column: Recent Activity (Minimalist & Clean) -->
        <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <!-- Card Header -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #edf2ed;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: #eaf3ec; color: #1c4b32; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 style="font-size: 1.08rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.2;">Recent Activity</h3>
                            <span style="font-size: 0.72rem; color: #7a8d80;">Learning & submission log</span>
                        </div>
                    </div>
                    
                    <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.72rem; font-weight: 600; color: #2e7d32; background: #edf7ee; padding: 3px 9px; border-radius: 999px;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #2ecc71;"></span>
                        <span>Live Feed</span>
                    </span>
                </div>

                <!-- Activity Items List -->
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    
                    <!-- Activity Item 1: Student Lab Submission -->
                    <div style="display: flex; align-items: flex-start; gap: 12px; padding: 12px 14px; border: 1px solid #eef3ee; border-radius: 12px; background: #fafcfa;">
                        <div style="width: 34px; height: 34px; border-radius: 8px; background: #e2f0e5; color: #1c4b32; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                <span style="font-size: 0.68rem; font-weight: 700; color: #2d6a4f; text-transform: uppercase; letter-spacing: 0.3px;">Lab Submission</span>
                                <span style="font-size: 0.7rem; color: #8a9c8f;">1h ago</span>
                            </div>
                            <p style="font-size: 0.82rem; font-weight: 600; color: #183324; margin: 0 0 4px 0; line-height: 1.35;">
                                <strong>Shantanu</strong> submitted "Network Defense Lab #4"
                            </p>
                            <span style="background: #e8f5e9; color: #1e4620; font-size: 0.68rem; font-weight: 700; padding: 2px 7px; border-radius: 5px; display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                Score: 94 / 100
                            </span>
                        </div>
                    </div>

                    <!-- Activity Item 2: Faculty Review -->
                    <div style="display: flex; align-items: flex-start; gap: 12px; padding: 12px 14px; border: 1px solid #eef3ee; border-radius: 12px; background: #fafcfa;">
                        <div style="width: 34px; height: 34px; border-radius: 8px; background: #1c4b32; color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                <span style="font-size: 0.68rem; font-weight: 700; color: #1c4b32; text-transform: uppercase; letter-spacing: 0.3px;">Faculty Review</span>
                                <span style="font-size: 0.7rem; color: #8a9c8f;">2m ago</span>
                            </div>
                            <p style="font-size: 0.82rem; font-weight: 600; color: #183324; margin: 0 0 4px 0; line-height: 1.35;">
                                <strong>Prof. Robert Miller</strong> reviewed Penetration Testing Report
                            </p>
                            <div style="font-size: 0.72rem; color: #435b4b; background: #f4f8f5; padding: 5px 8px; border-left: 2px solid #2d6a4f; border-radius: 4px; line-height: 1.3;">
                                "Approved. Excellent packet trace analysis and remediation recommendations."
                            </div>
                        </div>
                    </div>

                    <!-- Activity Item 3: Milestone Achievement -->
                    <div style="display: flex; align-items: flex-start; gap: 12px; padding: 12px 14px; border: 1px solid #eef3ee; border-radius: 12px; background: #fafcfa;">
                        <div style="width: 34px; height: 34px; border-radius: 8px; background: #fef3c7; color: #b45309; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                <span style="font-size: 0.68rem; font-weight: 700; color: #b45309; text-transform: uppercase; letter-spacing: 0.3px;">Milestone Achieved</span>
                                <span style="font-size: 0.7rem; color: #8a9c8f;">Yesterday</span>
                            </div>
                            <p style="font-size: 0.82rem; font-weight: 600; color: #183324; margin: 0 0 4px 0; line-height: 1.35;">
                                Completed 75% of Cryptographic & Data Security Track
                            </p>
                            <span style="background: #fef3c7; color: #92400e; font-size: 0.68rem; font-weight: 700; padding: 2px 7px; border-radius: 5px;">
                                Top 5% in COMP Class
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Card Footer -->
            <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #edf2ed; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.72rem; color: #7a8d80;">Last synced 2m ago</span>
                <a href="/student/curriculum" style="font-size: 0.78rem; font-weight: 700; color: #2d6a4f; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                    <span>Full Activity Logbook</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

    </div>

</div>
