<div style="display: flex; flex-direction: column; gap: 24px;">
    <!-- Project Header -->
    <div style="border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
        <div>
            <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #4f46e5;">INDUSTRY PROJECTS</span>
            <h1 style="font-size: 1.85rem; font-weight: 800; color: #0f172a; margin-top: 4px;">Company Capstones & Live Labs</h1>
            <p style="font-size: 0.875rem; color: #64748b; margin-top: 4px;">Practical engineering briefs and sponsored industry projects for graduation credit.</p>
        </div>
        <div style="font-size: 0.8rem; color: #64748b; font-family: monospace;">
            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #4f46e5; margin-right: 6px;"></span>
            <strong><?= count($projects) ?> Projects Available</strong>
        </div>
    </div>

    <!-- Search Form -->
    <form method="GET" action="/student/projects" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 12px; display: flex; gap: 12px; align-items: center;">
        <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Search by project title, corporate partner, or tech stack..." class="form-control" style="border: none; background: #f8fafc; padding: 10px 14px; font-size: 0.875rem;">
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; white-space: nowrap;">Search</button>
        <?php if (!empty($search)): ?>
            <a href="/student/projects" style="font-size: 0.8rem; color: #64748b; text-decoration: none; padding: 0 10px;">Clear</a>
        <?php endif; ?>
    </form>

    <!-- Projects Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 20px;">
        <?php if (empty($projects)): ?>
            <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 16px; padding: 48px; text-align: center; grid-column: 1 / -1;">
                <p style="font-size: 1rem; font-weight: 700; color: #334155;">No industry projects matching query</p>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">Clear query or check back soon for newly published briefs.</p>
            </div>
        <?php else: ?>
            <?php foreach ($projects as $pr): ?>
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between; gap: 16px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;">
                                    <?= htmlspecialchars(strtoupper(substr($pr['company_name'], 0, 1))) ?>
                                </div>
                                <div>
                                    <span style="font-size: 0.7rem; font-weight: 800; color: #4f46e5; text-transform: uppercase; letter-spacing: 1px; display: block;">
                                        <?= htmlspecialchars($pr['company_name']) ?>
                                    </span>
                                    <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin-top: 2px;">
                                        <?= htmlspecialchars($pr['title']) ?>
                                    </h3>
                                </div>
                            </div>
                            <span style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; background: #eef2ff; color: #4338ca; padding: 4px 10px; border-radius: 9999px; white-space: nowrap;">
                                <?= htmlspecialchars($pr['project_type']) ?>
                            </span>
                        </div>

                        <div style="border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; padding: 10px 0; margin: 14px 0; display: flex; flex-wrap: wrap; gap: 14px; font-size: 0.75rem; color: #64748b; font-family: monospace;">
                            <span>📍 <?= htmlspecialchars($pr['location']) ?></span>
                            <span>Duration: <strong><?= htmlspecialchars($pr['engagement']) ?></strong></span>
                            <span>Eligible: <strong><?= htmlspecialchars($pr['course_codes']) ?></strong></span>
                        </div>

                        <p style="font-size: 0.85rem; color: #475569; line-height: 1.6;">
                            <?= htmlspecialchars($pr['description']) ?>
                        </p>

                        <div style="margin-top: 12px; font-size: 0.75rem; color: #64748b;">
                            <strong style="color: #334155;">Tech Stack:</strong> <?= htmlspecialchars($pr['skills']) ?>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 14px; display: flex; justify-content: flex-end;">
                        <a href="mailto:<?= htmlspecialchars($pr['contact_email']) ?>?subject=Project Inquiry for <?= urlencode($pr['title']) ?>" class="btn btn-primary btn-sm" style="background: #0f172a; border-radius: 8px;">
                            Request Project Brief &rarr;
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
