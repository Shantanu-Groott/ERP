<div class="card-grid">
    <div class="stat-card">
        <span class="label">Total Score</span>
        <span class="value"><?= $totalObtained ?> / <?= $totalMax ?></span>
    </div>
    <div class="stat-card">
        <span class="label">Aggregate Grade</span>
        <span class="value" style="color: var(--primary);">
            <?= $overallPercentage >= 80 ? 'Grade A' : ($overallPercentage >= 60 ? 'Grade B' : 'Grade C') ?>
        </span>
    </div>
    <div class="stat-card">
        <span class="label">Overall Percentage</span>
        <span class="value" style="color: var(--success);"><?= $overallPercentage ?>%</span>
    </div>
    <div class="stat-card">
        <span class="label">Exams Completed</span>
        <span class="value"><?= count($marks) ?></span>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Academic Examination Transcript</h4>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Examination</th>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Score Obtained</th>
                    <th>Max Marks</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($marks)): ?>
                    <tr><td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">No exam marks published yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($marks as $m): ?>
                        <?php $pct = round(((float)$m['marks_obtained'] / ((float)$m['max_marks'] ?: 100)) * 100, 1); ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($m['exam_name']) ?></strong></td>
                            <td><code><?= htmlspecialchars($m['subject_code']) ?></code></td>
                            <td><?= htmlspecialchars($m['subject_name']) ?></td>
                            <td><?= (float)$m['marks_obtained'] ?></td>
                            <td><?= (float)$m['max_marks'] ?></td>
                            <td><span class="status-pill status-present"><?= $pct ?>%</span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
