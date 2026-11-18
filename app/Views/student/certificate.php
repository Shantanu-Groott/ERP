<?php
/**
 * Kalavanta Edutech - Student Certificates & Credentials Desk
 * Matches Mockup (media_1794998380763_f6d448b2.jpg):
 *  1. Top Filter Pills (All, Course Completion, Event Participation, Others)
 *  2. Linear Certificate Box Cards:
 *     - Custom diploma icon in tinted container (green, lavender, mint) with rosette ribbon seal
 *     - Bold Title & descriptive subtitle
 *     - Vertical divider & "Issued on [Date]" with calendar icon
 *     - Dark green pill "Download" button
 *  3. Interactive Certificate Preview & Print / PDF Modal
 */
$certList = $certificates ?? [];
$studentName = $student['name'] ?? 'Shantanu';
$rollNo = $student['roll_no'] ?? 'KE-STU-2025';
?>

<div class="certificates-container" style="display: flex; flex-direction: column; gap: 20px;">

    <!-- ==================================================== -->
    <!-- 1. TOP FILTER PILLS ROW                              -->
    <!-- ==================================================== -->
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <button type="button" class="cert-filter-pill active" data-filter="all" onclick="filterCerts('all', this)">
            All
        </button>
        <button type="button" class="cert-filter-pill" data-filter="course" onclick="filterCerts('course', this)">
            Course Completion
        </button>
        <button type="button" class="cert-filter-pill" data-filter="event" onclick="filterCerts('event', this)">
            Event Participation
        </button>
        <button type="button" class="cert-filter-pill" data-filter="others" onclick="filterCerts('others', this)">
            Others
        </button>
    </div>

    <!-- ==================================================== -->
    <!-- 2. CERTIFICATE BOXES LIST                            -->
    <!-- ==================================================== -->
    <div id="certificatesList" style="display: flex; flex-direction: column; gap: 14px;">
        <?php foreach ($certList as $c): ?>
            <?php 
                $cJson = htmlspecialchars(json_encode($c), ENT_QUOTES, 'UTF-8');
            ?>
            <div class="cert-box-card" 
                 data-category="<?= htmlspecialchars($c['category']) ?>"
                 style="background: #ffffff; border: 1px solid #eef2ef; border-radius: 18px; padding: 18px 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 18px; transition: all 0.15s ease;">
                
                <!-- Left: Certificate Icon + Title & Description -->
                <div style="display: flex; align-items: center; gap: 18px; flex: 1; min-width: 280px;">
                    
                    <!-- Illustrated Certificate Icon with Rosette Ribbon Seal -->
                    <div style="width: 70px; height: 56px; border-radius: 14px; background: <?= $c['icon_bg'] ?>; border: 1px solid <?= $c['border_color'] ?>; color: <?= $c['icon_color'] ?>; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="42" height="34" viewBox="0 0 42 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Certificate Outer Rect -->
                            <rect x="2" y="2" width="34" height="25" rx="3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <!-- Inner decorative text lines -->
                            <line x1="7" y1="8" x2="18" y2="8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <line x1="7" y1="13" x2="24" y2="13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-opacity="0.8"/>
                            <line x1="7" y1="18" x2="19" y2="18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-opacity="0.8"/>
                            <line x1="7" y1="22" x2="14" y2="22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-opacity="0.8"/>
                            <!-- Rosette Ribbon Badge at Bottom Right -->
                            <g transform="translate(25, 16)">
                                <!-- Ribbon Tails -->
                                <path d="M3 10L1 16L5 14L8 16L6 10" fill="currentColor"/>
                                <path d="M7 10L10 16L6.5 14L4 16L5.5 10" fill="currentColor" opacity="0.9"/>
                                <!-- Seal Circle -->
                                <circle cx="6" cy="6" r="5" fill="#ffffff" stroke="currentColor" stroke-width="2"/>
                                <circle cx="6" cy="6" r="2.2" fill="currentColor"/>
                            </g>
                        </svg>
                    </div>

                    <!-- Title & Description -->
                    <div style="display: flex; flex-direction: column; gap: 3px;">
                        <h4 style="font-size: 0.98rem; font-weight: 700; color: #183324; margin: 0; line-height: 1.35;">
                            <?= htmlspecialchars($c['title']) ?>
                        </h4>
                        <p style="font-size: 0.82rem; color: #627467; margin: 0; line-height: 1.4;">
                            <?= htmlspecialchars($c['description']) ?>
                        </p>
                    </div>
                </div>

                <!-- Right: Vertical Divider + Issued on Date + Download Button -->
                <div style="display: flex; align-items: center; gap: 24px; margin-left: auto; flex-wrap: wrap;">
                    
                    <!-- Subtle Vertical Divider (hidden on very small screens) -->
                    <div class="cert-vertical-divider" style="width: 1px; height: 40px; background: #edf2ed;"></div>

                    <!-- Issued On Date Block -->
                    <div style="display: flex; align-items: center; gap: 10px; min-width: 130px;">
                        <!-- Calendar Outline Icon -->
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#718576" stroke-width="1.8">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-size: 0.72rem; color: #718576; font-weight: 500; line-height: 1.2;">Issued on</span>
                            <strong style="font-size: 0.84rem; color: #183324; font-weight: 700; line-height: 1.2; margin-top: 2px;">
                                <?= htmlspecialchars($c['issued_on']) ?>
                            </strong>
                        </div>
                    </div>

                    <!-- Download Pill Button -->
                    <button type="button" class="btn-cert-download" 
                            onclick="openCertificateModal(<?= $cJson ?>)">
                        <!-- Download Icon -->
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Download</span>
                    </button>

                </div>

            </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- ==================================================== -->
