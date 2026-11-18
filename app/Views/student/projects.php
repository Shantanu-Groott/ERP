<?php
/**
 * Student Industry Projects & Capstones Desk
 * Matches Kalavanta Edutech openings design structure with All, Current, Past filter pills, sort bar, custom mint icons, and application modal.
 */
?>

<div class="projects-desk-wrapper" style="max-width: 1200px; margin: 0 auto;">

    <!-- Main White Container Card -->
    <div style="background: #ffffff; border: 1px solid #e5ece6; border-radius: 22px; padding: 24px 28px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);">
        
        <!-- Filter Pills & Sort Bar -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 22px;">
            
            <!-- Filter Pills (All, Current, Past) -->
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;" id="projectsFilterGroup">
                <button type="button" class="filter-pill active" data-category="all" onclick="filterProjectCategory('all', this)">
                    All
                </button>
                <button type="button" class="filter-pill" data-category="current" onclick="filterProjectCategory('current', this)">
                    Current
                </button>
                <button type="button" class="filter-pill" data-category="past" onclick="filterProjectCategory('past', this)">
                    Past
                </button>
            </div>

            <!-- Sort By Dropdown -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 0.88rem; color: #627467; font-weight: 500;">Sort by:</span>
                <div style="position: relative; display: inline-block;">
                    <select id="projectSortSelect" onchange="sortProjects(this.value)" style="appearance: none; -webkit-appearance: none; background: #ffffff; border: 1px solid #dbe5db; border-radius: 9999px; padding: 7px 34px 7px 16px; font-size: 0.84rem; font-weight: 600; color: #183324; cursor: pointer; outline: none; transition: border-color 0.2s;">
                        <option value="latest">Latest First</option>
                        <option value="duration_short">Shortest Duration</option>
                        <option value="duration_long">Longest Duration</option>
                    </select>
                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #627467; font-size: 0.72rem;">▼</span>
                </div>
            </div>

        </div>

        <!-- Projects Items List -->
        <div id="projectsListContainer" style="display: flex; flex-direction: column; gap: 14px;">
            <?php if (empty($projects)): ?>
                <div id="noProjectsEmptyState" style="text-align: center; padding: 48px 20px; background: #fafcfa; border: 1px dashed #d1ded4; border-radius: 18px;">
                    <div style="width: 50px; height: 50px; border-radius: 12px; background: #eaf5ee; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; color: #2d6a4f;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <p style="font-size: 1rem; font-weight: 700; color: #183324; margin: 0 0 4px 0;">No active projects found</p>
                    <p style="font-size: 0.84rem; color: #627467; margin: 0;">Check back soon for freshly released industry briefs.</p>
                </div>
            <?php else: ?>
                <?php foreach ($projects as $index => $pr): ?>
                    <?php
                        $cat = $pr['category'] ?? 'current';
                        $iconType = $pr['icon_type'] ?? 'database';
                        $isPast = !empty($pr['is_past']) || $cat === 'past';
                        $catLabel = $isPast ? 'Past / Completed' : 'Current Project';
                        // Parse duration weeks for sorting
                        preg_match('/(\d+)\s*Week/i', $pr['engagement'] ?? '', $durMatch);
                        $weeks = !empty($durMatch[1]) ? (int)$durMatch[1] : 10;
                    ?>
                    <div class="project-row-card" 
                         data-id="<?= (int)$pr['id'] ?>" 
                         data-category="<?= htmlspecialchars($cat) ?>" 
                         data-duration="<?= $weeks ?>"
                         data-order="<?= $index ?>"
                         style="background: #ffffff; border: 1px solid #eef3ef; border-radius: 18px; padding: 22px 24px; display: flex; align-items: center; justify-content: space-between; gap: 20px; transition: all 0.2s ease;">
                        
                        <!-- Left: Mint Icon + Content -->
                        <div style="display: flex; align-items: center; gap: 20px; flex: 1; min-width: 0;">
                            
                            <!-- Mint Icon Box -->
                            <div style="width: 64px; height: 64px; min-width: 64px; border-radius: 16px; background: #eaf5ee; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #2d6a4f;">
                                <?php if ($iconType === 'shield'): ?>
                                    <!-- Security Shield Icon (Cybersecurity) -->
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        <path d="M9 12l2 2 4-4"></path>
                                    </svg>
                                <?php elseif ($iconType === 'cloud'): ?>
                                    <!-- Cloud & DevOps Icon -->
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path>
                                    </svg>
                                <?php else: ?>
                                    <!-- Database / Ledger Engine Icon -->
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                                    </svg>
                                <?php endif; ?>
                            </div>

                            <!-- Details Column -->
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 3px;">
                                    <h3 style="font-size: 1.15rem; font-weight: 800; color: #183324; margin: 0; letter-spacing: -0.2px;">
                                        <?= htmlspecialchars($pr['title']) ?>
                                    </h3>
                                    <?php if ($isPast): ?>
                                        <span style="font-size: 0.68rem; font-weight: 700; background: #e2ece4; color: #2d6a4f; padding: 2px 8px; border-radius: 9999px; text-transform: uppercase; letter-spacing: 0.5px;">Past Project</span>
                                    <?php endif; ?>
                                </div>
                                <p style="font-size: 0.88rem; color: #627467; margin: 0 0 10px 0; font-weight: 500; line-height: 1.4;">
                                    <?= htmlspecialchars($pr['description']) ?>
                                </p>
                                
                                <!-- Meta Row: Company/Category + Location + Duration + Tech Stack -->
                                <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 18px; font-size: 0.82rem; color: #627467; font-weight: 600;">
                                    
                                    <!-- Partner / Category Tag -->
                                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                        </svg>
                                        <span><?= htmlspecialchars($pr['company_name']) ?> (<?= htmlspecialchars($pr['project_type']) ?>)</span>
                                    </span>

                                    <!-- Location Tag with Pin -->
                                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <span><?= htmlspecialchars($pr['location']) ?></span>
                                    </span>

                                    <!-- Duration Tag with Clock -->
                                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        <span>Duration: <?= htmlspecialchars($pr['engagement']) ?></span>
                                    </span>

                                    <!-- Tech Stack Tag -->
                                    <?php if (!empty($pr['skills'])): ?>
                                        <span style="display: inline-flex; align-items: center; gap: 6px; color: #2d6a4f; background: #eaf5ee; padding: 3px 10px; border-radius: 6px; font-size: 0.76rem; font-weight: 700;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                                            <span><?= htmlspecialchars($pr['skills']) ?></span>
                                        </span>
                                    <?php endif; ?>

                                </div>
                            </div>

                        </div>

                        <!-- Right: Action Button -->
                        <div style="flex-shrink: 0;">
                            <?php if ($isPast): ?>
                                <button type="button" 
                                        class="project-btn-pill applied"
                                        onclick="openProjectModal(<?= htmlspecialchars(json_encode([
                                            'id' => (int)$pr['id'],
                                            'title' => $pr['title'],
                                            'company' => $pr['company_name'],
                                            'type' => $pr['project_type'],
                                            'location' => $pr['location'],
                                            'engagement' => $pr['engagement'],
                                            'skills' => $pr['skills'] ?? '',
                                            'email' => $pr['contact_email'] ?? '',
                                            'is_past' => true
                                        ])) ?>)">
                                    <span>Archived</span>
                                    <span style="font-weight: 800;">✓</span>
                                </button>
                            <?php else: ?>
                                <button type="button" 
                                        class="project-btn-pill"
                                        id="projectBtn-<?= (int)$pr['id'] ?>"
                                        onclick="openProjectModal(<?= htmlspecialchars(json_encode([
                                            'id' => (int)$pr['id'],
                                            'title' => $pr['title'],
                                            'company' => $pr['company_name'],
                                            'type' => $pr['project_type'],
                                            'location' => $pr['location'],
                                            'engagement' => $pr['engagement'],
                                            'skills' => $pr['skills'] ?? '',
                                            'email' => $pr['contact_email'] ?? '',
                                            'is_past' => false
                                        ])) ?>)">
                                    <span>Join Project</span>
                                    <span style="font-size: 1.05rem; line-height: 1;">&rarr;</span>
                                </button>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Client Filter Empty State (Hidden by default) -->
            <div id="projectFilterEmptyState" style="display: none; text-align: center; padding: 48px 20px; background: #fafcfa; border: 1px dashed #d1ded4; border-radius: 18px;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: #eaf5ee; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; color: #2d6a4f;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <p style="font-size: 1rem; font-weight: 700; color: #183324; margin: 0 0 4px 0;">No projects in this view</p>
                <p style="font-size: 0.84rem; color: #627467; margin: 0 0 16px 0;">Switch to All or another filter to view project briefs.</p>
                <button type="button" onclick="filterProjectCategory('all', document.querySelector('#projectsFilterGroup .filter-pill[data-category=\'all\']'))" style="background: #1c4b32; color: #ffffff; border: none; border-radius: 9999px; padding: 8px 20px; font-size: 0.84rem; font-weight: 700; cursor: pointer;">
                    View All Projects
                </button>
            </div>
        </div>

    </div>

