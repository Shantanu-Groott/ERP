<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Add Academic Class</h4>
    </div>
    <form action="/admin/classes" method="POST">
        <?= \App\Core\View::csrfField() ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div class="form-group">
                <label>Department</label>
                <select name="department_id" class="form-control" required>
                    <?php foreach ($departments as $d): ?>
                        <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?> (<?= htmlspecialchars($d['code']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Academic Year</label>
                <select name="academic_year_id" class="form-control" required>
                    <?php foreach ($academicYears as $ay): ?>
                        <option value="<?= $ay['id'] ?>"><?= htmlspecialchars($ay['label']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Class Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. TE Computer" required>
            </div>
            <div class="form-group">
                <label>Division</label>
                <input type="text" name="division" class="form-control" placeholder="e.g. A" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Register Class</button>
    </form>
</div>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Registered Classes & Enrollment</h4>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Class ID</th>
                    <th>Department</th>
                    <th>Academic Year</th>
                    <th>Class Name</th>
                    <th>Division</th>
                    <th>Enrolled Students</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $c): ?>
                    <tr>
                        <td>#<?= $c['id'] ?></td>
                        <td><strong><?= htmlspecialchars($c['department_name']) ?></strong> (<?= htmlspecialchars($c['department_code']) ?>)</td>
                        <td><?= htmlspecialchars($c['academic_year']) ?></td>
                        <td><?= htmlspecialchars($c['name']) ?></td>
                        <td><span class="status-pill status-present">Div <?= htmlspecialchars($c['division']) ?></span></td>
                        <td><?= (int)$c['total_students'] ?> Students</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
