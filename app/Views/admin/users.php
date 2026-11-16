<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">Add New User Account</h4>
    </div>
    <form action="/admin/users" method="POST">
        <?= \App\Core\View::csrfField() ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="e.g. John Doe" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="e.g. john.doe" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="john@erp.local" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" placeholder="+1 555-0199">
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" id="roleSelect" required>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div class="form-group" id="classSelectGroup">
                <label>Assign Class (if Student)</label>
                <select name="class_id" class="form-control">
                    <?php foreach ($classes as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name'] . ' - Div ' . $c['division']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group" id="deptSelectGroup">
                <label>Assign Department (if Teacher)</label>
                <select name="department_id" class="form-control">
                    <?php foreach ($departments as $d): ?>
                        <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?> (<?= htmlspecialchars($d['code']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Create User</button>
    </form>
</div>

<div class="panel">
    <div class="panel-header">
        <h4 class="panel-title">System Users (<?= count($users) ?>)</h4>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td>#<?= $u['id'] ?></td>
                        <td><strong><?= htmlspecialchars($u['full_name']) ?></strong></td>
                        <td><code><?= htmlspecialchars($u['username']) ?></code></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><span class="status-pill status-present"><?= strtoupper($u['role']) ?></span></td>
                        <td><span class="status-pill <?= $u['status'] === 'active' ? 'status-present' : 'status-absent' ?>"><?= $u['status'] ?></span></td>
                        <td><?= $u['last_login_at'] ? htmlspecialchars($u['last_login_at']) : '<span style="color:#94a3b8">Never</span>' ?></td>
                        <td>
                            <a href="/admin/users/delete/<?= $u['id'] ?>" 
                               onclick="return confirm('Are you sure you want to remove this account?');" 
                               class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
