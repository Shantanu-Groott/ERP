<div style="display: flex; flex-direction: column; gap: 32px;">
    
    <!-- Top Row: Quick Stats & Green Student Hub Banner -->
    <div style="display: flex; justify-content: space-between; align-items: stretch; gap: 24px; flex-wrap: wrap;">
        
        <!-- Left: Quick Stats Cards (Matching Theme Cards) -->
        <div style="flex: 1; min-width: 320px;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e2d24; margin-bottom: 14px;">Quick Stats</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 14px;">
                
                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #627467; margin-bottom: 6px;">Total Diagrams</div>
                    <div style="font-size: 1.85rem; font-weight: 700; color: #183324; line-height: 1;">
                        <?= count($subjects) > 0 ? (count($subjects) * 3 + 2) : 14 ?>
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #627467; margin-bottom: 6px;">Last Activity</div>
                    <div style="font-size: 1.35rem; font-weight: 700; color: #183324; line-height: 1.3;">
                        2 hours ago
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #627467; margin-bottom: 6px;">Collaborators</div>
                    <div style="font-size: 1.85rem; font-weight: 700; color: #183324; line-height: 1;">
                        3
                    </div>
                </div>

            </div>
        </div>

        <!-- Right: Student Hub Promo Banner Card (Exact Theme Copy) -->
        <div style="width: 100%; max-width: 380px; background: #cce3d4 url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' opacity=\'0.15\' viewBox=\'0 0 100 100\'><path d=\'M20 20 L80 20 L80 80 L20 80 Z\' fill=\'none\' stroke=\'%231b4332\' stroke-width=\'2\'/><path d=\'M30 40 L70 40 M30 50 L70 50 M30 60 L60 60\' stroke=\'%231b4332\' stroke-width=\'2\'/></svg>') repeat; border-radius: 20px; padding: 22px 24px; display: flex; flex-direction: column; justify-content: space-between; position: relative; border: 1px solid #b5d5bf; box-shadow: 0 2px 8px rgba(33, 75, 52, 0.06);">
            <div>
                <h4 style="font-size: 1.15rem; font-weight: 800; color: #153e28; margin-bottom: 6px;">Student Hub</h4>
                <p style="font-size: 0.8rem; color: #234f36; line-height: 1.5; max-width: 260px;">
                    Join the upcoming workshop on Database Design & Relational Modeling.
                </p>
            </div>
            <div style="margin-top: 18px;">
                <a href="/student/live-class" style="display: inline-block; background: #1c4b32; color: #ffffff; padding: 9px 20px; border-radius: 12px; font-size: 0.82rem; font-weight: 700; text-decoration: none; box-shadow: 0 2px 6px rgba(28, 75, 50, 0.3); transition: background 0.15s;" onmouseover="this.style.background='#133724'" onmouseout="this.style.background='#1c4b32'">
                    Upgrade to Pro
                </a>
            </div>
        </div>

    </div>

    <!-- Section 2: Recent Diagrams (ERD / Schematic Cards Row) -->
    <div>
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e2d24; margin-bottom: 16px;">Recent Diagrams</h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 16px;">
            
            <!-- Diagram Card 1 -->
            <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                <div style="background: #f1f7f2; border: 1px solid #dde8df; border-radius: 12px; height: 145px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; padding: 10px;">
                    <!-- Stylized Mini ERD Mockup -->
                    <svg width="100%" height="100%" viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="45" width="45" height="40" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="75" y="10" width="50" height="50" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="75" y="70" width="50" height="50" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="145" y="45" width="45" height="40" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <path d="M55 65 H75 M125 35 H145 M125 95 H145" stroke="#3d7e5d" stroke-width="1.5" stroke-dasharray="2 2"/>
                        <circle cx="75" cy="65" r="2" fill="#3d7e5d"/>
                        <circle cx="125" cy="35" r="2" fill="#3d7e5d"/>
                        <circle cx="125" cy="95" r="2" fill="#3d7e5d"/>
                    </svg>
                </div>
                <div style="margin-top: 12px; display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <h4 style="font-size: 0.88rem; font-weight: 700; color: #183324; margin-bottom: 2px;">Library Management System</h4>
                        <span style="font-size: 0.72rem; color: #7a8d80;">Last edited... 3 hours ago</span>
                    </div>
                    <span style="color: #92a498; font-size: 1rem; cursor: pointer;">•••</span>
                </div>
            </div>

            <!-- Diagram Card 2 -->
            <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                <div style="background: #f1f7f2; border: 1px solid #dde8df; border-radius: 12px; height: 145px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; padding: 10px;">
                    <svg width="100%" height="100%" viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="20" y="25" width="48" height="45" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="76" y="40" width="48" height="50" rx="4" fill="#e8f3ec" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="132" y="25" width="48" height="45" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <path d="M68 47 H76 M124 65 H132 M100 90 V105" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="80" y="105" width="40" height="20" rx="3" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.2"/>
                    </svg>
                </div>
                <div style="margin-top: 12px; display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <h4 style="font-size: 0.88rem; font-weight: 700; color: #183324; margin-bottom: 2px;">E-Commerce Database - Final</h4>
                        <span style="font-size: 0.72rem; color: #7a8d80;">Last edited... 3 hours ago</span>
                    </div>
                    <span style="color: #92a498; font-size: 1rem; cursor: pointer;">•••</span>
                </div>
            </div>

            <!-- Diagram Card 3 -->
            <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                <div style="background: #f1f7f2; border: 1px solid #dde8df; border-radius: 12px; height: 145px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; padding: 10px;">
                    <svg width="100%" height="100%" viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="75" y="12" width="50" height="35" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="75" y="82" width="50" height="35" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="18" y="48" width="46" height="35" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="136" y="48" width="46" height="35" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <path d="M100 47 V82 M64 65 H136" stroke="#3d7e5d" stroke-width="1.5"/>
                    </svg>
                </div>
                <div style="margin-top: 12px; display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <h4 style="font-size: 0.88rem; font-weight: 700; color: #183324; margin-bottom: 2px;">Recipe App DB</h4>
                        <span style="font-size: 0.72rem; color: #7a8d80;">Last edited... 3 hours ago</span>
                    </div>
                    <span style="color: #92a498; font-size: 1rem; cursor: pointer;">•••</span>
                </div>
            </div>

            <!-- Diagram Card 4 -->
            <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 18px; padding: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                <div style="background: #f1f7f2; border: 1px solid #dde8df; border-radius: 12px; height: 145px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; padding: 10px;">
                    <svg width="100%" height="100%" viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="15" y="30" width="46" height="65" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="77" y="15" width="46" height="40" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="77" y="75" width="46" height="40" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <rect x="139" y="30" width="46" height="65" rx="4" fill="#ffffff" stroke="#3d7e5d" stroke-width="1.5"/>
                        <path d="M61 50 H77 M123 35 H139 M123 95 H139" stroke="#3d7e5d" stroke-width="1.5"/>
                    </svg>
                </div>
                <div style="margin-top: 12px; display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <h4 style="font-size: 0.88rem; font-weight: 700; color: #183324; margin-bottom: 2px;">Student Enrollment System</h4>
                        <span style="font-size: 0.72rem; color: #7a8d80;">Last edited... 3 hours ago</span>
                    </div>
                    <span style="color: #92a498; font-size: 1rem; cursor: pointer;">•••</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Row: Learn & Practice vs Recent Activity -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
        
        <!-- Learn & Practice / Recommended Tutorials -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e2d24;">Learn & Practice</h3>
                <div style="display: flex; gap: 8px;">
                    <span style="cursor: pointer; color: #7b8f80; font-size: 0.9rem;">&lt;</span>
                    <span style="cursor: pointer; color: #7b8f80; font-size: 0.9rem;">&gt;</span>
                </div>
            </div>
            
            <div style="font-size: 0.8rem; font-weight: 600; color: #627467; margin-bottom: 10px;">Recommended Tutorials</div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;">
                
                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 14px; display: flex; align-items: center; gap: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); cursor: pointer;" onclick="window.location='/student/curriculum'">
                    <div style="width: 48px; height: 48px; border-radius: 10px; background: #3d7e5d; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        ⚏
                    </div>
                    <div>
                        <h5 style="font-size: 0.85rem; font-weight: 700; color: #183324; line-height: 1.3;">Mastering Crow's Foot Notation ↗</h5>
                        <span style="font-size: 0.72rem; color: #7a8d80;">Interactive Guide</span>
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 14px; display: flex; align-items: center; gap: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); cursor: pointer;" onclick="window.location='/student/curriculum'">
                    <div style="width: 48px; height: 48px; border-radius: 10px; background: #3d7e5d; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        ▦
                    </div>
                    <div>
                        <h5 style="font-size: 0.85rem; font-weight: 700; color: #183324; line-height: 1.3;">3NF Normalization Basics ↗</h5>
                        <span style="font-size: 0.72rem; color: #7a8d80;">Video Lecture</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Recent Activity Feed -->
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
                            You edited <strong>"Library Management"</strong>
                        </p>
                        <span style="font-size: 0.72rem; color: #7a8d80;">1 hours ago</span>
                    </div>
                </div>

                <!-- Activity Item 2 -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #235439; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                        AJ
                    </div>
                    <div>
                        <p style="font-size: 0.84rem; font-weight: 600; color: #183324; margin: 0;">
                            <strong>Alex</strong> commented on "E-Commerce Database"
                        </p>
                        <span style="font-size: 0.72rem; color: #7a8d80;">2 minutes ago</span>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