</div>

<!-- Application Modal Dialog -->
<div id="projectModalBackdrop" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div id="projectModalCard" style="background: #ffffff; border-radius: 22px; width: 100%; max-width: 540px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid #e2e8f0; overflow: hidden; animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
        
        <!-- Modal Top Bar -->
        <div style="padding: 24px 28px 18px 28px; border-bottom: 1px solid #f1f5f2; display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #eaf5ee; display: flex; align-items: center; justify-content: center; color: #2d6a4f; flex-shrink: 0;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 id="modalProjectTitle" style="font-size: 1.15rem; font-weight: 800; color: #183324; margin: 0; line-height: 1.2;">Join Industry Project</h3>
                    <p id="modalProjectMeta" style="font-size: 0.82rem; color: #627467; margin: 3px 0 0 0; font-weight: 500;">Company • Duration • Location</p>
                </div>
            </div>
            <button type="button" onclick="closeProjectModal()" style="background: transparent; border: none; font-size: 1.4rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 4px; border-radius: 8px;" title="Close">&times;</button>
        </div>

        <!-- Modal Form Body -->
        <form id="projectApplyForm" onsubmit="submitProjectApplication(event)" style="padding: 24px 28px;">
            <input type="hidden" id="modalProjectId" name="project_id" value="">
            <input type="hidden" id="modalProjectEmail" name="contact_email" value="">

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
                        <label style="display: block; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #2d4a37; margin-bottom: 6px;">Collaboration Mode</label>
                        <select id="projectTeamMode" style="width: 100%; box-sizing: border-box; background: #ffffff; border: 1px solid #dbe5db; border-radius: 10px; padding: 10px 14px; font-size: 0.88rem; color: #183324; outline: none;">
                            <option value="solo">Individual Contributor</option>
                            <option value="pair">Pair Collaboration</option>
                            <option value="team">Team Lead / Member</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #2d4a37; margin-bottom: 6px;">GitHub Profile / Project Repo</label>
                    <input type="url" id="projectRepoUrl" placeholder="https://github.com/shantanu/..." style="width: 100%; box-sizing: border-box; background: #ffffff; border: 1px solid #dbe5db; border-radius: 10px; padding: 10px 14px; font-size: 0.88rem; color: #183324; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #2d4a37; margin-bottom: 6px;">Statement of Approach & Background</label>
                    <textarea id="projectNote" rows="3" placeholder="Briefly describe your familiarity with the required tech stack and proposed implementation..." style="width: 100%; box-sizing: border-box; background: #ffffff; border: 1px solid #dbe5db; border-radius: 10px; padding: 10px 14px; font-size: 0.88rem; color: #183324; outline: none; resize: vertical;"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div style="margin-top: 24px; display: flex; align-items: center; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeProjectModal()" style="background: transparent; border: 1px solid #dbe5db; border-radius: 9999px; padding: 9px 20px; font-size: 0.85rem; font-weight: 600; color: #627467; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" id="submitProjectBtn" style="background: #1c4b32; color: #ffffff; border: none; border-radius: 9999px; padding: 10px 24px; font-size: 0.88rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(28, 75, 50, 0.2);">
                    <span>Submit Application</span>
                    <span>&rarr;</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Toast Feedback Notification -->
