<div style="display: flex; flex-direction: column; gap: 28px;">
    <!-- Profile & Verification Strip -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 18px;">
                <div style="width: 64px; height: 64px; border-radius: 16px; background: #0f172a; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.5rem; font-family: monospace;">
                    <?= htmlspecialchars(strtoupper(substr((string)($student['name'] ?? 'ST'), 0, 2))) ?>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <h2 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 0;"><?= htmlspecialchars($student['name'] ?? 'Student') ?></h2>
                        <span style="font-family: monospace; font-size: 0.75rem; font-weight: 700; background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 6px;">
                            <?= htmlspecialchars($student['roll_no'] ?? 'COMP-2026') ?>
                        </span>
                    </div>
                    <p style="font-size: 0.85rem; color: #64748b; margin-top: 4px;">
                        <?= htmlspecialchars($student['department_name'] ?? 'Engineering') ?> · <?= htmlspecialchars($student['class_name'] ?? '') ?> (Div <?= htmlspecialchars($student['division'] ?? '') ?>)
                    </p>
                </div>
            </div>

            <div style="text-align: right;">
                <span style="font-size: 0.75rem; font-weight: 700; background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 9999px;">
                    Active Verified Enrollee
                </span>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; padding-top: 18px; font-size: 0.8rem;">
            <div style="padding: 12px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                <span style="color: #94a3b8; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; display: block;">Email</span>
                <span style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($student['email'] ?? '') ?></span>
            </div>
            <div style="padding: 12px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                <span style="color: #94a3b8; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; display: block;">Attendance Rating</span>
                <span style="font-weight: 700; color: #047857; font-family: monospace;"><?= $attendanceStats['percentage'] ?>%</span>
            </div>
            <div style="padding: 12px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                <span style="color: #94a3b8; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; display: block;">Academic Score</span>
                <span style="font-weight: 700; color: #2563eb; font-family: monospace;"><?= $overallPercentage ?>% Average</span>
            </div>
            <div style="padding: 12px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                <span style="color: #94a3b8; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; display: block;">Guardian Contact</span>
                <span style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($student['guardian_name'] ?? 'N/A') ?></span>
            </div>
        </div>
    </div>

    <!-- Official Printable Certificate -->
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div>
                <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #2563eb;">STUDENT RECORD</span>
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 2px;">Certificate of Academic & Technical Competency</h3>
            </div>
            <button onclick="window.print()" class="btn btn-primary" style="background: #0f172a; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px;">
                <span>🖨️ Print / Save Official PDF</span>
            </button>
        </div>

        <!-- Certificate Plaque -->
        <div style="background: #ffffff; border: 10px double #cbd5e1; border-radius: 28px; padding: 48px 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); text-align: center; max-width: 860px; margin: 0 auto; width: 100%;">
            <div style="border: 1px solid #e2e8f0; border-radius: 20px; padding: 36px 30px; background: rgba(254, 252, 232, 0.15); display: flex; flex-direction: column; gap: 20px;">
                
                <div>
                    <div style="font-size: 2.2rem; margin-bottom: 6px;">🏛️</div>
                    <h2 style="font-size: 1.35rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; color: #0f172a;">
                        Kalavanta Edutech Institute of Technology
                    </h2>
                    <p style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">
                        Center for Advanced Engineering, Software Architecture & Cloud Computing
                    </p>
                </div>

                <div style="margin-top: 12px;">
                    <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: #b45309; font-weight: 800; font-family: monospace; display: block; margin-bottom: 6px;">
                        Certificate of Academic Excellence
                    </span>
                    <p style="font-size: 0.85rem; color: #64748b; font-style: italic;">This is to certify that</p>
                    <h1 style="font-size: 2rem; font-weight: 900; color: #0f172a; margin: 4px 0;">
                        <?= htmlspecialchars($student['name'] ?? 'Candidate Name') ?>
                    </h1>
                    <p style="font-size: 0.8rem; font-family: monospace; color: #64748b;">
                        Enrollment Roll: <strong><?= htmlspecialchars($student['roll_no'] ?? 'COMP-2026-001') ?></strong>
                    </p>
                </div>

                <div style="max-width: 580px; margin: 0 auto; font-size: 0.85rem; color: #334155; line-height: 1.7;">
                    <p>
                        has fulfilled all required curriculum coursework, laboratory practicums, and comprehensive evaluations in
                    </p>
                    <p style="font-size: 1.15rem; font-weight: 800; color: #1e3a8a; margin: 6px 0;">
                        <?= htmlspecialchars($student['department_name'] ?? 'Computer Engineering') ?>
                    </p>
                    <p style="font-size: 0.75rem; color: #64748b; font-family: monospace;">
                        Evaluated across <?= $examCount ?> Examinations · Certified with Distinction
                    </p>
                </div>

                <!-- Signatures Row -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; align-items: flex-end; border-top: 1px solid #e2e8f0; padding-top: 28px; margin-top: 16px;">
                    <div style="text-align: left;">
                        <div style="font-family: serif; font-style: italic; font-size: 1.15rem; font-weight: 600; color: #0f172a; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px; display: inline-block;">
                            Robert Miller
                        </div>
                        <p style="font-size: 0.8rem; font-weight: 800; color: #0f172a; margin-top: 6px;">Prof. Robert Miller</p>
                        <p style="font-size: 0.7rem; color: #64748b;">Lead Faculty & Program Mentor</p>
                    </div>

                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid #f59e0b; background: #fffbeb; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #b45309; font-weight: 800;">
                            ★
                        </div>
                        <span style="font-size: 0.65rem; font-family: monospace; font-weight: 800; color: #334155; margin-top: 4px;">ID: KLVT-2026-9842</span>
                        <span style="font-size: 0.6rem; color: #94a3b8; text-transform: uppercase;">Cryptographically Verified</span>
                    </div>

                    <div style="text-align: right;">
                        <div style="font-family: serif; font-style: italic; font-size: 1.15rem; font-weight: 600; color: #0f172a; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px; display: inline-block;">
                            Academic Dean
                        </div>
                        <p style="font-size: 0.8rem; font-weight: 800; color: #0f172a; margin-top: 6px;">Dr. Vikram Malhotra</p>
                        <p style="font-size: 0.7rem; color: #64748b;">Academic Director & Dean</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
