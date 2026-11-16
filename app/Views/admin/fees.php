<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Issue Fee Invoice</h4>
    </div>
    <form action="/admin/fees" method="POST">
        <?= \App\Core\View::csrfField() ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div class="form-group">
                <label>Select Student</label>
                <select name="student_id" class="form-control" required>
                    <option value="">-- Choose Student --</option>
                    <?php foreach ($students as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name'] . ' (' . $s['roll_no'] . ')') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Fee Title / Description</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. Semester 5 Tuition Fee" required>
            </div>
            <div class="form-group">
                <label>Amount ($)</label>
                <input type="number" step="0.01" name="amount" class="form-control" placeholder="1500.00" required>
            </div>
            <div class="form-group">
                <label>Due Date</label>
                <input type="date" name="due_date" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Generate Invoice</button>
    </form>
</div>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Fee Invoices & Payments</h4>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Student</th>
                    <th>Class</th>
                    <th>Fee Title</th>
                    <th>Billed</th>
                    <th>Paid</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fees as $f): ?>
                    <tr>
                        <td>#INV-<?= str_pad((string)$f['id'], 5, '0', STR_PAD_LEFT) ?></td>
                        <td><strong><?= htmlspecialchars($f['student_name']) ?></strong> (<?= htmlspecialchars($f['roll_no']) ?>)</td>
                        <td><?= htmlspecialchars(($f['class_name'] ?? 'Class') . ' - Div ' . ($f['division'] ?? 'A')) ?></td>
                        <td><?= htmlspecialchars($f['title']) ?></td>
                        <td><strong>$<?= number_format($f['amount'], 2) ?></strong></td>
                        <td><span style="color: var(--success);">$<?= number_format($f['paid_amount'], 2) ?></span></td>
                        <td><?= htmlspecialchars($f['due_date']) ?></td>
                        <td>
                            <span class="status-pill status-<?= $f['status'] ?>">
                                <?= strtoupper($f['status']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($f['status'] !== 'paid'): ?>
                                <a href="/admin/fees/pay/<?= $f['id'] ?>" class="btn btn-success btn-sm">Record Payment</a>
                            <?php else: ?>
                                <span style="font-size: 0.8rem; color: #16a34a;">Settled</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
