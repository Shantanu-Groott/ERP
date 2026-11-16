<div class="card-grid">
    <div class="stat-card">
        <span class="label">Total Students</span>
        <span class="value"><?= number_format($stats['total_students']) ?></span>
    </div>
    <div class="stat-card">
        <span class="label">Teaching Staff</span>
        <span class="value"><?= number_format($stats['total_teachers']) ?></span>
    </div>
    <div class="stat-card">
        <span class="label">Active Classes</span>
        <span class="value"><?= number_format($stats['total_classes']) ?></span>
    </div>
    <div class="stat-card">
        <span class="label">Collected Fees</span>
        <span class="value" style="color: var(--success);">$<?= number_format($stats['total_revenue'], 2) ?></span>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">🛡️ System Security & Audit Log</h4>
        <span style="font-size: 0.8rem; color: #64748b;">Live audit trails</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th>Details</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($audits)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">No audit trail events logged yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($audits as $audit): ?>
                        <tr>
                            <td><?= htmlspecialchars($audit['created_at']) ?></td>
                            <td><strong><?= htmlspecialchars($audit['user_name'] ?? 'System/Guest') ?></strong></td>
                            <td><span class="status-pill status-present"><?= htmlspecialchars($audit['user_role'] ?? 'guest') ?></span></td>
                            <td><code><?= htmlspecialchars($audit['action']) ?></code></td>
                            <td><?= htmlspecialchars($audit['details']) ?></td>
                            <td><?= htmlspecialchars($audit['ip_address']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
