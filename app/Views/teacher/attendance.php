<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Select Teaching Assignment & Date</h4>
    </div>
    <form method="GET" action="/teacher/attendance" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
        <div class="form-group" style="flex: 2; margin-bottom: 0; min-width: 250px;">
            <label>Assigned Class & Subject</label>
            <select name="assignment_id" class="form-control" onchange="this.form.submit()">
                <?php foreach ($assignments as $a): ?>
                    <option value="<?= $a['assignment_id'] ?>" <?= $selectedAssignment == $a['assignment_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($a['class_name'] . ' (Div ' . $a['division'] . ') - ' . $a['subject_name'] . ' [' . $a['subject_code'] . ']') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group" style="flex: 1; margin-bottom: 0; min-width: 160px;">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($selectedDate) ?>" onchange="this.form.submit()">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

<?php if ($selectedAssignment > 0): ?>
<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Roll Call (<?= count($students) ?> Students)</h4>
        <span>Session Date: <strong><?= htmlspecialchars($selectedDate) ?></strong></span>
    </div>
    <?php if (empty($students)): ?>
        <p style="color: #64748b; padding: 20px 0;">No students enrolled in this class.</p>
    <?php else: ?>
        <form action="/teacher/attendance" method="POST">
            <?= \App\Core\View::csrfField() ?>
            <input type="hidden" name="assignment_id" value="<?= $selectedAssignment ?>">
            <input type="hidden" name="date" value="<?= htmlspecialchars($selectedDate) ?>">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Roll Number</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Attendance Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $s): ?>
                            <?php $currentStatus = $existingRecords[$s['id']] ?? 'present'; ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($s['roll_no']) ?></strong></td>
                                <td><?= htmlspecialchars($s['name']) ?></td>
                                <td><?= htmlspecialchars($s['email']) ?></td>
                                <td>
                                    <label style="margin-right: 14px; font-weight: 500; cursor: pointer;">
                                        <input type="radio" name="status[<?= $s['id'] ?>]" value="present" <?= $currentStatus === 'present' ? 'checked' : '' ?>> Present
                                    </label>
                                    <label style="margin-right: 14px; font-weight: 500; cursor: pointer;">
                                        <input type="radio" name="status[<?= $s['id'] ?>]" value="absent" <?= $currentStatus === 'absent' ? 'checked' : '' ?>> Absent
                                    </label>
                                    <label style="margin-right: 14px; font-weight: 500; cursor: pointer;">
                                        <input type="radio" name="status[<?= $s['id'] ?>]" value="late" <?= $currentStatus === 'late' ? 'checked' : '' ?>> Late
                                    </label>
                                    <label style="margin-right: 14px; font-weight: 500; cursor: pointer;">
                                        <input type="radio" name="status[<?= $s['id'] ?>]" value="excused" <?= $currentStatus === 'excused' ? 'checked' : '' ?>> Excused
                                    </label>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Save Attendance</button>
        </form>
    <?php endif; ?>
</div>
<?php endif; ?>
