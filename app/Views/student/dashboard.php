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
                        4
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #627467; margin-bottom: 6px;">Last Activity</div>
                    <div style="font-size: 1.35rem; font-weight: 700; color: #183324; line-height: 1.3;">
                        2 hours ago
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #627467; margin-bottom: 6px;">Completed Labs</div>
                    <div style="font-size: 1.85rem; font-weight: 700; color: #183324; line-height: 1;">
                        22
                    </div>
                </div>

            </div>
        </div>

        <!-- Right: Student Hub Promo Banner Card (Using Uploaded High-Res Asset) -->
        <div style="width: 100%; max-width: 380px; min-height: 170px; background: #cbe0d2 url('/assets/img/student-hub-bg.png') no-repeat right center / cover; border-radius: 20px; padding: 22px 24px; display: flex; flex-direction: column; justify-content: space-between; position: relative; border: 1px solid #b5d5bf; box-shadow: 0 2px 8px rgba(33, 75, 52, 0.06);">
            <div>
                <h4 style="font-size: 1.2rem; font-weight: 800; color: #153e28; margin-bottom: 6px;">Student Hub</h4>
                <p style="font-size: 0.82rem; color: #234f36; line-height: 1.45; max-width: 210px; font-weight: 500;">
                    Join the upcoming workshop on Offensive Security & Penetration Testing.
                </p>
            </div>
            <div style="margin-top: 16px;">
                <a href="/student/live-class" style="display: inline-block; background: #1c4b32; color: #ffffff; padding: 9px 20px; border-radius: 12px; font-size: 0.82rem; font-weight: 700; text-decoration: none; box-shadow: 0 2px 6px rgba(28, 75, 50, 0.3); transition: background 0.15s;" onmouseover="this.style.background='#133724'" onmouseout="this.style.background='#1c4b32'">
                    Upgrade to Pro
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
                    <img src="/assets/img/course-network.png" alt="Network Defense Essentials" style="width: 100%; height: 100%; object-fit: contain; display: block; border-radius: 10px;">
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

    <!-- Bottom Row: Learn & Practice vs Recent Activity -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
        
        <!-- Learn & Practice / Recommended Tutorials -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e2d24; margin: 0;">Learn & Practice</h3>
                <div style="display: flex; gap: 8px;">
                    <span style="cursor: pointer; color: #7b8f80; font-size: 0.9rem;" title="Previous">&lt;</span>
                    <span style="cursor: pointer; color: #7b8f80; font-size: 0.9rem;" title="Next">&gt;</span>
                </div>
            </div>
            
            <div style="font-size: 0.8rem; font-weight: 600; color: #627467; margin-bottom: 10px;">Recommended Cyber Labs</div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;">
                
                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 14px; display: flex; align-items: center; gap: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); cursor: pointer; transition: transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'" onclick="window.location='/student/live-class'">
                    <div style="width: 48px; height: 48px; border-radius: 10px; background: #2d6a4f; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        🛡️
                    </div>
                    <div>
                        <h5 style="font-size: 0.85rem; font-weight: 700; color: #183324; line-height: 1.3; margin: 0 0 2px 0;">Wireshark Packet Analysis ↗</h5>
                        <span style="font-size: 0.72rem; color: #7a8d80;">Interactive Lab</span>
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 14px; display: flex; align-items: center; gap: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); cursor: pointer; transition: transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'" onclick="window.location='/student/projects'">
                    <div style="width: 48px; height: 48px; border-radius: 10px; background: #2d6a4f; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        ⚡
                    </div>
                    <div>
                        <h5 style="font-size: 0.85rem; font-weight: 700; color: #183324; line-height: 1.3; margin: 0 0 2px 0;">OWASP Top 10 Exploits ↗</h5>
                        <span style="font-size: 0.72rem; color: #7a8d80;">Hands-on Sandbox</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Recent Activity Feed (Using Shantanu Everywhere) -->
        <div>
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e2d24; margin-bottom: 14px;">Recent Activity</h3>

            <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 18px 20px; display: flex; flex-direction: column; gap: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                
                <!-- Activity Item 1 -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #d8e8dc; color: #235439; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.95rem; flex-shrink: 0;">
                        ✏️
                    </div>
                    <div>
                        <p style="font-size: 0.84rem; font-weight: 600; color: #183324; margin: 0;">
                            <strong>Shantanu</strong> submitted <strong>"Network Defense Lab #4"</strong>
                        </p>
                        <span style="font-size: 0.72rem; color: #7a8d80;">1 hour ago</span>
                    </div>
                </div>

                <!-- Activity Item 2 -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #235439; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                        S
                    </div>
                    <div>
                        <p style="font-size: 0.84rem; font-weight: 600; color: #183324; margin: 0;">
                            Instructor reviewed <strong>Shantanu's</strong> Penetration Testing report
                        </p>
                        <span style="font-size: 0.72rem; color: #7a8d80;">2 minutes ago</span>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
