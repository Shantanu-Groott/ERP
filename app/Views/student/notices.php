<?php
/**
 * Kalavanta Edutech - Student Notice Board
 * Clean, simple, and linear layout matching the Session Timeline Log aesthetic:
 *  - Single unified card
 *  - Header with Notice Board title and simple filter pills (All, Academic, Examinations, Events, Urgent)
 *  - Clean linear rows with date box, category pill, bold title, excerpt, and "View Notice" button
 *  - Lightweight reading modal
 */
$totalNotices = count($notices);
?>

<div class="notice-board-container" style="display: flex; flex-direction: column; gap: 20px;">

    <!-- ==================================================== -->
    <!-- MAIN NOTICES CARD                                    -->
    <!-- ==================================================== -->
    <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 24px 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        
        <!-- Header: Title + Filter Pills -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #edf2ed;">
            
            <!-- Left: Title with Bell Icon -->
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#2d6a4f" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
                <h3 style="font-size: 1.05rem; font-weight: 700; color: #183324; margin: 0;">
                    Notice Board (<span id="noticeCountDisplay"><?= $totalNotices ?></span> Notices)
                </h3>
            </div>

            <!-- Right: Filter Pills -->
            <div class="notice-filter-pills" style="display: flex; gap: 5px; flex-wrap: wrap;">
                <button type="button" class="notice-filter-btn active" data-filter="all" onclick="filterNotices('all', this)">All</button>
                <button type="button" class="notice-filter-btn" data-filter="exam" onclick="filterNotices('exam', this)">Examinations</button>
                <button type="button" class="notice-filter-btn" data-filter="academic" onclick="filterNotices('academic', this)">Academic</button>
                <button type="button" class="notice-filter-btn" data-filter="event" onclick="filterNotices('event', this)">Events</button>
                <button type="button" class="notice-filter-btn" data-filter="urgent" onclick="filterNotices('urgent', this)">Urgent</button>
            </div>

        </div>

        <!-- Notices Linear List -->
        <?php if (empty($notices)): ?>
            <div style="padding: 48px 20px; text-align: center; color: #627467;">
                <p style="font-size: 0.95rem; font-weight: 700; color: #183324; margin-bottom: 4px;">No notices published yet</p>
                <p style="font-size: 0.82rem; margin: 0;">New campus circulars will appear here.</p>
            </div>
        <?php else: ?>
            <div id="noticesList" style="display: flex; flex-direction: column;">
                <?php foreach ($notices as $n): ?>
                    <?php 
                        $nJson = htmlspecialchars(json_encode($n), ENT_QUOTES, 'UTF-8');
                    ?>
                    <div class="notice-item-row" 
                         data-category="<?= htmlspecialchars($n['category']) ?>"
                         data-urgent="<?= $n['is_urgent'] ? 'yes' : 'no' ?>"
                         onclick="openNoticeModal(<?= $nJson ?>)"
                         style="display: flex; align-items: center; justify-content: space-between; padding: 16px 14px; gap: 16px; border-bottom: 1px solid #edf2ed; cursor: pointer; border-radius: 12px; transition: background 0.15s ease;">
                        
                        <!-- Left: Date Box + Details -->
                        <div style="display: flex; align-items: center; gap: 16px; flex: 1; min-width: 0;">
                            
                            <!-- Date Box -->
                            <div style="width: 50px; height: 50px; border-radius: 12px; background: #f3f7f4; border: 1px solid #e2ece4; display: flex; flex-direction: column; align-items: center; justify-content: center; flex-shrink: 0;">
                                <span style="font-size: 0.65rem; font-weight: 800; color: #718576; text-transform: uppercase;"><?= $n['month'] ?></span>
                                <span style="font-size: 1.15rem; font-weight: 800; color: #183324; line-height: 1;"><?= $n['day'] ?></span>
                            </div>

                            <!-- Content -->
                            <div style="display: flex; flex-direction: column; gap: 4px; min-width: 0; flex: 1;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 0.68rem; font-weight: 700; color: <?= $n['badge_color'] ?>; background: <?= $n['badge_bg'] ?>; padding: 2px 8px; border-radius: 999px;">
                                        <?= htmlspecialchars($n['category_label']) ?>
                                    </span>
                                    <?php if ($n['is_urgent']): ?>
                                        <span style="font-size: 0.68rem; font-weight: 700; color: #dc2626; background: #fee2e2; padding: 2px 8px; border-radius: 999px;">
                                            Urgent
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h4 style="font-size: 0.95rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.35; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?= htmlspecialchars($n['title']) ?>
                                </h4>
                                
                                <p style="font-size: 0.8rem; color: #627467; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.4;">
                                    <?= htmlspecialchars(strip_tags($n['body'])) ?>
                                </p>
                            </div>
                        </div>

                        <!-- Right: Clean Pill Button -->
                        <button type="button" class="btn-view-notice"
                                onclick="event.stopPropagation(); openNoticeModal(<?= $nJson ?>)"
                                style="padding: 7px 18px; border-radius: 999px; background: #1c4b32; color: #ffffff; font-weight: 600; font-size: 0.8rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-family: inherit; flex-shrink: 0; transition: background 0.15s ease;">
                            <span>View Notice</span>
                            <span>&rarr;</span>
                        </button>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

</div>

