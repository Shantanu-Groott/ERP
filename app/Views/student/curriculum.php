<div style="display: flex; flex-direction: column; gap: 24px;">
    <!-- Course Header Banner -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 24px;">
        <div style="max-width: 650px;">
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.75rem; color: #64748b; font-weight: 600; margin-bottom: 6px;">
                <span style="background: #f1f5f9; color: #334155; font-family: monospace; font-weight: 700; padding: 2px 8px; border-radius: 6px;">
                    <?= htmlspecialchars($student['department_code'] ?? 'TECH') ?>
                </span>
                <span>·</span>
                <span><?= htmlspecialchars($student['class_name'] ?? 'Class') ?> (Div <?= htmlspecialchars($student['division'] ?? 'A') ?>)</span>
                <span>·</span>
                <span>Batch 2026-27</span>
            </div>

            <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #2563eb;">CURRICULUM ARCHITECTURE</span>
            <h1 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin-top: 4px; margin-bottom: 8px;">
                <?= htmlspecialchars($student['department_name'] ?? 'Computer Engineering') ?>
            </h1>

            <p style="font-size: 0.85rem; color: #64748b; line-height: 1.6;">
                Hands-on technical engineering curriculum covering deep packet forensics, database architectures, enterprise software, and container hardening.
            </p>

            <div style="display: flex; flex-wrap: wrap; gap: 16px; margin-top: 12px; font-size: 0.75rem; color: #64748b; font-family: monospace;">
                <span>Total Subjects: <strong><?= count($subjects) ?> Modules</strong></span>
                <span>·</span>
                <span>Enrolled Class: <strong><?= htmlspecialchars($student['class_name'] ?? 'Class') ?></strong></span>
                <span>·</span>
                <span>Roll No: <strong><?= htmlspecialchars($student['roll_no'] ?? 'N/A') ?></strong></span>
            </div>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; display: flex; align-items: center; gap: 14px; min-width: 260px;">
            <div style="width: 48px; height: 48px; border-radius: 50%; background: #0f172a; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; font-family: monospace;">
                FAC
            </div>
            <div>
                <span style="font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; display: block;">Department Chair</span>
                <p style="font-size: 0.9rem; font-weight: 800; color: #0f172a; margin: 2px 0;">Prof. Robert Miller</p>
                <p style="font-size: 0.75rem; color: #64748b;">Associate Professor & Lead Mentor</p>
            </div>
        </div>
    </div>

    <!-- Modules List -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <?php foreach ($subjects as $idx => $sub): ?>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
                <!-- Module Header -->
                <div style="padding: 18px 24px; background: #f8fafc; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-family: monospace; font-size: 0.75rem; font-weight: 800; background: #e2e8f0; color: #334155; padding: 2px 8px; border-radius: 6px;">
                                <?= htmlspecialchars($sub['code']) ?>
                            </span>
                            <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                                <?= htmlspecialchars($sub['name']) ?>
                            </h3>
                        </div>
                        <p style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
                            Credits: <?= (int)$sub['credits'] ?> Credit Hours · Lead Faculty: <?= htmlspecialchars($sub['instructor_name'] ?? 'Faculty Staff') ?>
                        </p>
                    </div>

                    <div>
                        <span style="font-family: monospace; font-size: 0.75rem; font-weight: 800; color: #047857; background: #dcfce7; padding: 4px 10px; border-radius: 6px;">
                            Active Semester Course
                        </span>
                    </div>
                </div>

                <!-- Lessons & Syllabus Breakdown -->
                <div style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
                    <div style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #ffffff;">
                        <div style="padding: 12px 16px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="color: #10b981; font-weight: 800; font-size: 1rem;">☑</span>
                                <div>
                                    <h4 style="font-size: 0.85rem; font-weight: 700; color: #0f172a;">Core Theory & Architectural Frameworks</h4>
                                    <span style="font-size: 0.75rem; font-family: monospace; color: #94a3b8;">Lectures 01 - 12 (Completed)</span>
                                </div>
                            </div>
                            <span style="font-size: 0.75rem; color: #64748b; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-weight: 600;">
                                ⬇ Lecture Notes
                            </span>
                        </div>

                        <div style="padding: 12px 16px; display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="color: #cbd5e1; font-weight: 800; font-size: 1rem;">☐</span>
                                <div>
                                    <h4 style="font-size: 0.85rem; font-weight: 700; color: #0f172a;">Hands-on Laboratory Simulation & Practical Audit</h4>
                                    <span style="font-size: 0.75rem; font-family: monospace; color: #94a3b8;">Labs 01 - 06 (In Progress)</span>
                                </div>
                            </div>
                            <span style="font-size: 0.75rem; color: #64748b; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-weight: 600;">
                                ⬇ Lab Manual
                            </span>
                        </div>
                    </div>

                    <!-- Module Quiz & Lab Submission Cards -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; gap: 12px;">
                            <div>
                                <span style="font-size: 9px; font-weight: 800; text-transform: uppercase; color: #7e22ce; background: #f3e8ff; padding: 2px 8px; border-radius: 4px; font-family: monospace;">MODULE QUIZ</span>
                                <h4 style="font-size: 0.88rem; font-weight: 800; color: #0f172a; margin-top: 6px;">Continuous Assessment Quiz</h4>
                                <p style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">Automated evaluation rubric for chapter checkpoints.</p>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" style="width: 100%;" onclick="alert('Module Quiz portal is open for active session.');">
                                Take Module Quiz (Instant Grade)
                            </button>
                        </div>

                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; gap: 12px;">
                            <div>
                                <span style="font-size: 9px; font-weight: 800; text-transform: uppercase; color: #1d4ed8; background: #dbeafe; padding: 2px 8px; border-radius: 4px; font-family: monospace;">LAB ASSIGNMENT</span>
                                <h4 style="font-size: 0.88rem; font-weight: 800; color: #0f172a; margin-top: 6px;">Laboratory Deliverable</h4>
                                <p style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">Submit code deliverables and technical reports.</p>
                            </div>
                            <a href="/student/results" class="btn btn-sm" style="width: 100%; text-align: center; background: #0f172a; color: #ffffff;">
                                View Academic Scores &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
