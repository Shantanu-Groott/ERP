<div class="card-grid">
    <div class="stat-card">
        <span class="label">Assigned Teacher</span>
        <span class="value" style="font-size: 1.3rem;"><?= htmlspecialchars(\App\Core\Session::get('user_name', 'Teacher')) ?></span>
    </div>
    <div class="stat-card">
        <span class="label">Employee Code</span>
        <span class="value" style="font-size: 1.3rem;"><?= htmlspecialchars($teacher['employee_code'] ?? 'EMP-1001') ?></span>
    </div>
    <div class="stat-card">
        <span class="label">Department</span>
        <span class="value" style="font-size: 1.3rem;"><?= htmlspecialchars($teacher['department_name'] ?? 'Faculty') ?></span>
    </div>
    <div class="stat-card">
        <span class="label">Active Classes</span>
        <span class="value"><?= count($classes) ?></span>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Quick Actions</h4>
    </div>
    <div style="display: flex; gap: 16px;">
        <a href="/teacher/attendance" class="btn btn-primary">📅 Mark Attendance Today</a>
        <a href="/teacher/marks" class="btn btn-success">📝 Record Examination Marks</a>
    </div>
</div>