<!-- 3. OFFICIAL CERTIFICATE PREVIEW & PRINT MODAL        -->
<!-- ==================================================== -->
<div id="certificateModal" class="cert-modal-overlay" style="display: none;">
    <div class="cert-modal-container">
        
        <!-- Modal Top Bar -->
        <div class="cert-modal-header">
            <div style="display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#2d6a4f" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span style="font-size: 0.84rem; font-weight: 700; color: #183324;">
                    Official Verified Credential &bull; Kalavanta Edutech
                </span>
            </div>
            <button type="button" class="btn-close-cert-modal" onclick="closeCertificateModal()">&times;</button>
        </div>

        <!-- Certificate Printable Plaque -->
        <div class="cert-modal-body" id="printableCertArea">
            <div style="background: #ffffff; border: 8px double #cbd5e1; border-radius: 20px; padding: 36px 32px; text-align: center; box-shadow: 0 4px 18px rgba(0,0,0,0.04); position: relative;">
                
                <!-- Gold Accent Top Seal -->
                <div style="display: flex; justify-content: center; margin-bottom: 12px;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #fef3c7; border: 2px solid #f59e0b; color: #b45309; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; font-weight: 800;">
                        ★
                    </div>
                </div>

                <!-- Institute Name -->
                <h2 style="font-size: 1.25rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #183324; margin: 0;">
                    Kalavanta Edutech Institute of Technology
                </h2>
                <p style="font-size: 0.72rem; color: #627467; text-transform: uppercase; letter-spacing: 0.8px; margin: 4px 0 16px 0;">
                    Center for Advanced Engineering, Cybersecurity &amp; Systems Architecture
                </p>

                <!-- Certificate Title -->
                <div style="margin: 14px 0;">
                    <span style="font-size: 0.72rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; color: #2d6a4f; font-family: 'JetBrains Mono', monospace;" id="modalCertCode">
                        KLVT-CS-2025-891
                    </span>
                    <h1 style="font-size: 1.6rem; font-weight: 800; color: #183324; margin: 6px 0;" id="modalCertTitle">
                        Course Completion Certificate
                    </h1>
                    <p style="font-size: 0.82rem; color: #718576; font-style: italic; margin: 0;">
                        This official credential certifies that
                    </p>
                </div>

                <!-- Recipient Name -->
                <div style="margin: 12px 0;">
                    <h3 style="font-size: 1.75rem; font-weight: 800; color: #1c4b32; margin: 0; text-decoration: underline; text-decoration-color: #2d6a4f; text-underline-offset: 6px;">
                        <?= htmlspecialchars($studentName) ?>
                    </h3>
                    <p style="font-size: 0.76rem; color: #627467; font-family: 'JetBrains Mono', monospace; margin-top: 6px;">
                        Student ID: <strong><?= htmlspecialchars($rollNo) ?></strong>
                    </p>
                </div>

                <!-- Description -->
                <p style="font-size: 0.86rem; color: #2d4133; max-width: 500px; margin: 12px auto; line-height: 1.5;" id="modalCertDesc">
                    For successfully completing the Cyber Security course
                </p>

                <!-- Signatures Row -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; align-items: flex-end; border-top: 1px solid #edf2ed; padding-top: 20px; margin-top: 24px; font-size: 0.76rem;">
                    <div style="text-align: left;">
                        <div style="font-family: serif; font-style: italic; font-size: 1.05rem; font-weight: 600; color: #183324; border-bottom: 1px solid #cbd5e1; padding-bottom: 2px; display: inline-block;">
                            Robert Miller
                        </div>
                        <p style="font-size: 0.78rem; font-weight: 700; color: #183324; margin: 4px 0 1px 0;">Prof. Robert Miller</p>
                        <p style="font-size: 0.68rem; color: #718576; margin: 0;">Faculty Lead</p>
                    </div>

                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <span style="font-size: 0.7rem; color: #718576; font-weight: 500;">Issued on</span>
                        <strong style="font-size: 0.8rem; color: #183324;" id="modalCertDate">Apr 20, 2025</strong>
                    </div>

                    <div style="text-align: right;">
                        <div style="font-family: serif; font-style: italic; font-size: 1.05rem; font-weight: 600; color: #183324; border-bottom: 1px solid #cbd5e1; padding-bottom: 2px; display: inline-block;">
                            Academic Dean
                        </div>
                        <p style="font-size: 0.78rem; font-weight: 700; color: #183324; margin: 4px 0 1px 0;">Dr. Vikram Malhotra</p>
                        <p style="font-size: 0.68rem; color: #718576; margin: 0;">Director of Academics</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Footer Actions -->
        <div class="cert-modal-footer">
            <button type="button" class="btn-cert-modal-print" onclick="window.print()">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Print / Save as PDF</span>
            </button>
            <button type="button" class="btn-cert-modal-close" onclick="closeCertificateModal()">
                Close
            </button>
        </div>

    </div>