<div id="projectToast" style="position: fixed; bottom: 30px; right: 30px; background: #1c4b32; color: #ffffff; padding: 14px 22px; border-radius: 14px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); display: none; align-items: center; gap: 12px; z-index: 10000; animation: slideUpToast 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#86efac" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
    <span id="projectToastMessage" style="font-size: 0.88rem; font-weight: 600;">Project application submitted successfully!</span>
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

/* Join Project Pill Button Styling */
.project-btn-pill {
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
.project-btn-pill:hover {
    background: #153926;
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(28, 75, 50, 0.22);
}
.project-btn-pill.applied {
    background: #eaf5ee !important;
    color: #1e7046 !important;
    border: 1px solid #b6dec2 !important;
    box-shadow: none !important;
    cursor: default !important;
    transform: none !important;
}

/* Card Hover Elevation */
.project-row-card:hover {
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
    .project-row-card {
        flex-direction: column !important;
        align-items: flex-start !important;
    }
    .project-btn-pill {
        width: 100% !important;
        justify-content: center !important;
    }
}
</style>

<script>
// Filter State
let currentProjectCategory = 'all';

function filterProjectCategory(category, element) {
    currentProjectCategory = category;

    // Update Pill Active States
    document.querySelectorAll('#projectsFilterGroup .filter-pill').forEach(btn => {
        btn.classList.remove('active');
    });
    if (element) {
        element.classList.add('active');
    }

    // Filter items
    const cards = document.querySelectorAll('#projectsListContainer .project-row-card');
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
    const filterEmpty = document.getElementById('projectFilterEmptyState');
    if (filterEmpty) {
        filterEmpty.style.display = visibleCount === 0 ? 'block' : 'none';
    }
}

// Sorting logic
function sortProjects(criteria) {
    const container = document.getElementById('projectsListContainer');
    const cards = Array.from(container.querySelectorAll('.project-row-card'));
    if (!cards.length) return;

    cards.sort((a, b) => {
        if (criteria === 'latest') {
            const orderA = parseInt(a.getAttribute('data-order') || 0, 10);
            const orderB = parseInt(b.getAttribute('data-order') || 0, 10);
            return orderA - orderB;
        } else if (criteria === 'duration_short') {
            const durA = parseInt(a.getAttribute('data-duration') || 0, 10);
            const durB = parseInt(b.getAttribute('data-duration') || 0, 10);
            return durA - durB;
        } else if (criteria === 'duration_long') {
            const durA = parseInt(a.getAttribute('data-duration') || 0, 10);
            const durB = parseInt(b.getAttribute('data-duration') || 0, 10);
            return durB - durA;
        }
        return 0;
    });

    cards.forEach(card => container.appendChild(card));
}

// Modal handling
let activeProject = null;

function openProjectModal(projectData) {
    activeProject = projectData;
    document.getElementById('modalProjectId').value = projectData.id;
    document.getElementById('modalProjectEmail').value = projectData.email || '';
    document.getElementById('modalProjectTitle').textContent = (projectData.is_past ? 'Project Archive: ' : 'Join ') + projectData.title;
    document.getElementById('modalProjectMeta').textContent = projectData.company + ' • ' + projectData.engagement + ' • ' + projectData.location;

    const submitBtn = document.getElementById('submitProjectBtn');
    if (projectData.is_past) {
        submitBtn.style.display = 'none';
    } else {
        submitBtn.style.display = 'inline-flex';
    }
    
    const backdrop = document.getElementById('projectModalBackdrop');
    backdrop.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeProjectModal() {
    const backdrop = document.getElementById('projectModalBackdrop');
    backdrop.style.display = 'none';
    document.body.style.overflow = '';
}

// Close when clicking outside modal box
document.getElementById('projectModalBackdrop')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeProjectModal();
    }
});

// Submit Application
function submitProjectApplication(e) {
    e.preventDefault();
    if (!activeProject) return;

    const btn = document.getElementById('submitProjectBtn');
    btn.disabled = true;
    btn.innerHTML = 'Submitting...';

    setTimeout(() => {
        closeProjectModal();
        btn.disabled = false;
        btn.innerHTML = '<span>Submit Application</span> <span>&rarr;</span>';

        // Update opening row button to "Applied ✓"
        const applyBtn = document.getElementById('projectBtn-' + activeProject.id);
        if (applyBtn) {
            applyBtn.classList.add('applied');
            applyBtn.innerHTML = '<span>Applied</span> <span style="font-weight: 800;">✓</span>';
            applyBtn.disabled = true;
        }

        // Show Toast
        showProjectToast('Application submitted for ' + activeProject.title + '!');
    }, 600);
}

function showProjectToast(msg) {
    const toast = document.getElementById('projectToast');
    const msgEl = document.getElementById('projectToastMessage');
    if (!toast || !msgEl) return;
    msgEl.textContent = msg;
    toast.style.display = 'flex';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 4500);
}
</script>
