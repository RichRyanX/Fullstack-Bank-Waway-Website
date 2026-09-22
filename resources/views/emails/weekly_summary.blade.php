<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Mingguan</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #1e293b; color: #ffffff; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 600; letter-spacing: 0.5px; }
        .content { padding: 30px 20px; }
        .greeting { font-size: 16px; color: #334155; margin-bottom: 20px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 30px; }
        .card { background-color: #f1f5f9; border-radius: 8px; padding: 16px; border: 1px solid #e2e8f0; }
        .card .label { font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 4px; }
        .card .value { font-size: 28px; font-weight: 700; color: #0f172a; }
        .card .sub { font-size: 13px; color: #475569; margin-top: 4px; }
        .cta { text-align: center; margin-top: 30px; }
        .cta a { display: inline-block; background-color: #1e293b; color: #ffffff; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 16px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; margin-top: 20px; }
        @media (max-width: 480px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bank Waway CMS</h1>
        </div>
        <div class="content">
            <div class="greeting">Halo Admin, berikut ringkasan aktivitas selama 7 hari terakhir:</div>
            <div class="grid">
                <div class="card">
                    <div class="label">Total Logins</div>
                    <div class="value">{{ $total_logins ?? 0 }}</div>
                    <div class="sub">Percobaan masuk</div>
                </div>
                <div class="card">
                    <div class="label">Failed Security Attempts</div>
                    <div class="value">{{ $failed_attempts ?? 0 }}</div>
                    <div class="sub">Gagal login & ancaman</div>
                </div>
                <div class="card">
                    <div class="label">Audit Logs Recorded</div>
                    <div class="value">{{ $audit_logs ?? 0 }}</div>
                    <div class="sub">Catatan aktivitas</div>
                </div>
                <div class="card">
                    <div class="label">System Status</div>
                    <div class="value">{{ $active_sessions ?? 0 }}</div>
                    <div class="sub">Sesi aktif</div>
                </div>
            </div>
            <div class="cta">
                <a href="{{ url('/admin') }}">Lihat Dashboard</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Bank Waway CMS &bull; Laporan otomatis
        </div>
    </div>
</body>
</html>