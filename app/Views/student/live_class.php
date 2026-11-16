<div style="display: flex; flex-direction: column; gap: 28px;">

    <!-- Dashboard Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                <span style="background: #e2ede5; color: #1c4b32; font-size: 0.72rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; padding: 3px 10px; border-radius: 6px; border: 1px solid #cce0d2;">
                    EXTERNAL STREAMING ENGINE
                </span>
                <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #2d6a4f; font-weight: 700;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #16a34a; box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.2);"></span>
                    Engine Gateway Active
                </span>
            </div>
            <h2 style="font-size: 1.45rem; font-weight: 800; color: #153e28; margin: 0 0 4px 0;">
                Live Class Dashboard
            </h2>
            <p style="font-size: 0.85rem; color: #627467; margin: 0; max-width: 650px;">
                Direct launchpad for real-time virtual classrooms and hands-on defense labs powered by our high-performance streaming engine.
            </p>
        </div>

        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="/student/dashboard" style="background: #ffffff; color: #2d6a4f; border: 1px solid #cfe0d4; padding: 9px 18px; border-radius: 12px; font-size: 0.82rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                &larr; Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Active Live Session Card (Hero) -->
    <?php if ($activeSession): ?>
        <div style="background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 100%); border-radius: 20px; padding: 28px 32px; color: #ffffff; box-shadow: 0 10px 25px rgba(27, 67, 50, 0.18); position: relative; overflow: hidden; border: 1px solid #408a67;">
            <!-- Background Glow Decor -->
            <div style="position: absolute; right: -40px; top: -40px; width: 220px; height: 220px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0) 70%); pointer-events: none;"></div>

            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px; position: relative; z-index: 1;">
                <div style="max-width: 680px;">
                    <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(239, 68, 68, 0.22); border: 1px solid rgba(239, 68, 68, 0.4); padding: 4px 14px; border-radius: 9999px; font-size: 0.75rem; font-weight: 800; letter-spacing: 1px; color: #fecaca; margin-bottom: 14px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444; box-shadow: 0 0 8px #ef4444; animation: pulse 1.5s infinite;"></span>
                        LIVE CLASSROOM IN SESSION
                    </div>

                    <h3 style="font-size: 1.5rem; font-weight: 800; color: #ffffff; margin: 0 0 10px 0; line-height: 1.3;">
                        <?= htmlspecialchars($activeSession['title']) ?>
                    </h3>

                    <p style="font-size: 0.88rem; color: #d8f3dc; line-height: 1.55; margin-bottom: 18px;">
                        <?= htmlspecialchars($activeSession['description'] ?? 'Real-time interactive session with live screen casting and sandbox evaluation.') ?>
                    </p>

                    <div style="display: flex; flex-wrap: wrap; gap: 18px; font-size: 0.8rem; color: #b7e4c7; margin-bottom: 22px;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span>👨‍🏫</span>
                            <span>Presenter: <strong><?= htmlspecialchars($activeSession['presenter_name']) ?></strong></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span>🏷️</span>
                            <span>Room Code: <strong style="font-family: monospace; background: rgba(0,0,0,0.25); padding: 2px 8px; border-radius: 6px;"><?= htmlspecialchars($activeSession['room_code']) ?></strong></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span>⏱️</span>
                            <span>Duration: <strong><?= (int)$activeSession['duration_minutes'] ?> mins</strong></span>
                        </div>
                    </div>

                    <?php if (!empty($activeSession['prerequisites'])): ?>
                        <div style="background: rgba(0, 0, 0, 0.22); border-left: 3px solid #74c69d; padding: 10px 14px; border-radius: 0 8px 8px 0; font-size: 0.78rem; color: #d8f3dc; margin-bottom: 24px;">
                            <strong>Prerequisites:</strong> <?= htmlspecialchars($activeSession['prerequisites']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Action: Launch Engine Button -->
                    <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                        <a href="<?= htmlspecialchars($activeSession['meeting_url']) ?>" target="_blank" rel="noopener noreferrer" style="background: #ffffff; color: #1b4332; padding: 13px 28px; border-radius: 12px; font-weight: 800; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.25); transition: transform 0.15s, background 0.15s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.background='#f0fdf4';" onmouseout="this.style.transform='none'; this.style.background='#ffffff';">
                            <span>🚀 Join Live Class (Launch Engine)</span>
                            <span style="font-size: 1.1rem;">&rarr;</span>
                        </a>

                        <button type="button" onclick="navigator.clipboard.writeText('<?= htmlspecialchars($activeSession['meeting_url']) ?>'); alert('Direct meeting engine link copied to clipboard!');" style="background: rgba(255,255,255,0.12); color: #ffffff; border: 1px solid rgba(255,255,255,0.25); padding: 12px 18px; border-radius: 12px; font-size: 0.82rem; font-weight: 700; cursor: pointer; transition: background 0.15s;">
                            📋 Copy Link
                        </button>
                    </div>
                </div>

                <!-- Right Quick Spec Box -->
                <div style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 16px; padding: 20px; min-width: 240px;">
                    <div style="font-size: 0.72rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: #95d5b2; margin-bottom: 12px;">
                        Engine Telemetry
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 0.78rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #d8f3dc;">Cluster Node:</span>
                            <strong style="color: #ffffff; font-family: monospace;">Hostinger-AP-01</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #d8f3dc;">Latency:</span>
                            <strong style="color: #4ade80; font-family: monospace;">~34 ms</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #d8f3dc;">Audio Codec:</span>
                            <strong style="color: #ffffff; font-family: monospace;">Opus 48kHz</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #d8f3dc;">Video Resolution:</span>
                            <strong style="color: #ffffff; font-family: monospace;">1080p60 WebRTC</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 20px; padding: 32px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="font-size: 2.5rem; margin-bottom: 10px;">☕</div>
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #183324; margin-bottom: 6px;">No Live Class in Session Right Now</h3>
            <p style="font-size: 0.85rem; color: #7a8d80; margin: 0 auto; max-width: 480px;">
                Check the schedule below for upcoming lectures and lab walkthroughs. When an instructor goes live, the join launchpad will appear here instantly.
            </p>
        </div>
    <?php endif; ?>

    <!-- Two Column Layout: Upcoming Classes & Past Recordings -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">

        <!-- Upcoming Live Classes -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e2d24; margin: 0;">
                    Scheduled Live Classes
                </h3>
                <span style="font-size: 0.75rem; color: #627467; font-weight: 600;">
                    <?= count($upcomingSessions) ?> Upcoming
                </span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                <?php if (empty($upcomingSessions)): ?>
                    <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 24px; text-align: center; color: #7a8d80; font-size: 0.85rem;">
                        No upcoming live sessions scheduled for this week.
                    </div>
                <?php else: ?>
                    <?php foreach ($upcomingSessions as $session): ?>
                        <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 8px;">
                                <div>
                                    <span style="font-family: monospace; font-size: 0.72rem; font-weight: 800; background: #e8f3ec; color: #235439; padding: 2px 8px; border-radius: 6px;">
                                        <?= htmlspecialchars($session['subject_code'] ?? 'LIVE') ?>
                                    </span>
                                    <h4 style="font-size: 0.95rem; font-weight: 700; color: #183324; margin: 8px 0 4px 0;">
                                        <?= htmlspecialchars($session['title']) ?>
                                    </h4>
                                </div>
                                <span style="font-size: 0.72rem; font-weight: 700; background: #f1f5f9; color: #475569; padding: 3px 10px; border-radius: 9999px; white-space: nowrap;">
                                    Scheduled
                                </span>
                            </div>

                            <p style="font-size: 0.8rem; color: #627467; margin: 0 0 12px 0; line-height: 1.45;">
                                <?= htmlspecialchars($session['description'] ?? '') ?>
                            </p>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0f4f1; padding-top: 10px; font-size: 0.75rem; color: #7a8d80;">
                                <span>📅 <?= date('M d, Y · h:i A', strtotime($session['scheduled_at'])) ?> (<?= (int)$session['duration_minutes'] ?>m)</span>
                                <a href="<?= htmlspecialchars($session['meeting_url']) ?>" target="_blank" rel="noopener noreferrer" style="color: #2d6a4f; font-weight: 700; text-decoration: none;">
                                    Engine Link ↗
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Past Session Archives -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e2d24; margin: 0;">
                    Past Sessions & Lab Archives
                </h3>
                <span style="font-size: 0.75rem; color: #627467; font-weight: 600;">
                    <?= count($pastSessions) ?> Recorded
                </span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                <?php if (empty($pastSessions)): ?>
                    <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 24px; text-align: center; color: #7a8d80; font-size: 0.85rem;">
                        No previous session recordings found.
                    </div>
                <?php else: ?>
                    <?php foreach ($pastSessions as $session): ?>
                        <div style="background: #ffffff; border: 1px solid #d8e2d8; border-radius: 16px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 6px;">
                                <h4 style="font-size: 0.92rem; font-weight: 700; color: #183324; margin: 0;">
                                    <?= htmlspecialchars($session['title']) ?>
                                </h4>
                                <span style="font-size: 0.72rem; font-weight: 700; background: #ecfdf5; color: #047857; padding: 3px 8px; border-radius: 6px;">
                                    Completed
                                </span>
                            </div>

                            <p style="font-size: 0.78rem; color: #627467; margin: 0 0 10px 0;">
                                <?= htmlspecialchars($session['description'] ?? '') ?>
                            </p>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0f4f1; padding-top: 10px; font-size: 0.75rem; color: #7a8d80;">
                                <span>Presented by: <strong><?= htmlspecialchars($session['presenter_name']) ?></strong></span>
                                <a href="<?= htmlspecialchars($session['meeting_url']) ?>" target="_blank" rel="noopener noreferrer" style="color: #2d6a4f; font-weight: 700; text-decoration: none;">
                                    View Recording & Notes ↗
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- Engine Protocol & Diagnostics Banner -->
    <div style="background: #f1f7f3; border: 1px solid #d5e5d8; border-radius: 16px; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: #2d6a4f; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                ⚙️
            </div>
            <div>
                <h5 style="font-size: 0.85rem; font-weight: 700; color: #153e28; margin: 0 0 2px 0;">Dedicated Streaming Engine</h5>
                <p style="font-size: 0.74rem; color: #627467; margin: 0;">
                    Live sessions execute on our isolated cloud streaming infrastructure to protect campus bandwidth.
                </p>
            </div>
        </div>
        <div style="display: flex; gap: 16px; font-size: 0.74rem; color: #235439; font-weight: 700;">
            <span>✓ WebRTC Compatible</span>
            <span>✓ Low Latency Stream</span>
            <span>✓ End-to-End Encrypted</span>
        </div>
    </div>

</div>
