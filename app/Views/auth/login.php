<div class="auth-card-header">
    <?php if (($mode ?? 'login') === 'forgot'): ?>
        <h2>Password Recovery</h2>
        <p>Please enter your registered email or username below</p>
    <?php elseif (($mode ?? 'login') === 'reset'): ?>
        <h2>Set New Password</h2>
        <p>Please enter and confirm your new password below</p>
    <?php else: ?>
        <h2>Welcome back</h2>
        <p>Please Log Into your account below to continue</p>
    <?php endif; ?>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if (($mode ?? 'login') === 'forgot'): ?>
    <form action="/forgot-password" method="POST">
        <?= \App\Core\Csrf::field() ?>
        <input type="hidden" name="realm" value="<?= htmlspecialchars($realm ?? 'staff') ?>">
        
        <div class="form-group">
            <label class="form-label" for="identifier">Username or Email</label>
            <div class="input-icon-group">
                <span class="input-icon-left">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </span>
                <input type="text" name="identifier" id="identifier" class="input-field" placeholder="e.g. admin or student@erp.local" required autofocus>
            </div>
        </div>

        <button type="submit" class="btn-theme-submit">Send Recovery Instructions</button>
        
        <div style="text-align: center; margin-top: 18px;">
            <a href="/login" class="forgot-link">&larr; Back to Sign In</a>
        </div>
    </form>
<?php elseif (($mode ?? 'login') === 'reset'): ?>
    <form action="/reset-password" method="POST">
        <?= \App\Core\Csrf::field() ?>
        <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
        <input type="hidden" name="realm" value="<?= htmlspecialchars($realm ?? 'staff') ?>">
        
        <div class="form-group">
            <label class="form-label" for="password">New Password</label>
            <div class="input-icon-group">
                <span class="input-icon-left">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input type="password" name="password" id="password" class="input-field" placeholder="Minimum 8 characters" required autofocus minlength="8">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirm">Confirm Password</label>
            <div class="input-icon-group">
                <span class="input-icon-left">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input type="password" name="password_confirm" id="password_confirm" class="input-field" placeholder="Re-enter password" required minlength="8">
            </div>
        </div>

        <button type="submit" class="btn-theme-submit">Update Password</button>
    </form>
<?php else: ?>
    <!-- Login Form -->
    <form action="/login" method="POST">
        <?= \App\Core\Csrf::field() ?>

        <div class="form-group">
            <label class="form-label" for="identifier">Username</label>
            <div class="input-icon-group">
                <span class="input-icon-left">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </span>
                <input type="text" name="identifier" id="identifier" class="input-field" value="<?= htmlspecialchars($identifier ?? '') ?>" placeholder="e.g. admin or shantanu" required autofocus>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 8px;">
            <label class="form-label" for="password">Password</label>
            <div class="input-icon-group">
                <span class="input-icon-left">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input type="password" name="password" id="password" class="input-field" placeholder="••••••••" required>
                <button type="button" class="btn-toggle-eye" onclick="togglePassword('password', 'eyeIcon')" title="Show / Hide password">
                    <svg id="eyeIcon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="form-options-row">
            <a href="/forgot-password" class="forgot-link">Forgot Password</a>
        </div>

        <button type="submit" class="btn-theme-submit">Login</button>
    </form>

    <div class="demo-credentials-box">
        <strong>Demo Student Access:</strong><br>
        • Username: <code>shantanu</code> / Password: <code>admin123</code> &rarr; <em>Student Portal</em>
    </div>
<?php endif; ?>
