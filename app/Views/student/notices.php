<div style="display: flex; flex-direction: column; gap: 24px;">
    <!-- Notices Header -->
    <div style="border-bottom: 1px solid #e2e8f0; padding-bottom: 20px;">
        <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #2563eb;">INSTITUTE UPDATES</span>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #0f172a; margin-top: 4px;">Academic Notice Board</h1>
        <p style="font-size: 0.875rem; color: #64748b; margin-top: 4px;">Important administrative notifications, examination circulars, and departmental advisories.</p>
    </div>

    <!-- Notices Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
        <?php if (empty($notices)): ?>
            <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 16px; padding: 48px; text-align: center; grid-column: 1 / -1;">
                <p style="font-size: 1rem; font-weight: 700; color: #334155;">No notices published yet</p>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">New circulars from academic staff will appear on this board.</p>
            </div>
        <?php else: ?>
            <?php foreach ($notices as $n): ?>
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between; gap: 16px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.7rem; font-weight: 800; font-family: monospace; text-transform: uppercase; background: #dbeafe; color: #1e40af; padding: 3px 8px; border-radius: 6px;">
                                <?= htmlspecialchars(strtoupper($n['audience'])) ?>
                            </span>
                            <span style="font-size: 0.75rem; color: #94a3b8; font-family: monospace;">
                                <?= date('M d, Y', strtotime($n['created_at'])) ?>
                            </span>
                        </div>
                        <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin-top: 12px; margin-bottom: 6px;">
                            <?= htmlspecialchars($n['title']) ?>
                        </h3>
                        <p style="font-size: 0.85rem; color: #475569; line-height: 1.6;">
                            <?= nl2br(htmlspecialchars($n['body'])) ?>
                        </p>
                    </div>

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 12px; display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #64748b;">
                        <span>Issued by: <strong><?= htmlspecialchars($n['author_name'] ?? 'Administration') ?></strong></span>
                        <span style="color: #047857; font-weight: 700;">Verified Circular</span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
