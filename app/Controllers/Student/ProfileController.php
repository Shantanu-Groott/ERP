<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Models\User;
use App\Core\Database;

class ProfileController
{
    /**
     * Display the student profile page with profile information card,
     * academic credentials, achievement badges, and GitHub-style activity calendar.
     */
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id', 3);
        $student = Student::findByUserId($userId);
        $user = User::findById($userId);

        // Fetch or default student profile attributes
        $fullName = $user['full_name'] ?? Session::get('user_name', 'Shantanu');
        $email = (!empty($user['email']) && $user['email'] !== 'shantanu@erp.local') 
            ? $user['email'] 
            : Session::get('student_email', 'student@kalavanta.edu');
        $phone = $user['phone'] ?? '+1 555-0102';
        $studentId = 'KE-STU-2025';
        $trackEnrolled = 'Cyber Security';
        $rollNo = $student['roll_no'] ?? 'COMP-2026-001';
        $className = $student['class_name'] ?? 'TE Computer';
        $division = $student['division'] ?? 'A';
        $departmentName = $student['department_name'] ?? 'Computer Engineering';
        $admittedOn = $student['admitted_on'] ?? '2024-08-01';
        
        // Custom student profile settings stored in session
        $bio = Session::get('student_bio', 'Passionate cybersecurity undergraduate and ethical hacking student specializing in network defense, automated vulnerability discovery, and digital forensics.');
        $githubUrl = Session::get('student_github', 'https://github.com/Shantanu-Groott');
        $linkedinUrl = Session::get('student_linkedin', 'https://linkedin.com/in/shantanu');

        // Academic and Lab summary stats
        $stats = [
            'cgpa' => '9.2',
            'attendance_rate' => '92.4%',
            'completed_labs' => 46,
            'enrolled_courses' => 8,
            'study_hours' => 184,
            'current_streak' => 14,
            'longest_streak' => 32,
            'total_contributions' => 348,
        ];

        // Achievement Badges
        $badges = [
            [
                'id' => 'network_sentinel',
                'title' => 'Network Sentinel',
                'category' => 'Network Defense',
                'description' => 'Mastered Layer 2-7 packet inspection, stateful firewall rules, and Snort signature craft.',
                'icon' => 'shield',
                'earned_date' => 'Nov 10, 2026',
                'badge_color' => '#1c4b32',
                'badge_bg' => '#d7e8db',
                'status' => 'Verified Distinction',
            ],
            [
                'id' => 'pentest_specialist',
                'title' => 'Penetration Specialist',
                'category' => 'Offensive Security',
                'description' => 'Scored 100% on Reconnaissance, Shodan OSINT, Active Directory, and NSE scripting audits.',
                'icon' => 'hacker',
                'earned_date' => 'Nov 02, 2026',
                'badge_color' => '#1b4332',
                'badge_bg' => '#d8f3dc',
                'status' => 'Verified Distinction',
            ],
            [
                'id' => 'crypto_vanguard',
                'title' => 'Cryptographic Vanguard',
                'category' => 'Data Protection',
                'description' => 'Successfully audited AES-256 GCM AEAD and 2048-bit RSA ephemeral key exchanges.',
                'icon' => 'key',
                'earned_date' => 'Oct 28, 2026',
                'badge_color' => '#2d6a4f',
                'badge_bg' => '#e2ece4',
                'status' => 'Verified Distinction',
            ],
            [
                'id' => 'bug_hunter',
                'title' => 'Bug Bounty Hunter',
                'category' => 'Vulnerability Research',
                'description' => 'Discovered and remediated 5 high-severity vulnerabilities in simulated enterprise environments.',
                'icon' => 'target',
                'earned_date' => 'Oct 15, 2026',
                'badge_color' => '#40916c',
                'badge_bg' => '#e8f5e9',
                'status' => 'Verified Distinction',
            ],
            [
                'id' => 'honor_roll',
                'title' => "Dean's Honor Roll",
                'category' => 'Academic Excellence',
                'description' => 'Maintained top 5% academic ranking with >90% practical submission consistency.',
                'icon' => 'trophy',
                'earned_date' => 'Semester 2026-27',
                'badge_color' => '#744210',
                'badge_bg' => '#fef3c7',
                'status' => 'Academic Award',
            ],
            [
                'id' => 'streak_master',
                'title' => '14-Day Consistent Hacker',
                'category' => 'Dedication',
                'description' => 'Maintained consecutive daily hands-on activity in the virtual cyber laboratory.',
                'icon' => 'fire',
                'earned_date' => 'Active Streak',
                'badge_color' => '#9a3412',
                'badge_bg' => '#ffedd5',
                'status' => 'Active Milestone',
            ],
        ];

