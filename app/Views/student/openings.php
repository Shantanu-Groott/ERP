<?php
/**
 * Student Openings & Opportunities Desk
 * Matches Kalavanta Edutech mockup design with category filters, sort bar, custom icons, and apply modal.
 */
?>

<div class="openings-desk-wrapper" style="max-width: 1200px; margin: 0 auto;">

    <!-- Main White Container Card -->
    <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 24px 28px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);">
        
        <!-- Filter Pills & Sort Bar -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 22px;">
            
            <!-- Filter Pills (All, Internship, Full-Time, Part-Time) -->
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;" id="openingsFilterGroup">
                <button type="button" class="filter-pill active" data-category="all" onclick="filterCategory('all', this)">
                    All
                </button>
                <button type="button" class="filter-pill" data-category="internship" onclick="filterCategory('internship', this)">
                    Internship
                </button>
                <button type="button" class="filter-pill" data-category="full-time" onclick="filterCategory('full-time', this)">
                    Full-Time
                </button>
                <button type="button" class="filter-pill" data-category="part-time" onclick="filterCategory('part-time', this)">
                    Part-Time
                </button>
            </div>

            <!-- Sort By Dropdown -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 0.88rem; color: #627467; font-weight: 500;">Sort by:</span>
                <div style="position: relative; display: inline-block;">
                    <select id="sortSelect" onchange="sortOpenings(this.value)" style="appearance: none; -webkit-appearance: none; background: #ffffff; border: 1px solid #dbe5db; border-radius: 9999px; padding: 7px 34px 7px 16px; font-size: 0.84rem; font-weight: 600; color: #183324; cursor: pointer; outline: none; transition: border-color 0.2s;">
                        <option value="latest">Latest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="deadline">Deadline (Earliest)</option>
                    </select>
                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #627467; font-size: 0.72rem;">▼</span>
                </div>
            </div>

        </div>

        <!-- Openings Items List -->
        <div id="openingsListContainer" style="display: flex; flex-direction: column; gap: 14px;">
            <?php if (empty($openings)): ?>
                <div id="noOpeningsEmptyState" style="text-align: center; padding: 48px 20px; background: #fafcfa; border: 1px dashed #d1ded4; border-radius: 18px;">
                    <div style="width: 50px; height: 50px; border-radius: 12px; background: #eaf5ee; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; color: #2d6a4f;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <p style="font-size: 1rem; font-weight: 700; color: #183324; margin: 0 0 4px 0;">No active openings found</p>
                    <p style="font-size: 0.84rem; color: #627467; margin: 0;">Please check back soon for fresh opportunities.</p>
                </div>
            <?php else: ?>
                <?php foreach ($openings as $index => $op): ?>
                    <?php
                        $cat = $op['category'] ?? 'full-time';
                        $iconType = $op['icon_type'] ?? 'desktop';
                        $roleLabel = $op['role_label'] ?? $op['employment_type'];
                        $deadlineFormatted = $op['deadline'] ?? '';
                        $orderIndex = $index;
                    ?>
                    <div class="opening-row-card" 
                         data-id="<?= (int)$op['id'] ?>" 
                         data-category="<?= htmlspecialchars($cat) ?>" 
                         data-deadline="<?= htmlspecialchars($op['deadline']) ?>"
                         data-order="<?= $orderIndex ?>"
                         style="background: #ffffff; border: 1px solid #eef3ef; border-radius: 18px; padding: 22px 24px; display: flex; align-items: center; justify-content: space-between; gap: 20px; transition: all 0.2s ease;">
                        
                        <!-- Left: Mint Icon + Content -->
                        <div style="display: flex; align-items: center; gap: 20px; flex: 1; min-width: 0;">
                            
                            <!-- Mint Icon Box -->
                            <div style="width: 64px; height: 64px; min-width: 64px; border-radius: 16px; background: #eaf5ee; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #2d6a4f;">
                                <?php if ($iconType === 'laptop'): ?>
                                    <!-- Laptop with </> screen code icon (e.g. Cyber Security Intern) -->
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="12" rx="2"></rect>
                                        <path d="M2 20h20"></path>
                                        <polyline points="9 9 7 11 9 13"></polyline>
                                        <polyline points="15 9 17 11 15 13"></polyline>
                                        <line x1="13" y1="8" x2="11" y2="14"></line>
                                    </svg>
                                <?php elseif ($iconType === 'users'): ?>
                                    <!-- 3 People / Group Icon (e.g. Tech Fest Volunteer) -->
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                <?php else: ?>
                                    <!-- Desktop Monitor Screen Icon (e.g. Full Stack Developer) -->
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                                        <line x1="8" y1="21" x2="16" y2="21"></line>
                                        <line x1="12" y1="17" x2="12" y2="21"></line>
                                    </svg>
                                <?php endif; ?>
                            </div>

                            <!-- Details Column -->
                            <div style="flex: 1; min-width: 0;">
                                <h3 style="font-size: 1.15rem; font-weight: 800; color: #183324; margin: 0 0 4px 0; letter-spacing: -0.2px;">
                                    <?= htmlspecialchars($op['title']) ?>
                                </h3>
                                <p style="font-size: 0.88rem; color: #627467; margin: 0 0 10px 0; font-weight: 500; line-height: 1.4;">
                                    <?= htmlspecialchars($op['description']) ?>
                                </p>
                                
                                <!-- Meta Row: Role + Location + Deadline -->
                                <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 18px; font-size: 0.82rem; color: #627467; font-weight: 600;">
                                    
                                    <!-- Role / Category Tag with appropriate icon -->
                                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                                        <?php if ($cat === 'part-time'): ?>
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                            </svg>
                                        <?php else: ?>
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                            </svg>
                                        <?php endif; ?>
                                        <span><?= htmlspecialchars($roleLabel) ?></span>
                                    </span>

                                    <!-- Location Tag with Pin -->
                                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <span><?= htmlspecialchars($op['location']) ?></span>
                                    </span>

                                    <!-- Deadline Tag with Calendar -->
                                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>Apply by: <?= htmlspecialchars($deadlineFormatted) ?></span>
                                    </span>

                                </div>
                            </div>

                        </div>

                        <!-- Right: Apply Now Pill Button -->
                        <div style="flex-shrink: 0;">
                            <button type="button" 
                                    class="apply-btn-pill"
                                    id="applyBtn-<?= (int)$op['id'] ?>"
                                    onclick="openApplyModal(<?= htmlspecialchars(json_encode([
                                        'id' => (int)$op['id'],
                                        'title' => $op['title'],
                                        'company' => $op['company_name'],
                                        'location' => $op['location'],
                                        'type' => $op['employment_type'],
                                        'email' => $op['application_email'] ?? '',
                                        'deadline' => $op['deadline']
                                    ])) ?>)">
                                <span>Apply Now</span>
                                <span style="font-size: 1.05rem; line-height: 1;">&rarr;</span>
                            </button>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Client Filter Empty State (Hidden by default) -->
            <div id="filterEmptyState" style="display: none; text-align: center; padding: 48px 20px; background: #fafcfa; border: 1px dashed #d1ded4; border-radius: 18px;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: #eaf5ee; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; color: #2d6a4f;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <p style="font-size: 1rem; font-weight: 700; color: #183324; margin: 0 0 4px 0;">No positions in this category</p>
                <p style="font-size: 0.84rem; color: #627467; margin: 0 0 16px 0;">Switch to another filter to view more career opportunities.</p>
                <button type="button" onclick="filterCategory('all', document.querySelector('.filter-pill[data-category=\'all\']'))" style="background: #1c4b32; color: #ffffff; border: none; border-radius: 9999px; padding: 8px 20px; font-size: 0.84rem; font-weight: 700; cursor: pointer;">
                    View All Positions
                </button>
            </div>
        </div>

    </div>