</div>

<!-- ==================================================== -->
<!-- STYLES                                               -->
<!-- ==================================================== -->
<style>
/* Filter Pills */
.cert-filter-pill {
    padding: 7px 18px;
    border-radius: 999px;
    border: 1px solid #e0ece2;
    background: #f4f7f4;
    color: #435b49;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.15s ease;
    white-space: nowrap;
}
.cert-filter-pill.active {
    background: #1c4b32 !important;
    color: #ffffff !important;
    border-color: #1c4b32 !important;
    box-shadow: 0 1px 4px rgba(28, 75, 50, 0.25);
}
.cert-filter-pill:hover:not(.active) {
    background: #e5ece6;
    color: #1c4b32;
}

/* Certificate Card Hover */
.cert-box-card:hover {
    border-color: #c4dbc9 !important;
    box-shadow: 0 4px 14px rgba(28, 75, 50, 0.05) !important;
}

/* Download Button */
.btn-cert-download {
    padding: 8px 24px;
    border-radius: 999px;
    background: #1c4b32;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.82rem;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-family: inherit;
    transition: all 0.15s ease;
    box-shadow: 0 1px 3px rgba(28, 75, 50, 0.2);
    white-space: nowrap;
}
.btn-cert-download:hover {
    background: #143725;
    box-shadow: 0 2px 6px rgba(28, 75, 50, 0.3);
}

/* Modal Overlay & Plaque */
.cert-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(18, 38, 26, 0.5);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.cert-modal-container {
    background: #ffffff;
    border-radius: 22px;
    max-width: 680px;
    width: 100%;
    box-shadow: 0 20px 45px rgba(0,0,0,0.18);
    overflow: hidden;
    border: 1px solid #dce8de;
    animation: certModalUp 0.18s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes certModalUp {
    from { opacity: 0; transform: translateY(12px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.cert-modal-header {
    background: #f4f8f5;
    padding: 16px 22px;
    border-bottom: 1px solid #e2ece4;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.btn-close-cert-modal {
    background: transparent;
    border: none;
    font-size: 1.4rem;
    color: #627467;
    cursor: pointer;
    padding: 2px 6px;
    border-radius: 4px;
    line-height: 1;
}
.btn-close-cert-modal:hover {
    color: #183324;
    background: #e2ece4;
}
.cert-modal-body {
    padding: 24px;
    max-height: 75vh;
    overflow-y: auto;
}
.cert-modal-footer {
    padding: 14px 22px;
    background: #fafcfa;
    border-top: 1px solid #edf2ed;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
.btn-cert-modal-close {
    background: #f3f7f4;
    color: #3b5343;
    border: 1px solid #d5e0d5;
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: background 0.15s ease;
}
.btn-cert-modal-close:hover {
    background: #e5ece6;
}
.btn-cert-modal-print {
    background: #1c4b32;
    color: #ffffff;
    border: none;
    padding: 8px 22px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background 0.15s ease;
}
.btn-cert-modal-print:hover {
    background: #143725;
}

/* Print Rules */
@media print {
    body * {
        visibility: hidden;
    }
    #printableCertArea, #printableCertArea * {
        visibility: visible;
    }
    #printableCertArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 0;
    }
}

/* Responsive adjustment for divider */
@media (max-width: 680px) {
    .cert-vertical-divider {
        display: none !important;
    }
}
</style>

<!-- ==================================================== -->
<!-- JAVASCRIPT LOGIC                                     -->
<!-- ==================================================== -->
<script>
// Filter Certificates
function filterCerts(category, btn) {
    document.querySelectorAll('.cert-filter-pill').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');

    const cards = document.querySelectorAll('.cert-box-card');
    cards.forEach(card => {
        const cat = card.getAttribute('data-category');
        if (category === 'all' || cat === category) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

// Modal open/close
function openCertificateModal(cert) {
    if (!cert) return;

    document.getElementById('modalCertTitle').textContent = cert.title || 'Certificate of Completion';
    document.getElementById('modalCertDesc').textContent = cert.description || '';
    document.getElementById('modalCertDate').textContent = cert.issued_on || '';
    document.getElementById('modalCertCode').textContent = cert.cert_code || 'KLVT-CERT-2025';

    const modal = document.getElementById('certificateModal');
    if (modal) modal.style.display = 'flex';
}

function closeCertificateModal() {
    const modal = document.getElementById('certificateModal');
    if (modal) modal.style.display = 'none';
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('certificateModal');
    if (e.target === modal) closeCertificateModal();
});
window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeCertificateModal();
});
</script>
