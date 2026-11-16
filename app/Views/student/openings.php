<div style="display: flex; flex-direction: column; gap: 24px;">
    <!-- Placement Header -->
    <div style="border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
        <div>
            <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #2563eb;">PLACEMENT DESK</span>
            <h1 style="font-size: 1.85rem; font-weight: 800; color: #0f172a; margin-top: 4px;">Career Opportunities & Drives</h1>
            <p style="font-size: 0.875rem; color: #64748b; margin-top: 4px;">Direct hiring opportunities shared by institute recruitment partners.</p>
        </div>
        <div style="font-size: 0.8rem; color: #64748b; font-family: monospace;">
            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #10b981; margin-right: 6px;"></span>
            <strong><?= count($openings) ?> Active Positions</strong>
        </div>
    </div>

    <!-- Search Form -->
    <form method="GET" action="/student/openings" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 12px; display: flex; gap: 12px; align-items: center;">
        <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Search by role, company name, or technical skill (e.g. PHP, Docker)..." class="form-control" style="border: none; background: #f8fafc; padding: 10px 14px; font-size: 0.875rem;">
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; white-space: nowrap;">Search</button>
        <?php if (!empty($search)): ?>
            <a href="/student/openings" style="font-size: 0.8rem; color: #64748b; text-decoration: none; padding: 0 10px;">Clear</a>
        <?php endif; ?>
    </form>

    <!-- Openings Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 20px;">
        <?php if (empty($openings)): ?>
            <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 16px; padding: 48px; text-align: center; grid-column: 1 / -1;">
                <p style="font-size: 1rem; font-weight: 700; color: #334155;">No matching opportunities found</p>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">Try searching with different keywords or clear your query.</p>
            </div>
        <?php else: ?>
            <?php foreach ($openings as $op): ?>
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between; gap: 16px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: #eff6ff; color: #1d4ed8; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;">
                                    <?= htmlspecialchars(strtoupper(substr($op['company_name'], 0, 1))) ?>
                                </div>
                                <div>
                                    <span style="font-size: 0.7rem; font-weight: 800; color: #2563eb; text-transform: uppercase; letter-spacing: 1px; display: block;">
                                        <?= htmlspecialchars($op['company_name']) ?>
                                    </span>
                                    <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin-top: 2px;">
                                        <?= htmlspecialchars($op['title']) ?>
                                    </h3>
                                </div>
                            </div>
                            <span style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; background: #ecfdf5; color: #047857; padding: 4px 10px; border-radius: 9999px; white-space: nowrap;">
                                <?= htmlspecialchars($op['employment_type']) ?>
                            </span>
                        </div>

                        <div style="border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; padding: 10px 0; margin: 14px 0; display: flex; flex-wrap: wrap; gap: 14px; font-size: 0.75rem; color: #64748b; font-family: monospace;">
                            <span>📍 <?= htmlspecialchars($op['location']) ?></span>
                            <span>Eligible: <strong><?= htmlspecialchars($op['course_codes']) ?></strong></span>
                            <span>Apply by: <strong><?= htmlspecialchars($op['deadline']) ?></strong></span>
                        </div>

                        <p style="font-size: 0.85rem; color: #475569; line-height: 1.6;">
                            <?= htmlspecialchars($op['description']) ?>
                        </p>

                        <div style="margin-top: 12px; font-size: 0.75rem; color: #64748b;">
                            <strong style="color: #334155;">Required Skills:</strong> <?= htmlspecialchars($op['skills']) ?>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 14px; display: flex; justify-content: flex-end;">
                        <a href="mailto:<?= htmlspecialchars($op['application_email']) ?>?subject=Application for <?= urlencode($op['title']) ?> - <?= urlencode($student['name'] ?? 'Student') ?>" class="btn btn-primary btn-sm" style="border-radius: 8px;">
                            Apply via Recruiter &rarr;
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