</div>

<!-- Application Modal Dialog -->
<div id="applyModalBackdrop" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div id="applyModalCard" style="background: #ffffff; border-radius: 22px; width: 100%; max-width: 540px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid #e2e8f0; overflow: hidden; animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
        
        <!-- Modal Top Bar -->
        <div style="padding: 24px 28px 18px 28px; border-bottom: 1px solid #f1f5f2; display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #eaf5ee; display: flex; align-items: center; justify-content: center; color: #2d6a4f; flex-shrink: 0;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </div>
                <div>
                    <h3 id="modalJobTitle" style="font-size: 1.15rem; font-weight: 800; color: #183324; margin: 0; line-height: 1.2;">Apply for Position</h3>
                    <p id="modalCompanyMeta" style="font-size: 0.82rem; color: #627467; margin: 3px 0 0 0; font-weight: 500;">Company • Location</p>
                </div>
            </div>
            <button type="button" onclick="closeApplyModal()" style="background: transparent; border: none; font-size: 1.4rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 4px; border-radius: 8px;" title="Close">&times;</button>
        </div>

        <!-- Modal Form Body -->
        <form id="applyJobForm" onsubmit="submitApplication(event)" style="padding: 24px 28px;">
            <input type="hidden" id="modalJobId" name="job_id" value="">
            <input type="hidden" id="modalTargetEmail" name="target_email" value="">

            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #2d4a37; margin-bottom: 6px;">Applicant Name</label>
                    <input type="text" readonly value="<?= htmlspecialchars(\App\Core\Session::get('user_name', 'Shantanu')) ?>" style="width: 100%; box-sizing: border-box; background: #f8faf8; border: 1px solid #dbe5db; border-radius: 10px; padding: 10px 14px; font-size: 0.88rem; color: #183324; font-weight: 600; outline: none;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #2d4a37; margin-bottom: 6px;">Student Roll / ID</label>
                        <input type="text" readonly value="<?= htmlspecialchars($student['admission_no'] ?? 'STU-2025-042') ?>" style="width: 100%; box-sizing: border-box; background: #f8faf8; border: 1px solid #dbe5db; border-radius: 10px; padding: 10px 14px; font-size: 0.88rem; color: #183324; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #2d4a37; margin-bottom: 6px;">Contact Email</label>
                        <input type="email" id="applicantEmail" required value="<?= htmlspecialchars(\App\Core\Session::get('user_email', 'shantanu@kalavanta.edu')) ?>" style="width: 100%; box-sizing: border-box; background: #ffffff; border: 1px solid #dbe5db; border-radius: 10px; padding: 10px 14px; font-size: 0.88rem; color: #183324; outline: none;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #2d4a37; margin-bottom: 6px;">Portfolio / GitHub / Resume Link</label>
                    <input type="url" id="portfolioUrl" placeholder="https://github.com/shantanu or cloud drive link..." style="width: 100%; box-sizing: border-box; background: #ffffff; border: 1px solid #dbe5db; border-radius: 10px; padding: 10px 14px; font-size: 0.88rem; color: #183324; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #2d4a37; margin-bottom: 6px;">Statement / Note to Recruiter</label>
                    <textarea id="coverNote" rows="3" placeholder="Briefly describe your interest and relevant coursework/experience..." style="width: 100%; box-sizing: border-box; background: #ffffff; border: 1px solid #dbe5db; border-radius: 10px; padding: 10px 14px; font-size: 0.88rem; color: #183324; outline: none; resize: vertical;"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div style="margin-top: 24px; display: flex; align-items: center; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeApplyModal()" style="background: transparent; border: 1px solid #dbe5db; border-radius: 9999px; padding: 9px 20px; font-size: 0.85rem; font-weight: 600; color: #627467; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" id="submitApplyBtn" style="background: #1c4b32; color: #ffffff; border: none; border-radius: 9999px; padding: 10px 24px; font-size: 0.88rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(28, 75, 50, 0.2);">
                    <span>Submit Application</span>
                    <span>&rarr;</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Toast Feedback Notification -->
