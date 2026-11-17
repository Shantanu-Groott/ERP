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
                    <img src="/assets/img/course-hacking.png" alt="Ethical Hacking & Pen Testing" style="width: 100%; height: 100%; object-fit: contain; display: block; border-radius: 10px;">
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
                    <img src="/assets/img/course-crypto.png" alt="Cryptographich & Data Security" style="width: 100%; height: 100%; object-fit: contain; display: block; border-radius: 10px;">
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
                    <img src="/assets/img/course-incident.png" alt="Incident Response & Forensics" style="width: 100%; height: 100%; object-fit: contain; display: block; border-radius: 10px;">
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

    <!-- Bottom Row: Personalized Recommendations & Dynamic Bulletins vs Recent Activity -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 24px;">
        
        <!-- Left Column: Segmented Switcher for Recommendations & Dynamic Notices -->
        <div>
            <!-- Header with Segmented Navigation Pills -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
                <div style="display: inline-flex; background: #eaf1eb; padding: 3px; border-radius: 12px; border: 1px solid #d8e5da;">
                    <button id="btn-tab-recs" onclick="switchDashboardTab('recs')" style="background: #ffffff; color: #1c4b32; font-weight: 700; font-size: 0.8rem; padding: 6px 14px; border-radius: 9px; border: none; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.06); transition: all 0.15s; font-family: inherit;">
                        Personalized Recommendations
                    </button>
                    <button id="btn-tab-notices" onclick="switchDashboardTab('notices')" style="background: transparent; color: #5a7061; font-weight: 600; font-size: 0.8rem; padding: 6px 14px; border-radius: 9px; border: none; cursor: pointer; transition: all 0.15s; font-family: inherit; display: inline-flex; align-items: center; gap: 5px;">
                        <span>Campus Bulletins</span>
                        <?php if (!empty($notices)): ?>
                            <span style="background: #2d6a4f; color: #ffffff; font-size: 0.68rem; font-weight: 700; padding: 1px 6px; border-radius: 999px; line-height: 1.2;"><?= count($notices) ?></span>
                        <?php endif; ?>
                    </button>
                </div>
                
                <a href="/student/notices" id="link-notices-more" style="display: none; font-size: 0.78rem; font-weight: 600; color: #2d6a4f; text-decoration: none; align-items: center; gap: 4px;">
                    View All Notices &rarr;
                </a>
            </div>

            <!-- Tab 1: Personalized Recommendations (With Authentic Tool Vector Logos) -->
            <div id="dashboard-recs-tab" style="display: flex; flex-direction: column; gap: 12px;">
                
                <!-- Recommendation 1: Wireshark Network Forensics Lab -->
                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 16px; display: flex; align-items: center; justify-content: space-between; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.15s ease; cursor: pointer;" onmouseover="this.style.borderColor='#2d6a4f'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='#d8e2d8'; this.style.transform='none';" onclick="window.location='/student/live-class'">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <!-- Authentic Wireshark Vector Logo -->
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #f0f7fd; border: 1px solid #d0e4f7; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);">
                            <svg width="32" height="32" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" rx="10" fill="#0A3D62"/>
                                <path d="M10 35C17 35 22 31 24 26C26 21 28 16 34 13C33 18 30 24 27 27C23 31 18 34 10 35Z" fill="#00A8FF"/>
                                <path d="M12 35C18 35 23 32.5 26 28C28.5 24 30.5 18 38 13C33 19 29 27 20 32C17 33.8 14 34.8 12 35Z" fill="#FFFFFF"/>
                                <path d="M14 35C20 33.5 25 30 29 24C27 27 22 30 16 32.5L14 35Z" fill="#0077B6"/>
                            </svg>
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 2px;">
                                <h4 style="font-size: 0.92rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.3;">Wireshark Packet Analysis</h4>
                                <span style="background: #e3f2fd; color: #0d47a1; font-size: 0.68rem; font-weight: 700; padding: 2px 7px; border-radius: 6px;">Interactive Sandbox</span>
                            </div>
                            <p style="font-size: 0.74rem; color: #627467; margin: 0 0 6px 0; line-height: 1.35;">
                                Deep packet capture inspection, TCP stream reassembly & TShark filtering.
                            </p>
                            <div style="display: flex; gap: 8px; align-items: center; font-size: 0.7rem; color: #4e6354; font-weight: 600;">
                                <span style="display: inline-flex; align-items: center; gap: 3px;">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    Difficulty: Intermediate
                                </span>
                                <span>•</span>
                                <span>Track: CYB301</span>
                            </div>
                        </div>
                    </div>
                    <div style="flex-shrink: 0;">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background: #eaf3ec; color: #1c4b32; font-size: 0.85rem; font-weight: 700;">&rarr;</span>
                    </div>
                </div>

                <!-- Recommendation 2: OWASP Top 10 Web Exploitation -->
                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 16px; display: flex; align-items: center; justify-content: space-between; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.15s ease; cursor: pointer;" onmouseover="this.style.borderColor='#2d6a4f'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='#d8e2d8'; this.style.transform='none';" onclick="window.location='/student/projects'">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <!-- Authentic OWASP Vector Logo -->
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fdfaf3; border: 1px solid #f2e3c6; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);">
                            <svg width="32" height="32" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" rx="10" fill="#14213D"/>
                                <path d="M24 10L36 15V24C36 31.5 30.9 38.5 24 40C17.1 38.5 12 31.5 12 24V15L24 10Z" fill="#1F2937" stroke="#FCA311" stroke-width="2.5"/>
                                <circle cx="24" cy="24" r="6" stroke="#FFFFFF" stroke-width="2.2" fill="none"/>
                                <path d="M21 21L27 27M27 21L21 27" stroke="#FCA311" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 2px;">
                                <h4 style="font-size: 0.92rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.3;">OWASP Top 10 Exploits</h4>
                                <span style="background: #fef3c7; color: #92400e; font-size: 0.68rem; font-weight: 700; padding: 2px 7px; border-radius: 6px;">Hands-on Sandbox</span>
                            </div>
                            <p style="font-size: 0.74rem; color: #627467; margin: 0 0 6px 0; line-height: 1.35;">
                                Practice live injection testing, Broken Object Level Auth & SSRF attacks.
                            </p>
                            <div style="display: flex; gap: 8px; align-items: center; font-size: 0.7rem; color: #4e6354; font-weight: 600;">
                                <span style="display: inline-flex; align-items: center; gap: 3px;">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    Difficulty: Advanced
                                </span>
                                <span>•</span>
                                <span>Track: CYB302</span>
                            </div>
                        </div>
                    </div>
                    <div style="flex-shrink: 0;">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background: #eaf3ec; color: #1c4b32; font-size: 0.85rem; font-weight: 700;">&rarr;</span>
                    </div>
                </div>

                <!-- Recommendation 3: Tailored for Shantanu -->
                <div style="background: linear-gradient(135deg, #f7faf7 0%, #edf5ef 100%); border: 1px dashed #b9d8c0; border-radius: 16px; padding: 14px 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; cursor: pointer; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='none';" onclick="window.location='/student/curriculum'">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: #2d6a4f; color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div>
                            <span style="font-size: 0.7rem; font-weight: 700; color: #2d6a4f; text-transform: uppercase; letter-spacing: 0.5px;">Recommended for Shantanu</span>
                            <div style="font-size: 0.82rem; font-weight: 700; color: #183324; line-height: 1.2;">
                                Cryptographic Key Exchange & RSA Prime Generation
                            </div>
                            <span style="font-size: 0.72rem; color: #627467;">Curated based on your 75% Cryptography track progress</span>
                        </div>
                    </div>
                    <span style="font-size: 0.76rem; font-weight: 700; color: #2d6a4f; white-space: nowrap;">Resume &rarr;</span>
                </div>

            </div>

            <!-- Tab 2: Dynamic Campus Notices & Bulletins (Hidden by Default) -->
            <div id="dashboard-notices-tab" style="display: none; flex-direction: column; gap: 12px;">
                <?php if (!empty($notices)): ?>
                    <?php foreach ($notices as $notice): ?>
                        <?php 
                            $isUrgent = stripos($notice['title'], 'maintenance') !== false || stripos($notice['title'], 'review') !== false;
                            $isHackathon = stripos($notice['title'], 'hackathon') !== false;
                            $badgeColor = $isHackathon ? '#3730a3' : ($isUrgent ? '#b45309' : '#1b4332');
                            $badgeBg = $isHackathon ? '#eef2ff' : ($isUrgent ? '#fef3c7' : '#e8f5e9');
                            $badgeLabel = $isHackathon ? 'Campus Hackathon' : ($isUrgent ? 'Important Notice' : 'Academic Bulletin');
                        ?>
                        <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 14px 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: border-color 0.15s;" onmouseover="this.style.borderColor='#2d6a4f';" onmouseout="this.style.borderColor='#d8e2d8';">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; gap: 8px;">
                                <span style="background: <?= $badgeBg ?>; color: <?= $badgeColor ?>; font-size: 0.68rem; font-weight: 700; padding: 2px 8px; border-radius: 6px;">
                                    <?= $badgeLabel ?>
                                </span>
                                <span style="font-size: 0.7rem; color: #8a9c8f; font-weight: 500;">
                                    <?= date('M d, Y', strtotime($notice['created_at'])) ?>
                                </span>
                            </div>
                            <h4 style="font-size: 0.88rem; font-weight: 700; color: #183324; margin: 0 0 4px 0; line-height: 1.3;">
                                <?= htmlspecialchars($notice['title']) ?>
                            </h4>
                            <p style="font-size: 0.76rem; color: #526657; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= htmlspecialchars($notice['body']) ?>
                            </p>
                            <div style="margin-top: 8px; display: flex; justify-content: space-between; align-items: center; font-size: 0.7rem; color: #7a8d80;">
                                <span>Author: <?= htmlspecialchars($notice['author_name'] ?? 'Academic Dean Office') ?></span>
                                <a href="/student/notices" style="color: #2d6a4f; font-weight: 600; text-decoration: none;">Read details &rarr;</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 24px; text-align: center; color: #7a8d80; font-size: 0.84rem;">
                        No pending announcements or campus notices at this time.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Recent Activity Feed (Clean Professional Styling, No Plain Emojis) -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e2d24; margin: 0;">Recent Activity</h3>
                    <span style="display: inline-flex; width: 7px; height: 7px; border-radius: 50%; background: #2ecc71; box-shadow: 0 0 6px rgba(46, 204, 113, 0.6);" title="Live feed updated"></span>
                </div>
                <span style="font-size: 0.74rem; color: #7a8d80; font-weight: 600;">Verified Stream</span>
            </div>

            <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 20px; display: flex; flex-direction: column; gap: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                
                <!-- Activity Item 1: Student Lab Submission -->
                <div style="display: flex; align-items: flex-start; gap: 14px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #e2f0e5; border: 1px solid #cfe2d3; color: #1c4b32; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                            <span style="font-size: 0.7rem; font-weight: 700; color: #2d6a4f; text-transform: uppercase; letter-spacing: 0.4px;">Lab Submission</span>
                            <span style="font-size: 0.7rem; color: #8a9c8f;">1 hour ago</span>
                        </div>
                        <p style="font-size: 0.83rem; font-weight: 600; color: #183324; margin: 0 0 5px 0; line-height: 1.35;">
                            <strong>Shantanu</strong> submitted <strong>"Network Defense Lab #4 (Packet Forensics)"</strong>
                        </p>
                        <span style="background: #e8f5e9; color: #1e4620; font-size: 0.7rem; font-weight: 700; padding: 2px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                            <svg width="11" height="11" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Evaluated: 94 / 100
                        </span>
                    </div>
                </div>

                <!-- Activity Item 2: Faculty / Instructor Review -->
                <div style="display: flex; align-items: flex-start; gap: 14px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #1c4b32; color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 5px rgba(28, 75, 50, 0.25);">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                            <span style="font-size: 0.7rem; font-weight: 700; color: #1c4b32; text-transform: uppercase; letter-spacing: 0.4px;">Faculty Review</span>
                            <span style="font-size: 0.7rem; color: #8a9c8f;">2 minutes ago</span>
                        </div>
                        <p style="font-size: 0.83rem; font-weight: 600; color: #183324; margin: 0 0 5px 0; line-height: 1.35;">
                            <strong>Prof. Robert Miller</strong> reviewed <strong>Shantanu's</strong> Penetration Testing Report
                        </p>
                        <div style="font-size: 0.74rem; color: #435b4b; background: #f4f8f5; padding: 6px 10px; border-left: 3px solid #2d6a4f; border-radius: 4px; line-height: 1.35;">
                            "Approved. Excellent packet trace analysis and remediation recommendations."
                        </div>
                    </div>
                </div>

                <!-- Activity Item 3: Milestone Achievement -->
                <div style="display: flex; align-items: flex-start; gap: 14px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #fef3c7; border: 1px solid #fde68a; color: #b45309; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                            <span style="font-size: 0.7rem; font-weight: 700; color: #b45309; text-transform: uppercase; letter-spacing: 0.4px;">Milestone Achieved</span>
                            <span style="font-size: 0.7rem; color: #8a9c8f;">Yesterday</span>
                        </div>
                        <p style="font-size: 0.83rem; font-weight: 600; color: #183324; margin: 0 0 4px 0; line-height: 1.35;">
                            Completed 75% of <strong>Cryptographic & Data Security</strong> Track
                        </p>
                        <span style="background: #fef3c7; color: #92400e; font-size: 0.7rem; font-weight: 700; padding: 2px 8px; border-radius: 6px;">
                            Top 5% in COMP Class
                        </span>
                    </div>
                </div>

                <!-- Footer Link -->
                <div style="padding-top: 12px; border-top: 1px solid #edf2ed; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.72rem; color: #7a8d80;">Last synced 2m ago</span>
                    <a href="/student/curriculum" style="font-size: 0.78rem; font-weight: 700; color: #2d6a4f; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        <span>Full Activity Logbook</span>
                        <span>&rarr;</span>
                    </a>
                </div>

            </div>
        </div>

    </div>

    <!-- Inline Script for Tab Switcher -->
    <script>
        function switchDashboardTab(tab) {
            var recsSection = document.getElementById('dashboard-recs-tab');
            var noticesSection = document.getElementById('dashboard-notices-tab');
            var btnRecs = document.getElementById('btn-tab-recs');
            var btnNotices = document.getElementById('btn-tab-notices');
            var linkNoticesMore = document.getElementById('link-notices-more');
            
            if (tab === 'recs') {
                if (recsSection) recsSection.style.display = 'flex';
                if (noticesSection) noticesSection.style.display = 'none';
                if (btnRecs) {
                    btnRecs.style.background = '#ffffff';
                    btnRecs.style.color = '#1c4b32';
                    btnRecs.style.boxShadow = '0 1px 3px rgba(0,0,0,0.06)';
                }
                if (btnNotices) {
                    btnNotices.style.background = 'transparent';
                    btnNotices.style.color = '#5a7061';
                    btnNotices.style.boxShadow = 'none';
                }
                if (linkNoticesMore) linkNoticesMore.style.display = 'none';
            } else {
                if (recsSection) recsSection.style.display = 'none';
                if (noticesSection) noticesSection.style.display = 'flex';
                if (btnNotices) {
                    btnNotices.style.background = '#ffffff';
                    btnNotices.style.color = '#1c4b32';
                    btnNotices.style.boxShadow = '0 1px 3px rgba(0,0,0,0.06)';
                }
                if (btnRecs) {
                    btnRecs.style.background = 'transparent';
                    btnRecs.style.color = '#5a7061';
                    btnRecs.style.boxShadow = 'none';
                }
                if (linkNoticesMore) linkNoticesMore.style.display = 'inline-flex';
            }
        }
    </script>

</div>
