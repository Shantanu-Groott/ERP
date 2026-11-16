<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Record Marks / Grades</h4>
    </div>
    <form action="/teacher/marks" method="POST">
        <?= \App\Core\View::csrfField() ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div class="form-group">
                <label>Examination</label>
                <select name="exam_id" class="form-control" required>
                    <?php foreach ($exams as $ex): ?>
                        <option value="<?= $ex['id'] ?>" <?= $selectedExam == $ex['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($ex['name']) ?> (<?= htmlspecialchars($ex['exam_date'] ?? 'N/A') ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Subject</label>
                <select name="subject_id" class="form-control" required>
                    <?php foreach ($subjects as $sb): ?>
                        <option value="<?= $sb['id'] ?>" <?= $selectedSubject == $sb['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sb['code'] . ' - ' . $sb['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Student</label>
                <select name="student_id" class="form-control" required>
                    <option value="">-- Choose Student --</option>
                    <?php foreach ($students as $st): ?>
                        <option value="<?= $st['id'] ?>">
                            <?= htmlspecialchars($st['name'] . ' (' . $st['roll_no'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Marks Obtained</label>
                <input type="number" step="0.5" name="marks_obtained" class="form-control" placeholder="85.5" required>
            </div>
            <div class="form-group">
                <label>Max Marks</label>
                <input type="number" step="1" name="max_marks" class="form-control" value="100">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Submit Grades</button>
    </form>
</div>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Published Scores by Exam & Subject</h4>
    </div>
    <form method="GET" action="/teacher/marks" style="margin-bottom: 20px;">
        <div style="display: flex; gap: 12px; max-width: 600px; flex-wrap: wrap;">
            <select name="exam_id" class="form-control" style="flex:1;" onchange="this.form.submit()">
                <?php foreach ($exams as $ex): ?>
                    <option value="<?= $ex['id'] ?>" <?= $selectedExam == $ex['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($ex['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="subject_id" class="form-control" style="flex:1;" onchange="this.form.submit()">
                <?php foreach ($subjects as $sb): ?>
                    <option value="<?= $sb['id'] ?>" <?= $selectedSubject == $sb['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($sb['code'] . ' - ' . $sb['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Roll No</th>
                    <th>Student Name</th>
                    <th>Score</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($marksList)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">No marks recorded for this exam & subject yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($marksList as $m): ?>
                        <?php $pct = round(((float)$m['marks_obtained'] / ((float)$m['max_marks'] ?: 100)) * 100, 1); ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($m['roll_no']) ?></strong></td>
                            <td><?= htmlspecialchars($m['student_name']) ?></td>
                            <td><strong><?= (float)$m['marks_obtained'] ?></strong> / <?= (float)$m['max_marks'] ?></td>
                            <td><span class="status-pill status-present"><?= $pct ?>%</span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