<div id="applyToast" style="position: fixed; bottom: 30px; right: 30px; background: #1c4b32; color: #ffffff; padding: 14px 22px; border-radius: 14px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); display: none; align-items: center; gap: 12px; z-index: 10000; animation: slideUpToast 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#86efac" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
    <span id="toastMessage" style="font-size: 0.88rem; font-weight: 600;">Application submitted successfully!</span>
</div>

<style>
/* Filter Pills Styling */
.filter-pill {
    background: #f1f5f2;
    color: #3b5343;
    border: none;
    border-radius: 9999px;
    padding: 8px 22px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    outline: none;
}
.filter-pill:hover {
    background: #e2ede5;
    color: #1c4b32;
}
.filter-pill.active {
    background: #1c4b32 !important;
    color: #ffffff !important;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(28, 75, 50, 0.18);
}

/* Apply Now Pill Button Styling */
.apply-btn-pill {
    background: #1c4b32;
    color: #ffffff;
    border: none;
    border-radius: 9999px;
    padding: 11px 26px;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 2px 6px rgba(28, 75, 50, 0.12);
}
.apply-btn-pill:hover {
    background: #153926;
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(28, 75, 50, 0.22);
}
.apply-btn-pill.applied {
    background: #eaf5ee !important;
    color: #1e7046 !important;
    border: 1px solid #b6dec2 !important;
    box-shadow: none !important;
    cursor: default !important;
    transform: none !important;
}