        // Generate 52-week GitHub-style activity contribution calendar
        $activityData = $this->generateContributionHistory();

        View::render('student.profile', [
            'title' => 'Student Profile',
            'headerTitle' => 'Student Profile',
            'headerSubtitle' => 'View and manage your academic profile, badges, and learning history',
            'backUrl' => '/student/dashboard',
            'fullName' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'studentId' => $studentId,
            'trackEnrolled' => $trackEnrolled,
            'rollNo' => $rollNo,
            'className' => $className,
            'division' => $division,
            'departmentName' => $departmentName,
            'admittedOn' => $admittedOn,
            'bio' => $bio,
            'githubUrl' => $githubUrl,
            'linkedinUrl' => $linkedinUrl,
            'stats' => $stats,
            'badges' => $badges,
            'activityData' => $activityData,
        ], 'student');
    }

    /**
     * Handle Profile Updates (Name, Email, Phone, Bio, Social Links)
     */
    public function update(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id', 3);
        
        $fullName = trim((string)$request->input('full_name', ''));
        $email = trim((string)$request->input('email', ''));
        $phone = trim((string)$request->input('phone', ''));
        $bio = trim((string)$request->input('bio', ''));
        $githubUrl = trim((string)$request->input('github_url', ''));
        $linkedinUrl = trim((string)$request->input('linkedin_url', ''));

        // Update User DB Record if valid
        $updateFields = [];
        if ($fullName !== '') {
            $updateFields['full_name'] = $fullName;
            Session::set('user_name', $fullName);
        }
        if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $updateFields['email'] = $email;
        }
        if ($phone !== '') {
            $updateFields['phone'] = $phone;
        }

        if (!empty($updateFields)) {
            User::update($userId, $updateFields);
        }

        // Persist bio and social profile links in session
        if ($bio !== '') {
            Session::set('student_bio', $bio);
        }
        if ($githubUrl !== '') {
            Session::set('student_github', $githubUrl);
        }
        if ($linkedinUrl !== '') {
            Session::set('student_linkedin', $linkedinUrl);
        }

        $response->redirect('/student/profile?updated=1');
    }

    /**
     * Generate 52 weeks of GitHub-style activity contribution calendar data
     */
    private function generateContributionHistory(): array
    {
        // 52 weeks, starting 52 weeks ago up to today
        $weeks = [];
        $today = new \DateTime('2026-11-17');
        
        // Start from Monday 52 weeks prior
        $startDate = (clone $today)->modify('-51 weeks')->modify('last monday');
        $currentDate = clone $startDate;

        $totalContributions = 0;
        $monthLabels = [];
        $lastMonth = '';

        for ($w = 0; $w < 52; $w++) {
            $weekDays = [];
            $weekMonth = $currentDate->format('M');
            
            if ($weekMonth !== $lastMonth) {
                $monthLabels[$w] = $weekMonth;
                $lastMonth = $weekMonth;
            }

            for ($d = 0; $d < 7; $d++) {
                $dateStr = $currentDate->format('Y-m-d');
                $displayDate = $currentDate->format('M j, Y');

                // Determine realistic activity based on recent streak & lab submissions
                $daysDiff = (int)$today->diff($currentDate)->format('%r%a');
                
                $count = 0;
                $level = 0;

                if ($daysDiff > 0) {
                    // Future dates
                    $count = 0;
                    $level = 0;
                } elseif ($daysDiff >= -14) {
                    // Current active 14-day streak!
                    $count = rand(3, 8);
                    $level = ($count >= 6) ? 4 : (($count >= 4) ? 3 : 2);
                } else {
                    // Historical distributed activity
                    // Seed deterministic pseudo-random count by day of year
                    $dayOfYear = (int)$currentDate->format('z');
                    $seed = ($dayOfYear * 17 + ($d * 31)) % 100;
                    
                    if ($seed > 40) {
                        $count = ($seed % 6) + 1;
                        if ($count >= 5) $level = 4;
                        elseif ($count >= 3) $level = 3;
                        elseif ($count >= 2) $level = 2;
                        else $level = 1;
                    } else {
                        $count = 0;
                        $level = 0;
                    }
                }

                $totalContributions += $count;

                $weekDays[] = [
                    'date' => $dateStr,
                    'display_date' => $displayDate,
                    'count' => $count,
                    'level' => $level, // 0 = empty, 1 = light, 2 = medium, 3 = high, 4 = max
                ];

                $currentDate->modify('+1 day');
            }

            $weeks[] = $weekDays;
        }

        return [
            'weeks' => $weeks,
            'months' => $monthLabels,
            'total' => $totalContributions,
        ];
    }
}
