<?php
$pct = (float)($stats['percentage'] ?? 0);
$presentCount = (int)($stats['present'] ?? 0);
$absentCount = (int)($stats['absent'] ?? 0);
$lateCount = (int)($stats['late'] ?? 0);
$totalCount = (int)($stats['total'] ?? 0);
$currentFilter = $filter ?? 'all';
?>

<div style="display: flex; flex-direction: column; gap: 24px;">
    <!-- Attendance Summary Gauge Card -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px;">
        <div style="max-width: 580px;">
            <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #047857; font-family: monospace;">
                ATTENDANCE SUMMARY
            </span>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-top: 4px; margin-bottom: 6px;">Class Attendance & Session Archives</h2>
            <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5;">Minimum 75% attendance is required for semester examinations and capstone defense eligibility.</p>
        </div>

        <div style="display: flex; align-items: center; gap: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px;">
            <div style="width: 80px; height: 80px; border-radius: 50%; border: 4px solid #10b981; background: #ffffff; display: flex; flex-direction: column; align-items: center; justify-content: center; font-weight: 800; color: #0f172a; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.15);">
                <span style="font-size: 1.25rem; font-family: monospace; line-height: 1.1;"><?= $pct ?>%</span>
                <span style="font-size: 9px; text-transform: uppercase; color: #94a3b8; font-weight: 700;">Present</span>
            </div>
            <div style="font-size: 0.8rem; line-height: 1.8;">
                <div style="display: flex; justify-content: space-between; gap: 16px;">
                    <span style="color: #64748b;">Present:</span>
                    <strong style="color: #047857; font-family: monospace;"><?= $presentCount ?> Days</strong>
                </div>
                <div style="display: flex; justify-content: space-between; gap: 16px;">
                    <span style="color: #64748b;">Absent:</span>
                    <strong style="color: #b91c1c; font-family: monospace;"><?= $absentCount ?> Days</strong>
                </div>
                <div style="display: flex; justify-content: space-between; gap: 16px;">
                    <span style="color: #64748b;">Late / Excused:</span>
                    <strong style="color: #b45309; font-family: monospace;"><?= $lateCount ?> Days</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline & Session Archives List -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <!-- Timeline Filter Header -->
        <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; background: #f8fafc; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #0f172a; letter-spacing: 0.5px;">
                Session Timeline Log (<?= count($records) ?> Records)
            </div>
            <div style="display: flex; gap: 4px; background: #e2e8f0; padding: 4px; border-radius: 8px;">
                <?php foreach (['all' => 'All', 'present' => 'Present', 'absent' => 'Absent', 'late' => 'Late', 'excused' => 'Excused'] as $fKey => $fLabel): ?>
                    <a href="/student/attendance?filter=<?= $fKey ?>" style="padding: 4px 10px; font-size: 0.75rem; font-weight: 700; border-radius: 6px; text-decoration: none; transition: all 0.2s; <?= $currentFilter === $fKey ? 'background:#ffffff; color:#0f172a; box-shadow:0 1px 3px rgba(0,0,0,0.1);' : 'color:#64748b;' ?>">
                        <?= $fLabel ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sessions List -->
        <?php if (empty($records)): ?>
            <div style="padding: 48px 20px; text-align: center;">
                <p style="font-size: 0.95rem; font-weight: 700; color: #334155;">No attendance sessions found</p>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">Session archives matching the selected filter will appear here once marked by faculty.</p>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column;">
                <?php foreach ($records as $sess): ?>
                    <div style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#ffffff'">
                        <div style="display: flex; align-items: flex-start; gap: 16px;">
                            <!-- Date Badge -->
                            <div style="width: 54px; padding: 6px 4px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 10px; text-align: center; font-family: monospace;">
                                <span style="font-size: 0.65rem; color: #64748b; font-weight: 700; text-transform: uppercase; display: block;"><?= date('M', strtotime($sess['date'])) ?></span>
                                <span style="font-size: 1.15rem; font-weight: 800; color: #0f172a; line-height: 1.2; display: block;"><?= date('d', strtotime($sess['date'])) ?></span>
                            </div>

                            <!-- Session Details -->
                            <div>
                                <span class="status-pill status-<?= htmlspecialchars($sess['status']) ?>" style="font-size: 0.7rem; font-weight: 800;">
                                    <?= strtoupper($sess['status']) ?>
                                </span>
                                <h4 style="font-size: 0.925rem; font-weight: 700; color: #0f172a; margin: 4px 0 2px 0;">
                                    <?= htmlspecialchars($sess['subject_name'] ?? 'Class Session') ?> (<code><?= htmlspecialchars($sess['subject_code'] ?? '') ?></code>)
                                </h4>
                                <p style="font-size: 0.78rem; color: #64748b; font-family: monospace;">
                                    Class: <?= htmlspecialchars($sess['class_name'] . ' (Div ' . $sess['division'] . ')') ?> · Faculty: <?= htmlspecialchars($sess['faculty_name'] ?? 'Assigned Instructor') ?>
                                </p>
                            </div>
                        </div>

                        <!-- Action / Archive Replay pill -->
                        <div>
                            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background: #0f172a; color: #ffffff; border-radius: 8px; font-size: 0.75rem; font-weight: 700; text-decoration: none;">
                                📹 Session Archive
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
