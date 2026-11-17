<?php

namespace App\Controllers\Student;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Core\Database;

class CourseController
{
    /**
     * Display the student curriculum with clean course selector,
     * enrolled vs locked states, and learning modal contents.
     */
    public function index(Request $request, Response $response): void
    {
        $userId = (int)Session::get('user_id');
        $student = Student::findByUserId($userId);

        $db = Database::getConnection();
        $subjects = [];

        if ($student) {
            $stmt = $db->query("
                SELECT s.*, d.name as department_name, d.code as department_code
                FROM subjects s
                JOIN departments d ON s.department_id = d.id
                ORDER BY s.code ASC
            ");
            $subjects = $stmt->fetchAll();

            // Order tracks matching the official curriculum sequence: CYB tracks first, then CS tracks
            $priority = [
                'CYB301' => 1,
                'CYB302' => 2,
                'CYB303' => 3,
                'CYB304' => 4,
                'CS301' => 5,
                'CS302' => 6,
                'CS303' => 7,
                'CS304' => 8,
            ];
            usort($subjects, function ($a, $b) use ($priority) {
                return ($priority[$a['code']] ?? 99) <=> ($priority[$b['code']] ?? 99);
            });
        }

        // Initialize or retrieve student enrolled/purchased courses
        $enrolledCourses = Session::get('enrolled_courses');
        if (!is_array($enrolledCourses)) {
            // Shantanu is enrolled in the 4 core Cybersecurity tracks by default
            $enrolledCourses = ['CYB301', 'CYB302', 'CYB303', 'CYB304'];
            Session::set('enrolled_courses', $enrolledCourses);
        }

        // Handle instant purchase / unlock action from query parameter
        if ($request->input('action') === 'buy' && $request->input('track')) {
            $codeToBuy = strtoupper(trim((string)$request->input('track')));
            if (!in_array($codeToBuy, $enrolledCourses, true)) {
                $enrolledCourses[] = $codeToBuy;
                Session::set('enrolled_courses', $enrolledCourses);
            }
            $response->redirect('/student/curriculum?track=' . urlencode($codeToBuy) . '&unlocked=1');
            return;
        }

        // Active Course - default to CYB302 or requested course
        $track = strtoupper(trim((string)$request->input('course', $request->input('track', 'CYB302'))));
        
        $activeSubject = null;
        foreach ($subjects as $s) {
            if ($s['code'] === $track) {
                $activeSubject = $s;
                break;
            }
        }
        if (!$activeSubject) {
            foreach ($subjects as $s) {
                if ($s['code'] === 'CYB302') {
                    $activeSubject = $s;
                    break;
                }
            }
            if (!$activeSubject && !empty($subjects)) {
                $activeSubject = $subjects[0];
            }
        }

        $activeCode = $activeSubject['code'] ?? 'CYB302';
        $isEnrolled = in_array($activeCode, $enrolledCourses, true);
        $courseName = $activeSubject['name'] ?? 'Ethical Hacking & Pen Testing';

        // Track metadata matching Kalavanta curriculum UI specifications
        $tracksMeta = [
            'CYB301' => [
                'name' => 'Network Defense Essentials',
                'subtitle' => 'Strengthen your network security skills',
                'progress' => 67,
                'status' => 'in_progress',
                'icon' => 'shield',
                'price' => 'Included',
            ],
            'CYB302' => [
                'name' => 'Ethical Hacking & Pen Testing',
                'subtitle' => 'Learn penetration testing techniques',
                'progress' => 50,
                'status' => 'in_progress',
                'icon' => 'hacker',
                'price' => 'Included',
            ],
            'CYB303' => [
                'name' => 'Cryptographic & Data Security',
                'subtitle' => 'Master encryption and data protection',
                'progress' => 75,
                'status' => 'in_progress',
                'icon' => 'key',
                'price' => 'Included',
            ],
            'CYB304' => [
                'name' => 'Incident Response & Forensics',
                'subtitle' => 'Build skills in incident handling and forensics',
                'progress' => 33,
                'status' => 'in_progress',
                'icon' => 'forensics',
                'price' => 'Included',
            ],
            'CS301' => [
                'name' => 'Database Management Systems',
                'subtitle' => 'Relational algebra, SQL optimization and indexing',
                'progress' => 100,
                'status' => 'completed',
                'icon' => 'database',
                'price' => '₹1,499',
            ],
            'CS302' => [
                'name' => 'Computer Networks',
                'subtitle' => 'TCP/IP, routing protocols, and packet switching',
                'progress' => 80,
                'status' => 'in_progress',
                'icon' => 'network',
                'price' => '₹1,299',
            ],
            'CS303' => [
                'name' => 'Theory of Computation',
                'subtitle' => 'Automata, formal languages, and Turing machines',
                'progress' => 45,
                'status' => 'in_progress',
                'icon' => 'theory',
                'price' => '₹1,199',
            ],
            'CS304' => [
                'name' => 'Web Computing & ERP',
                'subtitle' => 'Enterprise workflows, REST architecture and web security',
                'progress' => 90,
                'status' => 'in_progress',
                'icon' => 'web',
                'price' => '₹1,499',
            ],
        ];

        // Comprehensive track modules with study lessons & technical materials
        $trackModules = $this->getAllTrackModules();

        // Build composite tracks array
        $allTracks = [];
        foreach ($subjects as $s) {
            $c = $s['code'];
            $meta = $tracksMeta[$c] ?? [
                'name' => $s['name'],
                'subtitle' => 'Core technical track syllabus',
                'progress' => 50,
                'status' => 'in_progress',
                'icon' => 'shield',
                'price' => '₹1,499',
            ];
            $isCurEnrolled = in_array($c, $enrolledCourses, true);
            $allTracks[] = [
                'code' => $c,
                'name' => $meta['name'],
                'subtitle' => $meta['subtitle'],
                'progress' => $isCurEnrolled ? $meta['progress'] : 0,
                'display_progress' => $meta['progress'],
                'status' => $meta['status'],
                'icon' => $meta['icon'],
                'price' => $meta['price'],
                'is_enrolled' => $isCurEnrolled,
                'department_name' => $s['department_name'] ?? 'Computer Engineering',
                'credits' => $s['credits'] ?? 3,
                'instructor_name' => $s['instructor_name'] ?? 'Prof. Robert Miller',
                'modules' => $trackModules[$c] ?? $trackModules['CYB302'],
            ];
        }

        $hasParam = ($request->input('course') !== null && trim((string)$request->input('course')) !== '')
                 || ($request->input('track') !== null && trim((string)$request->input('track')) !== '');
        $initialView = $hasParam ? 'modules' : 'courses';

        View::render('student.curriculum', [
            'title' => 'Curriculum',
            'headerTitle' => 'Curriculum',
            'headerSubtitle' => 'Explore your learning path and course progress',
            'backUrl' => '/student/dashboard',
            'searchPlaceholder' => 'Search modules...',
            'student' => $student,
            'subjects' => $subjects,
            'allTracks' => $allTracks,
            'enrolledCourses' => $enrolledCourses,
            'selectedTrack' => $activeCode,
            'initialView' => $initialView,
            'overallProgress' => 67,
            'enrolledCoursesCount' => count($subjects),
            'completedLabsCount' => 46,
            'pendingLabsCount' => 12,
        ], 'student');
    }

    /**
     * Handle POST course purchase / enrollment action
     */
    public function buy(Request $request, Response $response): void
    {
        $codeToBuy = strtoupper(trim((string)$request->input('code', $request->input('track', ''))));
        if ($codeToBuy !== '') {
            $enrolled = Session::get('enrolled_courses', ['CYB301', 'CYB302', 'CYB303', 'CYB304']);
            if (!in_array($codeToBuy, $enrolled, true)) {
                $enrolled[] = $codeToBuy;
                Session::set('enrolled_courses', $enrolled);
            }
        }
        $response->redirect('/student/curriculum?track=' . urlencode($codeToBuy) . '&unlocked=1');
    }

    /**
     * Master repository of syllabus modules & rich lesson materials
     */
    private function getAllTrackModules(): array
    {
        return [
            // CYB302: Ethical Hacking & Penetration Testing
            'CYB302' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Reconnaissance & OSINT',
                    'progress' => 100,
                    'image' => '/assets/img/curriculum-mod1.png',
                    'action_label' => 'Review Module',
                    'lessons' => [
                        [
                            'code' => '1.1',
                            'title' => 'Introduction to Active & Passive Recon',
                            'status' => 'completed',
                            'duration' => '25 mins',
                            'summary' => 'Distinguish passive information gathering from active network probing and learn how adversaries establish target digital footprints without touching perimeter defenses.',
                            'key_points' => [
                                'Passive OSINT relies on DNS records, certificate transparency logs, and archive scrapers.',
                                'Active reconnaissance generates probe packets that trigger firewall state tables and IDS alerts.',
                                'Establishing legal authorization, scope boundaries, and rules of engagement (RoE).'
                            ],
                            'commands' => "whois example.com\ndig +nocmd example.com any +multiline +noall +answer\namass enum -d example.com -passive",
                            'lab_instructions' => 'Run passive subdomain enumeration on the sandbox domain and submit all discovered live subdomains to the defense dashboard.'
                        ],
                        [
                            'code' => '1.2',
                            'title' => 'Utilizing Shodan & Censys',
                            'status' => 'completed',
                            'duration' => '30 mins',
                            'summary' => 'Search internet-connected IoT devices, web servers, and exposed services using specialized search syntax and API filters.',
                            'key_points' => [
                                'Shodan banner querying: port:443 org:"Example Corp" has_ssl:true',
                                'Censys certificate searching and host fingerprinting.',
                                'Identifying exposed management interfaces (RDP, IPMI, Jenkins, Docker daemons).'
                            ],
                            'commands' => "shodan search --limit 10 'org:\"Example\" port:80,443'\ncensys search 'services.port: 8080 and location.country: \"India\"'",
                            'lab_instructions' => 'Locate the simulated unauthenticated honeypot web administration interface using query filters.'
                        ],
                        [
                            'code' => '1.3',
                            'title' => 'DNS & Subdomain Enumeration',
                            'status' => 'completed',
                            'duration' => '20 mins',
                            'summary' => 'Master DNS zone transfers (AXFR), wordlist brute forcing, and reverse IP DNS mapping.',
                            'key_points' => [
                                'Testing authoritative name servers for unauthenticated AXFR transfers.',
                                'Recursive DNS resolution using Massdns and Gobuster.',
                                'Detecting Wildcard DNS records.'
                            ],
                            'commands' => "dig axfr @ns1.target.local target.local\ngobuster dns -d target.local -w /usr/share/wordlists/subdomains.txt",
                            'lab_instructions' => 'Perform an AXFR attempt on DNS Server 10.0.5.2 and record the exported host records.'
                        ],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: Network Scanning & Service Discovery',
                    'progress' => 75,
                    'image' => '/assets/img/curriculum-mod2.png',
                    'action_label' => 'Resume Learning',
                    'lessons' => [
                        [
                            'code' => '2.1',
                            'title' => 'Understanding Packet Tracing & Flags',
                            'status' => 'completed',
                            'duration' => '30 mins',
                            'summary' => 'Deep dive into TCP 3-way handshakes, SYN, ACK, FIN, RST, and URG packet flags, and how different operating systems respond to malformed probes.',
                            'key_points' => [
                                'TCP State transitions from SYN_SENT to ESTABLISHED.',
                                'SYN Stealth Scans (half-open) bypass basic application logging.',
                                'FIN, NULL, and Xmas scans exploit RFC 793 implementation nuances in BSD/Linux stacks.'
                            ],
                            'commands' => "tshark -i eth0 -f 'tcp[tcpflags] & (tcp-syn) != 0'\ntcpdump -nnvv -c 30 'tcp[tcpflags] & (tcp-rst) != 0'",
                            'lab_instructions' => 'Capture a 100-packet trace during an Nmap SYN sweep and filter by TCP reset flags in Wireshark.'
                        ],
                        [
                            'code' => '2.2',
                            'title' => 'Advanced Nmap Configs & NSE',
                            'status' => 'completed',
                            'duration' => '35 mins',
                            'summary' => 'Execute high-performance port scans, service version detection (-sV), and automate vulnerability discovery using Nmap Scripting Engine (NSE).',
                            'key_points' => [
                                'Optimizing timing templates (-T4) and max-retries for stealth and speed.',
                                'Running NSE vulnerability categories: --script=vuln,auth,default.',
                                'Bypassing basic firewall inspection with MTU packet fragmentation (-f).'
                            ],
                            'commands' => "nmap -sS -sV -p- -T4 -O 192.168.10.0/24\nnmap --script=ssl-heartbleed,http-vuln* -p 443 192.168.10.15",
                            'lab_instructions' => 'Run NSE against target machine 192.168.10.15 to identify vulnerable SSH and Apache server banners.'
                        ],
                        [
                            'code' => '2.3',
                            'title' => 'Active Directory Enumeration',
                            'status' => 'completed',
                            'duration' => '40 mins',
                            'summary' => 'Query LDAP, RPC, and SMB ports on domain controllers to enumerate domain users, groups, and SPNs without domain credentials.',
                            'key_points' => [
                                'RPC client null-session queries (rpcclient -U "" -N).',
                                'Kerberos user pre-authentication enumeration (Kerbrute).',
                                'Extracting Kerberoastable Service Principal Names (SPNs).'
                            ],
                            'commands' => "rpcclient -U '' -N 10.0.1.5 -c 'enumdomusers'\ncrackmapexec smb 10.0.1.0/24 -u 'guest' -p '' --rid-brute",
                            'lab_instructions' => 'Enumerate the list of domain user accounts from DC-01 and isolate accounts with descriptions containing passwords.'
                        ],
                        [
                            'code' => '2.4',
                            'title' => 'Lab: Scanning a Virtual Subnet',
                            'status' => 'in_progress',
                            'duration' => '45 mins',
                            'summary' => 'Practical capstone: Discover all live hosts across a multi-tier isolated subnet, generate an XML report, and map the network topology.',
                            'key_points' => [
                                'CIDR slash-notation routing and gateway discovery.',
                                'Synthesizing port scan results into an actionable attack surface matrix.',
                                'Validating open ports against known vulnerability databases (CVE/NVD).'
                            ],
                            'commands' => "nmap -sn 10.0.50.0/24 -oG live_hosts.txt\nnmap -sV -iL live_hosts.txt -oX subnet_audit.xml",
                            'lab_instructions' => 'Identify the web server running on port 8080 and determine its underlying Linux distribution kernel version.'
                        ],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: Gaining Access & Exploitation',
                    'progress' => 40,
                    'image' => '/assets/img/curriculum-mod3.png',
                    'action_label' => 'Continue Module',
                    'lessons' => [
                        [
                            'code' => '3.1',
                            'title' => 'Vulnerability Assessment',
                            'status' => 'completed',
                            'duration' => '30 mins',
                            'summary' => 'Systematically identify, categorize, and prioritize known vulnerabilities using automated scanners and manual CVE verification.',
                            'key_points' => [
                                'Calculating CVSS v3.1 base, temporal, and environmental scores.',
                                'Correlating service versions with Exploit-DB and Metasploit modules.',
                                'Distinguishing false positives from exploitable conditions.'
                            ],
                            'commands' => "searchsploit \"Apache 2.4.49\"\nsearchsploit -m 50383",
                            'lab_instructions' => 'Match open port 8000 on the target with CVE-2021-41773 path traversal vulnerability.'
                        ],
                        [
                            'code' => '3.2',
                            'title' => 'Intro to Metasploit Framework',
                            'status' => 'completed',
                            'duration' => '35 mins',
                            'summary' => 'Navigate msfconsole, select exploits and auxiliary modules, configure payload handlers, and manage Meterpreter sessions.',
                            'key_points' => [
                                'Exploit lifecycle: auxiliary scanner -> payload generation -> session delivery.',
                                'Staged vs Stageless payloads (meterpreter/reverse_tcp vs meterpreter_reverse_tcp).',
                                'Multi/handler listener configuration.'
                            ],
                            'commands' => "msfconsole -q\nuse exploit/multi/http/tomcat_mgr_upload\nset RHOSTS 10.0.10.45\nset PAYLOAD java/meterpreter/reverse_tcp\nrun",
                            'lab_instructions' => 'Set up a multi-handler listener on port 4444 and successfully catch a test reverse shell.'
                        ],
                        [
                            'code' => '3.3',
                            'title' => 'System Exploitation',
                            'status' => 'not_started',
                            'duration' => '40 mins',
                            'summary' => 'Weaponize verified vulnerabilities against target hosts to obtain interactive command shells.',
                            'key_points' => [
                                'Buffer overflow fundamentals and shellcode execution.',
                                'Command injection in vulnerable web parameters.',
                                'Upgrading simple netcat shells to fully interactive TTY shells with Python pty.'
                            ],
                            'commands' => "python3 -c 'import pty; pty.spawn(\"/bin/bash\")'\nnc -lvnp 9001",
                            'lab_instructions' => 'Execute command injection against the vulnerable parameter and upgrade the received shell to an interactive PTY.'
                        ],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: Post-Exploitation & Reporting',
                    'progress' => 10,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '4.1',
                            'title' => 'Privilege Escalation Basics',
                            'status' => 'completed',
                            'duration' => '35 mins',
                            'summary' => 'Audit local system misconfigurations, SUID binaries, cron jobs, and sudo permissions to escalate privileges to root or NT AUTHORITY\\SYSTEM.',
                            'key_points' => [
                                'Linux SUID binary abuse using GTFOBins.',
                                'Windows unquoted service paths and AlwaysInstallElevated registry keys.',
                                'Automating audit enumeration using LinPEAS and WinPEAS.'
                            ],
                            'commands' => "find / -perm -u=s -type f 2>/dev/null\nsudo -l\ncurl -L https://github.com/carlospolop/PEASS-ng/releases/latest/download/linpeas.sh | sh",
                            'lab_instructions' => 'Locate the misconfigured SUID binary on the target machine and spawn a root shell.'
                        ],
                        [
                            'code' => '4.2',
                            'title' => 'Generating the Security Report',
                            'status' => 'not_started',
                            'duration' => '30 mins',
                            'summary' => 'Draft professional penetration test reports including executive summaries, technical risk matrices, proof-of-concept steps, and remediation roadmaps.',
                            'key_points' => [
                                'Writing high-impact executive summaries for C-suite decision makers.',
                                'Structuring reproducible technical findings with evidence screenshots.',
                                'Providing immediate tactical fixes and long-term strategic architectural defenses.'
                            ],
                            'commands' => "cat findings_template.md | grep -E 'Critical|High|Remediation'",
                            'lab_instructions' => 'Compile findings for the vulnerable Apache service and write a 1-page remediation recommendation.'
                        ],
                        [
                            'code' => '4.3',
                            'title' => 'Practical Capstone Project',
                            'status' => 'not_started',
                            'duration' => '60 mins',
                            'summary' => 'End-to-end simulated audit: from external OSINT through network exploitation and internal lateral movement to formal technical debrief.',
                            'key_points' => [
                                'Autonomous penetration test execution following PTES standard.',
                                'Defense avoidance and maintaining operational security.',
                                'Final capstone defense with Prof. Robert Miller.'
                            ],
                            'commands' => "ping -c 3 gateway.corp.local\n./run_capstone_harness.sh",
                            'lab_instructions' => 'Complete the 3-flag capture in the capstone virtual lab environment and submit the final audit report.'
                        ],
                    ]
                ],
            ],

            // CYB301: Network Defense Essentials
            'CYB301' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Defense-in-Depth Fundamentals',
                    'progress' => 100,
                    'image' => '/assets/img/course-network.png',
                    'action_label' => 'Review Module',
                    'lessons' => [
                        [
                            'code' => '1.1',
                            'title' => 'OSI Layer Hardening & Packet Inspection',
                            'status' => 'completed',
                            'duration' => '25 mins',
                            'summary' => 'Establish security controls across OSI layers 2 through 7 to prevent single points of defensive failure.',
                            'key_points' => ['Layer 2 port security & 802.1X', 'Layer 3/4 stateful inspection', 'Layer 7 WAF inspection'],
                            'commands' => "iptables -L -n -v\nsysctl -p /etc/sysctl.conf",
                            'lab_instructions' => 'Configure sysctl kernel flags to drop ICMP redirects and ignore broadcast ping packets.'
                        ],
                        [
                            'code' => '1.2',
                            'title' => 'Stateful Firewall Rules & NAT Traversal',
                            'status' => 'completed',
                            'duration' => '30 mins',
                            'summary' => 'Write production-grade iptables, nftables, and pfSense rules enforcing least-privilege traffic flow.',
                            'key_points' => ['State tracking: ESTABLISHED, RELATED', 'SNAT/DNAT port forwarding', 'Egress traffic filtering'],
                            'commands' => "iptables -A INPUT -m conntrack --ctstate ESTABLISHED,RELATED -j ACCEPT\niptables -P INPUT DROP",
                            'lab_instructions' => 'Create a default-deny ingress policy allowing only inbound SSH from the management subnet 10.0.1.0/24.'
                        ],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: Snort IDS & Traffic Analysis',
                    'progress' => 80,
                    'image' => '/assets/img/curriculum-mod1.png',
                    'action_label' => 'Resume Learning',
                    'lessons' => [
                        [
                            'code' => '2.1',
                            'title' => 'Writing Custom Snort Rule Signatures',
                            'status' => 'completed',
                            'duration' => '30 mins',
                            'summary' => 'Craft pattern-matching signatures to detect custom malware payloads, SQL injections, and buffer overflows.',
                            'key_points' => ['Header actions: alert, log, drop', 'Payload options: content, depth, offset', 'PCRE regex in signatures'],
                            'commands' => "alert tcp any any -> 10.0.0.0/24 80 (msg:\"SQLi Attempt\"; content:\"' OR '1'='1\"; sid:100001;)",
                            'lab_instructions' => 'Write a Snort rule that alerts on inbound HTTP GET requests containing the string "/etc/passwd".'
                        ],
                        [
                            'code' => '2.2',
                            'title' => 'Analyzing PCAP Streams with Wireshark',
                            'status' => 'completed',
                            'duration' => '35 mins',
                            'summary' => 'Extract credentials, reassemble corrupted streams, and filter anomalous packet timing.',
                            'key_points' => ['Display filter syntax: ip.addr, tcp.port, http.request', 'Follow TCP stream analysis', 'Exporting carved HTTP objects'],
                            'commands' => "tshark -r capture.pcap -Y 'http.request.method == \"POST\"' -T fields -e http.file_data",
                            'lab_instructions' => 'Analyze the provided network capture and extract the cleartext credentials submitted to the login portal.'
                        ],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: VPN Tunnels & Endpoint Security',
                    'progress' => 25,
                    'image' => '/assets/img/course-crypto.png',
                    'action_label' => 'Continue Module',
                    'lessons' => [
                        [
                            'code' => '3.1',
                            'title' => 'IPSec, WireGuard & OpenVPN Protocols',
                            'status' => 'completed',
                            'duration' => '30 mins',
                            'summary' => 'Deploy cryptographically verified site-to-site and road-warrior encrypted tunnels.',
                            'key_points' => ['IKEv2 Diffie-Hellman phase 1 & 2', 'WireGuard Noise protocol handshake', 'Mutual TLS authentication'],
                            'commands' => "wg-quick up wg0\nopenvpn --config client.ovpn",
                            'lab_instructions' => 'Establish a WireGuard peer-to-peer connection between the gateway and student jump box.'
                        ],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: Perimeter Incident Readiness',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '4.1',
                            'title' => 'Automated Threat Intelligence Feeds',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Integrate STIX/TAXII indicator feeds directly into perimeter routing blackholes (BGP Null routing).',
                            'key_points' => ['MISP platform data interchange', 'IP reputation blocklists', 'Automated blackhole routing'],
                            'commands' => "fail2ban-client status sshd\nip route add blackhole 198.51.100.0/24",
                            'lab_instructions' => 'Configure Fail2ban to ban IP addresses after 3 consecutive failed SSH login attempts for 24 hours.'
                        ],
                    ]
                ],
            ],

            // CYB303: Cryptographic & Data Security
            'CYB303' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Modern Symmetric Ciphers (AES-256)',
                    'progress' => 100,
                    'image' => '/assets/img/course-crypto.png',
                    'action_label' => 'Review Module',
                    'lessons' => [
                        [
                            'code' => '1.1',
                            'title' => 'AES Block Operations & GCM Mode',
                            'status' => 'completed',
                            'duration' => '25 mins',
                            'summary' => 'Understand Galois/Counter Mode (GCM), authenticated encryption with associated data (AEAD), and IV replay vulnerability.',
                            'key_points' => ['SubBytes, ShiftRows, MixColumns, AddRoundKey', 'GCM authentication tags', 'Never re-use nonces in CTR/GCM mode'],
                            'commands' => "openssl enc -aes-256-gcm -in plaintext.txt -out encrypted.bin -k SecretPass123",
                            'lab_instructions' => 'Encrypt the confidential student payload using AES-256-GCM and verify message authenticity tag.'
                        ],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: Public Key Infrastructure & RSA',
                    'progress' => 85,
                    'image' => '/assets/img/curriculum-mod1.png',
                    'action_label' => 'Resume Learning',
                    'lessons' => [
                        [
                            'code' => '2.1',
                            'title' => 'RSA Prime Generation & Key Exchange',
                            'status' => 'completed',
                            'duration' => '30 mins',
                            'summary' => 'Derive Euler’s totient function, modular inverse computation, and prime factorization hardness.',
                            'key_points' => ['p and q primes -> n = pq', 'Public exponent e = 65537', 'Diffie-Hellman ephemeral exchange (DHE)'],
                            'commands' => "openssl genpkey -algorithm RSA -out private.pem -pkeyopt rsa_keygen_bits:2048\nopenssl rsa -pubout -in private.pem -out public.pem",
                            'lab_instructions' => 'Generate a 2048-bit RSA keypair and sign the student enrollment verification token.'
                        ],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: Hashing, HMAC & Zero-Knowledge Proofs',
                    'progress' => 70,
                    'image' => '/assets/img/curriculum-mod3.png',
                    'action_label' => 'Continue Module',
                    'lessons' => [
                        [
                            'code' => '3.1',
                            'title' => 'Collision Resistance & SHA-3/BLAKE3',
                            'status' => 'completed',
                            'duration' => '30 mins',
                            'summary' => 'Evaluate sponge constructions in Keccak/SHA-3, length-extension vulnerability in SHA-1/2, and HMAC derivation.',
                            'key_points' => ['Avalanche effect validation', 'HMAC-SHA256 key padding', 'Merkle-Damgard weaknesses'],
                            'commands' => "echo -n \"kalavanta\" | sha256sum\necho -n \"payload\" | openssl dgst -sha256 -hmac \"SecretKey\"",
                            'lab_instructions' => 'Compute HMAC authentication signature for the API web hook payload.'
                        ],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: Post-Quantum & TLS 1.3 Handshake',
                    'progress' => 45,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Resume Learning',
                    'lessons' => [
                        [
                            'code' => '4.1',
                            'title' => 'TLS 1.3 1-RTT & 0-RTT Handshake Analysis',
                            'status' => 'in_progress',
                            'duration' => '35 mins',
                            'summary' => 'Audit TLS 1.3 cryptographic suites, ephemeral ECDHE key exchanges, and post-quantum lattice algorithms (ML-KEM/Kyber).',
                            'key_points' => ['Removal of RSA key exchange and static DH', 'Forward secrecy guarantees', 'NIST post-quantum standards'],
                            'commands' => "openssl s_client -connect students.groott.online:443 -tls1_3",
                            'lab_instructions' => 'Verify that the local web server requires TLS 1.3 and uses forward-secret cipher suites.'
                        ],
                    ]
                ],
            ],

            // CYB304: Incident Response & Digital Forensics
            'CYB304' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Incident Triaging & Chain of Custody',
                    'progress' => 100,
                    'image' => '/assets/img/course-incident.png',
                    'action_label' => 'Review Module',
                    'lessons' => [
                        [
                            'code' => '1.1',
                            'title' => 'NIST SP 800-61 Incident Lifecycle',
                            'status' => 'completed',
                            'duration' => '25 mins',
                            'summary' => 'Preparation, Detection, Analysis, Containment, Eradication, and Post-Incident Recovery frameworks.',
                            'key_points' => ['Order of volatility', 'Chain of custody hashing (SHA-256)', 'Hardware write-blockers'],
                            'commands' => "sha256sum evidence_disk.raw > evidence.hash",
                            'lab_instructions' => 'Create a bitstream dd image of the suspect flash drive and calculate verify hash matches.'
                        ],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: Live Memory & RAM Acquisition',
                    'progress' => 60,
                    'image' => '/assets/img/curriculum-mod2.png',
                    'action_label' => 'Resume Learning',
                    'lessons' => [
                        [
                            'code' => '2.1',
                            'title' => 'Volatility 3 Process Triaging',
                            'status' => 'completed',
                            'duration' => '35 mins',
                            'summary' => 'Extract active processes, hidden malicious threads, network sockets, and unencrypted credentials from RAM dumps.',
                            'key_points' => ['pslist, pstree, psscan heuristics', 'Malfind injection discovery', 'Network socket reconstruction with netscan'],
                            'commands' => "vol -f memdump.raw windows.pslist\nvol -f memdump.raw windows.malfind",
                            'lab_instructions' => 'Identify the PID of the injected process and dump the hidden executable payload.'
                        ],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: Disk & File System Analysis',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod3.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '3.1',
                            'title' => 'NTFS $MFT & USN Journal Carving',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Recover deleted artifacts, examine file creation timestamps ($STANDARD_INFORMATION vs $FILE_NAME), and detect timestomping.',
                            'key_points' => ['Master File Table record parsing', 'Detecting anti-forensics timestamp manipulation', 'Prefetch and Amcache execution history'],
                            'commands' => "fls -r -p evidence.img\nistat evidence.img 14285",
                            'lab_instructions' => 'Recover the deleted bash script from the unallocated disk sectors using sleuthkit fls.'
                        ],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: Threat Hunting & MITRE Mapping',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '4.1',
                            'title' => 'Sigma Rules for SIEM Alerts',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Map attacker behaviors directly to the MITRE ATT&CK enterprise matrix and construct automated Sigma alerts.',
                            'key_points' => ['T1059 Command and Scripting Interpreter', 'T1003 OS Credential Dumping', 'Writing Sigma YAML detection rules'],
                            'commands' => "sigmac -t splunk -c tools/config/generic/sysmon.yml rule.yml",
                            'lab_instructions' => 'Convert a Sigma detection rule into an Elasticsearch query and execute across simulated telemetry.'
                        ],
                    ]
                ],
            ],

            // CS301: Database Management Systems (Catalog Course)
            'CS301' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Relational Algebra & Query Optimization',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod1.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '1.1',
                            'title' => 'Relational Calculus & Query Execution Plans',
                            'status' => 'not_started',
                            'duration' => '30 mins',
                            'summary' => 'Understand relational operations (Selection, Projection, Join) and how the SQL query planner calculates cost matrices.',
                            'key_points' => ['Relational equivalence rules', 'Cost-based optimization (CBO)', 'Reading EXPLAIN and EXPLAIN ANALYZE output'],
                            'commands' => "EXPLAIN ANALYZE SELECT * FROM students s JOIN attendance a ON s.id = a.student_id WHERE s.class_id = 1;",
                            'lab_instructions' => 'Analyze the sequential table scan in the query and optimize it with a composite B-tree index.'
                        ],
                        [
                            'code' => '1.2',
                            'title' => 'Advanced Indexing (B+ Trees & Hash Indexes)',
                            'status' => 'not_started',
                            'duration' => '30 mins',
                            'summary' => 'Deep dive into disk page structures, leaf node pointers, clustered vs secondary indexes, and covering indexes.',
                            'key_points' => ['B+ Tree node fan-out and depth', 'Covering index elimination of table lookups', 'Index fragmentation and rebuilding'],
                            'commands' => "CREATE INDEX idx_student_class_roll ON students (class_id, roll_no);",
                            'lab_instructions' => 'Build a covering index for the attendance dashboard query to achieve zero disk seeks.'
                        ],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: Transaction Management & Concurrency',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod2.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '2.1',
                            'title' => 'ACID Properties & Isolation Levels',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Understand dirty reads, non-repeatable reads, phantom reads, and how MVCC handles multi-client transactions.',
                            'key_points' => ['Read Committed vs Repeatable Read vs Serializable', 'Multi-Version Concurrency Control (MVCC)', 'Two-Phase Locking (2PL) and deadlock resolution'],
                            'commands' => "SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;\nSTART TRANSACTION;\nSELECT balance FROM accounts WHERE id = 1 FOR UPDATE;",
                            'lab_instructions' => 'Simulate two concurrent banking transactions and demonstrate deadlock detection in InnoDB.'
                        ],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: Normalization & Schema Design',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod3.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '3.1',
                            'title' => 'Normal Forms (1NF, 2NF, 3NF & BCNF)',
                            'status' => 'not_started',
                            'duration' => '30 mins',
                            'summary' => 'Eliminate insertion, update, and deletion anomalies through systematic functional dependency decomposition.',
                            'key_points' => ['Partial functional dependency removal (2NF)', 'Transitive dependency removal (3NF)', 'Lossless join decomposition'],
                            'commands' => "ALTER TABLE enrollments ADD CONSTRAINT fk_student FOREIGN KEY (student_id) REFERENCES students(id);",
                            'lab_instructions' => 'Decompose the un-normalized course registration spreadsheet into BCNF relational tables.'
                        ],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: Distributed & NoSQL Architecture',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '4.1',
                            'title' => 'CAP Theorem & Replication Topologies',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Compare Consistency, Availability, Partition Tolerance trade-offs across MongoDB, Redis, and MySQL Galera clusters.',
                            'key_points' => ['Primary-replica asynchronous replication', 'Consensus protocols (Raft, Paxos)', 'Document vs Key-Value vs Graph models'],
                            'commands' => "SHOW REPLICA STATUS\\G\nredis-cli INFO replication",
                            'lab_instructions' => 'Deploy a Redis read-through caching layer in front of the student results query.'
                        ],
                    ]
                ],
            ],

            // CS302: Computer Networks (Catalog Course)
            'CS302' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Physical & Data Link Layer Protocols',
                    'progress' => 0,
                    'image' => '/assets/img/course-network.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '1.1',
                            'title' => 'Ethernet Framing & MAC CSMA/CD',
                            'status' => 'not_started',
                            'duration' => '25 mins',
                            'summary' => 'Examine preamble, SFD, payload MTU, FCS CRC-32 checksums, and ARP table resolution.',
                            'key_points' => ['Ethernet II frame structure', 'ARP cache poisoning mechanics', 'VLAN tagging (802.1Q)'],
                            'commands' => "ip link show\narp -a",
                            'lab_instructions' => 'Inspect the Ethernet frame header of an ARP request using tcpdump.'
                        ],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: IPv4/IPv6 & CIDR Subnetting',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod2.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '2.1',
                            'title' => 'VLSM Subnet Calculation & Routing Tables',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Calculate variable length subnet masks, broadcast domains, and longest prefix match routing lookups.',
                            'key_points' => ['Subnet mask bit-shifts', 'RFC 1918 private address spaces', 'Default gateway next-hop forwarding'],
                            'commands' => "ip route show\nipcalc 172.16.50.0/22",
                            'lab_instructions' => 'Subnet a /24 network into four departmental subnets with minimum wasted host space.'
                        ],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: Transport Layer & TCP Congestion Control',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod3.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '3.1',
                            'title' => 'TCP Reno, Cubic & BBR Algorithms',
                            'status' => 'not_started',
                            'duration' => '30 mins',
                            'summary' => 'Slow start, congestion avoidance, fast retransmit, and bandwidth-delay product optimization.',
                            'key_points' => ['Sliding window flow control', 'TCP SYN cookie protection', 'QUIC UDP multiplexing'],
                            'commands' => "sysctl net.ipv4.tcp_congestion_control",
                            'lab_instructions' => 'Benchmark throughput between TCP Cubic and Google BBR under 2% simulated packet loss.'
                        ],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: Routing Protocols (BGP & OSPF)',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '4.1',
                            'title' => 'Border Gateway Protocol (BGP) Inter-AS Routing',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Autonomous Systems, path vector attributes (AS_PATH, Local Pref), and link-state OSPF Dijkstra SPF calculation.',
                            'key_points' => ['Interior vs Exterior gateway protocols', 'OSPF LSA flood and area 0 backbone', 'BGP route hijacking prevention with RPKI'],
                            'commands' => "traceroute -I 8.8.8.8\nwhois -h whois.radb.net 1.1.1.1",
                            'lab_instructions' => 'Trace an autonomous system path across global transit providers using looking glass servers.'
                        ],
                    ]
                ],
            ],

            // CS303: Theory of Computation (Catalog Course)
            'CS303' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Finite Automata & Regular Languages',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod1.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '1.1',
                            'title' => 'Deterministic & Non-Deterministic Automata (DFA, NFA)',
                            'status' => 'not_started',
                            'duration' => '30 mins',
                            'summary' => 'Formal 5-tuple language definitions, state transitions, epsilon-closures, and subset construction equivalence.',
                            'key_points' => ['DFA state machine design', 'NFA to DFA Powerset construction', 'Pumping Lemma for regular languages'],
                            'commands' => "# State machine transition matrix\nQ = {q0, q1, q2}; Sigma = {0, 1}; delta: Q x Sigma -> Q",
                            'lab_instructions' => 'Design a DFA that accepts strings over {0,1} containing an even number of zeroes and odd number of ones.'
                        ],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: Context-Free Grammars & Pushdown Automata',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod2.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '2.1',
                            'title' => 'CFG Derivations & Chomsky Normal Form',
                            'status' => 'not_started',
                            'duration' => '30 mins',
                            'summary' => 'Parse trees, ambiguity in grammars, stack-based PDA transitions, and CYK parsing algorithm.',
                            'key_points' => ['Chomsky hierarchy level 2', 'Pushdown automata stack operations', 'CYK dynamic programming parser'],
                            'commands' => "S -> aSb | epsilon",
                            'lab_instructions' => 'Convert an arithmetic expression grammar into Chomsky Normal Form.'
                        ],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: Turing Machines & Computability',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod3.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '3.1',
                            'title' => 'Turing Machine Tape Models & The Halting Problem',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Church-Turing thesis, multi-tape Turing machines, undecidability, and Alan Turing’s diagonal proof.',
                            'key_points' => ['7-tuple Turing machine configuration', 'Universal Turing Machine (UTM)', 'Rice’s Theorem on semantic properties'],
                            'commands' => "# TM transition: (q_current, read_symbol) -> (q_next, write_symbol, Direction)",
                            'lab_instructions' => 'Trace the execution of a 2-tape Turing machine checking palindromes over {a, b}.'
                        ],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: Complexity Classes (P, NP & NP-Complete)',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '4.1',
                            'title' => 'Polynomial Reductions & Cook-Levin Theorem',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Deterministic vs non-deterministic polynomial time, Boolean satisfiability (SAT), and reduction proofs (3-SAT to CLIQUE).',
                            'key_points' => ['Class P vs Class NP definitions', 'Polynomial-time verifiers', 'Karp’s 21 NP-complete problems'],
                            'commands' => "Reduction: L1 <=p L2 in O(n^k) steps",
                            'lab_instructions' => 'Formulate a polynomial-time reduction from 3-SAT to the Independent Set problem.'
                        ],
                    ]
                ],
            ],

            // CS304: Web Computing & ERP (Catalog Course)
            'CS304' => [
                [
                    'number' => 1,
                    'title' => 'Module 1: Enterprise Web Architecture & Microservices',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod1.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '1.1',
                            'title' => 'REST APIs, Reverse Proxies & Load Balancing',
                            'status' => 'not_started',
                            'duration' => '30 mins',
                            'summary' => 'Architect scalable web systems with Nginx upstream round-robin, stateless REST principles, and HTTP/2 multiplexing.',
                            'key_points' => ['Idempotent HTTP methods (GET, PUT, DELETE)', 'Nginx reverse proxy configuration', 'Horizontal scaling with session offloading'],
                            'commands' => "curl -i -X GET https://api.erp.local/v1/students -H 'Authorization: Bearer <token>'",
                            'lab_instructions' => 'Configure an Nginx reverse proxy routing `/api` requests to a backend PHP-FPM socket pool.'
                        ],
                    ]
                ],
                [
                    'number' => 2,
                    'title' => 'Module 2: ERP Business Workflows & Data Pipelines',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod2.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '2.1',
                            'title' => 'Student Lifecycle, Grading & Fee Ledgers',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Model academic ERP modules: student registration, course prerequisites, double-entry ledger bookkeeping, and automated attendance tracking.',
                            'key_points' => ['Double-entry debits/credits in tuition billing', 'Relational foreign keys and cascading integrity', 'Audit trail triggers for mark changes'],
                            'commands' => "SELECT s.roll_no, SUM(f.amount) as total_due FROM students s JOIN fees f ON s.id = f.student_id GROUP BY s.id;",
                            'lab_instructions' => 'Execute the automated academic reconciliation script to update student term fee balances.'
                        ],
                    ]
                ],
                [
                    'number' => 3,
                    'title' => 'Module 3: Web Security Headers & Session Defenses',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod3.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '3.1',
                            'title' => 'CSP, HSTS, SameSite Cookies & Anti-CSRF',
                            'status' => 'not_started',
                            'duration' => '30 mins',
                            'summary' => 'Implement defence-in-depth headers: Content-Security-Policy nonce enforcement, HttpOnly SameSite=Strict cookies, and cryptographic CSRF tokens.',
                            'key_points' => ['Preventing XSS with strict Content-Security-Policy', 'Synchronizer token pattern for POST requests', 'Subresource Integrity (SRI) for CDN assets'],
                            'commands' => "Strict-Transport-Security: max-age=31536000; includeSubDomains\nX-Content-Type-Options: nosniff",
                            'lab_instructions' => 'Inspect the response headers on the ERP login endpoint and verify SameSite cookie flags.'
                        ],
                    ]
                ],
                [
                    'number' => 4,
                    'title' => 'Module 4: ERP Integrations & Analytics Reporting',
                    'progress' => 0,
                    'image' => '/assets/img/curriculum-mod4.png',
                    'action_label' => 'Start Module',
                    'lessons' => [
                        [
                            'code' => '4.1',
                            'title' => 'Webhooks, Automated Exports & PDF Heraldry',
                            'status' => 'not_started',
                            'duration' => '35 mins',
                            'summary' => 'Build asynchronous export queues, CSV telemetry generation, cryptographic transcript signing, and automated notification webhooks.',
                            'key_points' => ['HMAC-signed webhook dispatches', 'Server-side headless PDF report generation', 'Background job worker queues'],
                            'commands' => "php /var/www/erp/cron/dispatch_attendance_alerts.php",
                            'lab_instructions' => 'Trigger the automated certificate generation pipeline and verify digital signature validity.'
                        ],
                    ]
                ],
            ],
        ];
    }
}
