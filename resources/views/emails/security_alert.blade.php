<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringatan Keamanan</title>
</head>
<body style="margin:0; padding:0; background-color:#e2e8f0; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing:antialiased;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#e2e8f0; padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(15,23,42,0.08);">
                    <tr>
                        <td style="background-color:#1e293b; padding:32px 40px; text-align:center;">
                            <div style="font-size:22px; font-weight:700; color:#ffffff; letter-spacing:0.5px;">Bank Waway CMS</div>
                            <div style="display:inline-block; margin-top:16px; background-color:#dc2626; color:#ffffff; font-size:13px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; padding:8px 20px; border-radius:999px;">Peringatan Keamanan</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px 40px 24px 40px;">
                            <h1 style="margin:0 0 12px 0; font-size:22px; font-weight:700; color:#0f172a;">Percobaan Login Gagal Terdeteksi</h1>
                            <p style="margin:0 0 8px 0; font-size:15px; line-height:1.6; color:#475569;">
                                <span style="display:inline-block; background-color:#fef2f2; color:#b91c1c; font-weight:700; font-size:13px; padding:4px 12px; border-radius:6px; margin-right:8px;">URGENSI TINGGI</span>
                            </p>
                            <p style="margin:0; font-size:15px; line-height:1.6; color:#475569;">
                                Sistem mendeteksi <strong style="color:#0f172a;">{{ $attempts }} percobaan login gagal</strong> secara beruntun pada akun admin. Akun telah dikunci sementara demi melindungi keamanan.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 40px 24px 40px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
                                <tr>
                                    <td style="padding:16px 24px 8px 24px; font-size:13px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#1e293b;">Detail Audit</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 24px 8px 24px; font-size:14px; color:#475569;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                            <tr>
                                                <td style="padding:12px 0; border-bottom:1px solid #e2e8f0; font-weight:600; color:#0f172a; width:40%;">Username Akun</td>
                                                <td style="padding:12px 0; border-bottom:1px solid #e2e8f0; color:#475569;">{{ $username }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:12px 0; border-bottom:1px solid #e2e8f0; font-weight:600; color:#0f172a;">Alamat IP</td>
                                                <td style="padding:12px 0; border-bottom:1px solid #e2e8f0; color:#475569;">{{ $ip }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:12px 0; border-bottom:1px solid #e2e8f0; font-weight:600; color:#0f172a;">Perangkat / User Agent</td>
                                                <td style="padding:12px 0; border-bottom:1px solid #e2e8f0; color:#475569;">{{ $user_agent }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:12px 0; border-bottom:1px solid #e2e8f0; font-weight:600; color:#0f172a;">Waktu Kejadian</td>
                                                <td style="padding:12px 0; border-bottom:1px solid #e2e8f0; color:#475569;">{{ $timestamp }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:12px 0; font-weight:600; color:#0f172a;">Status Lockout</td>
                                                <td style="padding:12px 0; color:#b91c1c; font-weight:700;">Terkunci Sementara</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 40px 32px 40px;">
                            <h2 style="margin:0 0 12px 0; font-size:16px; font-weight:700; color:#0f172a;">Tindakan yang Disarankan</h2>
                            <ul style="margin:0; padding-left:20px; font-size:14px; line-height:1.8; color:#475569;">
                                <li>Tinjau log audit untuk melacak seluruh aktivitas login yang mencurigakan.</li>
                                <li>Verifikasi keabsahan alamat IP dan perangkat yang tercatat.</li>
                                <li>Setel ulang kredensial admin bila aktivitas tidak dikenali.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f8fafc; padding:24px 40px; text-align:center; border-top:1px solid #e2e8f0;">
                            <p style="margin:0 0 8px 0; font-size:12px; line-height:1.6; color:#94a3b8;">
                                Email ini dibuat secara otomatis oleh sistem keamanan Bank Waway CMS. Mohon tidak membalas pesan ini.
                            </p>
                            <p style="margin:0 0 8px 0; font-size:12px; color:#94a3b8;">
                                Dikirim ke: {{ $email }} &middot; {{ $timestamp }}
                            </p>
                            <p style="margin:0; font-size:12px; color:#94a3b8;">
                                &copy; {{ date('Y') }} Bank Waway CMS Security Division. Seluruh hak cipta dilindungi.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>