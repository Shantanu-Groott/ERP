<div style="display: flex; flex-direction: column; gap: 20px;">
    <!-- Live Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 16px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-family: monospace; font-size: 0.75rem; font-weight: 800; background: rgba(239, 68, 68, 0.12); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.25); padding: 4px 12px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444; animation: pulse 1.5s infinite;"></span>
                LIVE LAB CLASSROOM (HOSTINGER CLOUD)
            </span>
            <h2 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">
                Database Query Optimization & Transaction Audit Lab
            </h2>
        </div>

        <a href="/student/dashboard" class="btn btn-sm" style="background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; text-decoration: none;">
            &larr; Exit Classroom
        </a>
    </div>

    <!-- Live Stage Grid -->
    <div style="background: #090d16; border-radius: 20px; overflow: hidden; border: 1px solid #1e293b; color: #ffffff; display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); min-height: 520px; box-shadow: 0 10px 25px rgba(0,0,0,0.25);">
        
        <!-- Interactive Terminal Sandbox (Stage) -->
        <div style="padding: 24px; display: flex; flex-direction: column; justify-content: space-between; background: #050811; border-right: 1px solid #1e293b;">
            <div style="display: flex; justify-content: space-between; align-items: center; font-family: monospace; font-size: 0.75rem; color: #94a3b8; border-bottom: 1px solid #1e293b; padding-bottom: 10px;">
                <span style="color: #34d399;">student@kalavanta-sandbox:~$ mysql -u student -p -h localhost erp</span>
                <span style="background: #1e293b; padding: 2px 8px; border-radius: 4px; color: #cbd5e1;">Presenter: Prof. Robert Miller</span>
            </div>

            <!-- Terminal Output Window -->
            <div style="background: rgba(0, 0, 0, 0.75); border: 1px solid #1e293b; border-radius: 12px; padding: 18px; font-family: monospace; font-size: 0.8rem; color: #6ee7b7; line-height: 1.6; margin: 20px 0; overflow-x: auto;">
                <p style="color: #64748b;">-- EXPLAIN ANALYZE: High-volume student fee reconciliation query</p>
                <p><span style="color: #38bdf8;">mysql&gt;</span> EXPLAIN SELECT f.id, f.title, u.full_name, SUM(fp.amount) FROM fees f JOIN students s ON f.student_id = s.id JOIN users u ON s.user_id = u.id LEFT JOIN fee_payments fp ON f.id = fp.fee_id GROUP BY f.id;</p>
                <p style="color: #94a3b8; margin-top: 8px;">-&gt; Group aggregate: sum(fp.amount) (cost=2.45 rows=2)</p>
                <p style="color: #94a3b8;">&nbsp;&nbsp;&nbsp;&nbsp;-&gt; Nested loop left join (cost=1.85 rows=2)</p>
                <p style="color: #34d399; margin-top: 8px;">[QUERY AUDIT PASSED] 0.0012 sec. Index coverage verified across primary keys.</p>
            </div>

            <!-- Control Bar -->
            <div style="background: #090d16; border: 1px solid #1e293b; border-radius: 12px; padding: 12px 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn btn-primary btn-sm" style="background: #2563eb; border-radius: 6px;">🎤 Mic Active</button>
                    <button type="button" class="btn btn-sm" style="background: #1e293b; color: #cbd5e1; border-radius: 6px;">📹 Cam Off</button>
                    <button type="button" class="btn btn-sm" style="background: #1e293b; color: #cbd5e1; border-radius: 6px;">✋ Raise Hand</button>
                </div>
                <span style="font-family: monospace; font-size: 0.75rem; color: #94a3b8;">
                    38 Active Lab Peers
                </span>
            </div>
        </div>

        <!-- Live Class Chat Sidebar -->
        <div style="padding: 20px; display: flex; flex-direction: column; justify-content: space-between; background: #0c1220;">
            <div>
                <h4 style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; border-bottom: 1px solid #1e293b; padding-bottom: 12px; margin: 0;">
                    Interactive Session Chat
                </h4>
                <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 16px; font-size: 0.8rem;">
                    <div style="background: rgba(30, 58, 138, 0.35); border: 1px solid #1e3a8a; padding: 10px 12px; border-radius: 8px; color: #bfdbfe;">
                        <strong style="color: #60a5fa;">Prof. Robert Miller:</strong> Welcome to the practical query lab! Run the EXPLAIN statement on your assigned schemas.
                    </div>
                    <div style="background: #1e293b; padding: 10px 12px; border-radius: 8px; color: #e2e8f0;">
                        <strong style="color: #94a3b8;">Karan M.:</strong> Cluster query executed with 0 warnings!
                    </div>
                    <div style="background: #1e293b; padding: 10px 12px; border-radius: 8px; color: #e2e8f0;">
                        <strong style="color: #94a3b8;"><?= htmlspecialchars($student['name'] ?? 'You') ?> (You):</strong> Index verification passed. Ready for next step.
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid #1e293b; padding-top: 14px; margin-top: 20px;">
                <input type="text" placeholder="Type into live session chat..." style="width: 100%; background: #1e293b; border: 1px solid #334155; border-radius: 8px; padding: 10px 14px; font-size: 0.8rem; color: #ffffff; outline: none;">
            </div>
        </div>

    </div>
</div>