<!-- ==================================================== -->
<!-- SIMPLE CLEAN READING MODAL                           -->
<!-- ==================================================== -->
<div id="simpleNoticeModal" class="notice-modal-overlay" style="display: none;">
    <div class="notice-modal-container">
        
        <!-- Modal Header -->
        <div class="notice-modal-header">
            <div>
                <span id="modalNoticeBadge" style="font-size: 0.7rem; font-weight: 700; padding: 2px 8px; border-radius: 999px; background: #eaf5ee; color: #1c4b32;">
                    Notice
                </span>
                <span id="modalNoticeDate" style="font-size: 0.75rem; color: #718576; font-weight: 500; margin-left: 8px;">
                    Nov 16, 2026
                </span>
            </div>
            <button type="button" class="btn-close-modal" onclick="closeNoticeModal()">&times;</button>
        </div>

        <!-- Modal Body -->
        <div class="notice-modal-body">
            <h3 id="modalNoticeTitle" style="font-size: 1.25rem; font-weight: 800; color: #183324; margin: 0; line-height: 1.35;">
                Notice Title
            </h3>
            
            <p id="modalNoticeAuthor" style="font-size: 0.78rem; color: #718576; margin: 0;">
                Issued by Administration
            </p>

            <hr style="border: none; border-top: 1px solid #edf2ed; margin: 6px 0;">

            <div id="modalNoticeBody" style="font-size: 0.88rem; color: #2d4133; line-height: 1.65; white-space: pre-line;">
                Notice text content...
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="notice-modal-footer">
            <button type="button" class="btn-modal-dismiss" onclick="closeNoticeModal()">
                Close
            </button>
        </div>

    </div>
</div>

<!-- ==================================================== -->
<!-- STYLING                                              -->
<!-- ==================================================== -->
<style>
/* Hover row */
.notice-item-row:hover {
    background: #f7faf7 !important;
}

/* Button Hover */
.btn-view-notice:hover {
    background: #143725 !important;
}

/* Filter Pills */
.notice-filter-btn {
    padding: 6px 14px;
    border-radius: 999px;
    border: 1px solid #d5e0d5;
    background: #f3f7f4;
    color: #526757;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.15s ease;
}
.notice-filter-btn.active {
    background: #1c4b32 !important;
    color: #ffffff !important;
    border-color: #1c4b32 !important;
}
.notice-filter-btn:hover:not(.active) {
    background: #e2ece4;
    color: #1c4b32;
}

/* Modal Overlay */
.notice-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(18, 38, 26, 0.45);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.notice-modal-container {
    background: #ffffff;
    border-radius: 20px;
    max-width: 560px;
    width: 100%;
    box-shadow: 0 20px 45px rgba(0,0,0,0.18);
    overflow: hidden;
    border: 1px solid #dce8de;
    animation: simpleModalUp 0.18s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes simpleModalUp {
    from { opacity: 0; transform: translateY(10px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.notice-modal-header {
    background: #f4f8f5;
    padding: 16px 22px;
    border-bottom: 1px solid #e2ece4;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.btn-close-modal {
    background: transparent;
    border: none;
    font-size: 1.4rem;
    color: #627467;
    cursor: pointer;
    padding: 2px 6px;
    border-radius: 4px;
    line-height: 1;
}
.btn-close-modal:hover {
    color: #183324;
    background: #e2ece4;
}
.notice-modal-body {
    padding: 22px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 70vh;
    overflow-y: auto;
}
.notice-modal-footer {
    padding: 14px 22px;
    background: #fafcfa;
    border-top: 1px solid #edf2ed;
    display: flex;
    justify-content: flex-end;
}
.btn-modal-dismiss {
    background: #1c4b32;
    color: #ffffff;
    border: none;
    padding: 8px 20px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: background 0.15s ease;
}
.btn-modal-dismiss:hover {
    background: #143725;
}
</style>

<!-- ==================================================== -->
<!-- JAVASCRIPT INTERACTIONS                              -->
<!-- ==================================================== -->
<script>
// Filter Notices by Category or Urgent
function filterNotices(filter, btn) {
    document.querySelectorAll('.notice-filter-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');

    const rows = document.querySelectorAll('.notice-item-row');
    let count = 0;

    rows.forEach(row => {
        const cat = row.getAttribute('data-category');
        const isUrgent = (row.getAttribute('data-urgent') === 'yes');

        let show = false;
        if (filter === 'all') {
            show = true;
        } else if (filter === 'urgent') {
            show = isUrgent;
        } else {
            show = (cat === filter);
        }

        if (show) {
            row.style.display = 'flex';
            count++;
        } else {
            row.style.display = 'none';
        }
    });

    const display = document.getElementById('noticeCountDisplay');
    if (display) display.textContent = count;
}

// Modal logic
function openNoticeModal(notice) {
    if (!notice) return;

    document.getElementById('modalNoticeTitle').textContent = notice.title || 'Notice';
    document.getElementById('modalNoticeDate').textContent = notice.formatted_date || '';
    document.getElementById('modalNoticeAuthor').textContent = 'Issued by ' + (notice.author_name || 'Administration');
    document.getElementById('modalNoticeBody').textContent = notice.body || '';

    const badge = document.getElementById('modalNoticeBadge');
    if (badge) {
        badge.textContent = notice.category_label || 'Notice';
        badge.style.background = notice.badge_bg || '#eaf5ee';
        badge.style.color = notice.badge_color || '#1c4b32';
    }

    const modal = document.getElementById('simpleNoticeModal');
    if (modal) modal.style.display = 'flex';
}

function closeNoticeModal() {
    const modal = document.getElementById('simpleNoticeModal');
    if (modal) modal.style.display = 'none';
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('simpleNoticeModal');
    if (e.target === modal) closeNoticeModal();
});
window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeNoticeModal();
});
</script>