/* Card Hover Elevation */
.opening-row-card:hover {
    border-color: #d1e2d4 !important;
    box-shadow: 0 6px 18px rgba(28, 75, 50, 0.04) !important;
    transform: translateY(-1px);
}

/* Modal Animations */
@keyframes modalPop {
    from {
        opacity: 0;
        transform: scale(0.96) translateY(8px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}
@keyframes slideUpToast {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .opening-row-card {
        flex-direction: column !important;
        align-items: flex-start !important;
    }
    .apply-btn-pill {
        width: 100% !important;
        justify-content: center !important;
    }
}
</style>

<script>
// Filter State
let currentCategory = 'all';

function filterCategory(category, element) {
    currentCategory = category;

    // Update Pill Active States
    document.querySelectorAll('#openingsFilterGroup .filter-pill').forEach(btn => {
        btn.classList.remove('active');
    });
    if (element) {
        element.classList.add('active');
    }

    // Filter items
    const cards = document.querySelectorAll('#openingsListContainer .opening-row-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const cardCat = card.getAttribute('data-category');
        if (category === 'all' || cardCat === category) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Show/hide empty state
    const filterEmpty = document.getElementById('filterEmptyState');
    if (filterEmpty) {
        filterEmpty.style.display = visibleCount === 0 ? 'block' : 'none';
    }
}

// Sorting logic
function sortOpenings(criteria) {
    const container = document.getElementById('openingsListContainer');
    const cards = Array.from(container.querySelectorAll('.opening-row-card'));
    if (!cards.length) return;

    cards.sort((a, b) => {
        if (criteria === 'latest') {
            const orderA = parseInt(a.getAttribute('data-order') || 0, 10);
            const orderB = parseInt(b.getAttribute('data-order') || 0, 10);
            return orderA - orderB;
        } else if (criteria === 'oldest') {
            const orderA = parseInt(a.getAttribute('data-order') || 0, 10);
            const orderB = parseInt(b.getAttribute('data-order') || 0, 10);
            return orderB - orderA;
        } else if (criteria === 'deadline') {
            const deadA = new Date(a.getAttribute('data-deadline') || '2099-12-31').getTime();
            const deadB = new Date(b.getAttribute('data-deadline') || '2099-12-31').getTime();
            return deadA - deadB;
        }
        return 0;
    });

    cards.forEach(card => container.appendChild(card));
}

// Modal handling
let activeOpening = null;

function openApplyModal(jobData) {
    activeOpening = jobData;
    document.getElementById('modalJobId').value = jobData.id;
    document.getElementById('modalTargetEmail').value = jobData.email || '';
    document.getElementById('modalJobTitle').textContent = 'Apply for ' + jobData.title;
    document.getElementById('modalCompanyMeta').textContent = jobData.company + ' • ' + jobData.location + ' • ' + jobData.type;
    
    const backdrop = document.getElementById('applyModalBackdrop');
    backdrop.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeApplyModal() {
    const backdrop = document.getElementById('applyModalBackdrop');
    backdrop.style.display = 'none';
    document.body.style.overflow = '';
}

// Close when clicking outside modal box
document.getElementById('applyModalBackdrop')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeApplyModal();
    }
});

// Submit Application
function submitApplication(e) {
    e.preventDefault();
    if (!activeOpening) return;

    const btn = document.getElementById('submitApplyBtn');
    btn.disabled = true;
    btn.innerHTML = 'Submitting...';

    setTimeout(() => {
        closeApplyModal();
        btn.disabled = false;
        btn.innerHTML = '<span>Submit Application</span> <span>&rarr;</span>';

        // Update opening row button to "Applied ✓"
        const applyBtn = document.getElementById('applyBtn-' + activeOpening.id);
        if (applyBtn) {
            applyBtn.classList.add('applied');
            applyBtn.innerHTML = '<span>Applied</span> <span style="font-weight: 800;">✓</span>';
            applyBtn.disabled = true;
        }

        // Show Toast
        showToast('Application successfully submitted for ' + activeOpening.title + '!');
    }, 600);
}

function showToast(msg) {
    const toast = document.getElementById('applyToast');
    const msgEl = document.getElementById('toastMessage');
    if (!toast || !msgEl) return;
    msgEl.textContent = msg;
    toast.style.display = 'flex';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 4500);
}
</script>
