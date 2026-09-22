<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Panduan Penggunaan CMS Bank Waway Lampung</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            color: #1e293b;
            line-height: 1.6;
            font-size: 14px;
        }

        .header-banner {
            background: #0f172a;
            color: #ffffff;
            padding: 24px 32px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .header-banner .institution {
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #93c5fd;
            margin-bottom: 6px;
        }

        .header-banner h1 {
            font-size: 22px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .header-banner .subtitle {
            font-size: 13px;
            color: #cbd5e1;
        }

        .metadata-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }

        .metadata-row {
            display: table-row;
        }

        .metadata-cell {
            display: table-cell;
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            vertical-align: top;
        }

        .metadata-row:last-child .metadata-cell {
            border-bottom: none;
        }

        .metadata-label {
            font-weight: bold;
            color: #0f172a;
            width: 30%;
            background: #f1f5f9;
        }

        .metadata-value {
            color: #1e293b;
        }

        .confidential-badge {
            display: inline-block;
            background: #dc2626;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 3px;
            letter-spacing: 1px;
        }

        h2 {
            border-left: 5px solid #1e3a8a;
            padding-left: 12px;
            margin-top: 24px;
            color: #0f172a;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        h3 {
            color: #1e3a8a;
            font-size: 14px;
            font-weight: bold;
            margin-top: 14px;
            margin-bottom: 6px;
        }

        p {
            margin-bottom: 10px;
            text-align: justify;
        }

        ul {
            margin: 8px 0 12px 20px;
        }

        li {
            margin-bottom: 6px;
        }

        .toc-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px;
            margin: 16px 0;
        }

        .toc-card h2 {
            border-left: none;
            padding-left: 0;
            margin-top: 0;
            color: #0f172a;
        }

        .toc-card ol {
            margin: 8px 0 0 20px;
        }

        .toc-card li {
            margin-bottom: 6px;
            font-size: 13px;
        }

        .callout {
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 12px 16px;
            border-radius: 4px;
            font-size: 13px;
            margin: 12px 0;
        }

        .callout strong {
            color: #1e3a8a;
        }

        .callout-warning {
            background: #fef2f2;
            border-left-color: #dc2626;
        }

        .callout-warning strong {
            color: #991b1b;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
            font-size: 10px;
            color: #64748b;
        }

        .footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer td {
            vertical-align: top;
            padding: 0;
        }

        .footer .footer-left {
            text-align: left;
        }

        .footer .footer-right {
            text-align: right;
            white-space: nowrap;
        }

        .page-break {
            page-break-before: always;
        }

        .section-intro {
            font-size: 13px;
            color: #475569;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>

    <div class="header-banner">
        <div class="institution">Bank Waway Lampung</div>
        <h1>Manual Panduan Penggunaan CMS</h1>
        <div class="subtitle">Sistem Pengelolaan Konten Portal Resmi Bank Waway Lampung</div>
    </div>

    <div class="metadata-grid">
        <div class="metadata-row">
            <div class="metadata-cell metadata-label">Doc ID</div>
            <div class="metadata-cell metadata-value">DOC-BW-CMS-2026-V1</div>
        </div>
        <div class="metadata-row">
            <div class="metadata-cell metadata-label">Klasifikasi</div>
            <div class="metadata-cell metadata-value"><span class="confidential-badge">STRICTLY CONFIDENTIAL</span> / INTERNAL USE ONLY</div>
        </div>
        <div class="metadata-row">
            <div class="metadata-cell metadata-label">Tanggal Terbit</div>
            <div class="metadata-cell metadata-value">26 Agustus 2026</div>
        </div>
        <div class="metadata-row">
            <div class="metadata-cell metadata-label">Versi</div>
            <div class="metadata-cell metadata-value">1.0.4</div>
        </div>
    </div>

    <div class="toc-card">
        <h2>Daftar Isi</h2>
        <ol>
            <li>Autentikasi & Keamanan 2FA Admin CMS</li>
            <li>Pengelolaan Konten Website & Publikasi Berita</li>
            <li>Pengunggahan Laporan Kepatuhan (Format PDF/PNG)</li>
            <li>Pengelolaan Hak Akses & Audit Log Monitoring</li>
        </ol>
    </div>

    <h2>Bab 1: Autentikasi & Keamanan 2FA Admin CMS</h2>
    <p class="section-intro">Prosedur masuk dan verifikasi identitas untuk seluruh administrator portal.</p>
    <p>Setiap admin wajib melakukan login menggunakan kredensial yang terdaftar. Setelah memasukkan username dan password, sistem mengirimkan kode OTP Two-Factor Authentication (2FA) ke email terdaftar. Masukkan kode tersebut untuk menyelesaikan proses verifikasi.</p>
    <p>Status <strong>LOGIN_2FA_SENT</strong> menandakan kode OTP telah berhasil dikirim. Jangan pernah membagikan kode OTP kepada siapa pun. Akun yang gagal verifikasi berulang kali akan dikunci sementara sesuai kebijakan keamanan sistem.</p>

    <div class="callout">
        <strong>Kepatuhan 2FA:</strong> Seluruh sesi login wajib melalui verifikasi dua faktor. Kode OTP bersifat rahasia dan hanya berlaku untuk satu kali penggunaan. Laporkan segera ke Tim IT Support apabila menerima kode OTP yang tidak Anda minta.
    </div>

    <h2>Bab 2: Pengelolaan Konten Website & Publikasi Berita</h2>
    <p class="section-intro">Alur kerja pembuatan, penyuntingan, dan publikasi konten portal.</p>
    <p>Gunakan menu Konten Website untuk membuat, mengedit, dan mempublikasikan berita serta informasi portal. Pastikan judul, kategori, dan isi konten akurat sebelum disimpan. Konten yang telah dipublikasikan akan tampil di website publik.</p>
    <p>Gunakan fitur verifikasi sebelum publish agar perubahan dapat dikendalikan dan terdokumentasi dengan baik.</p>

    <h3>Langkah Publikasi Konten</h3>
    <ul>
        <li>Buka menu Konten Website dan pilih Buat Konten Baru.</li>
        <li>Isi judul, kategori, dan isi konten dengan data yang akurat.</li>
        <li>Lakukan verifikasi pratinjau sebelum menyimpan.</li>
        <li>Publikasikan konten hanya setelah seluruh pemeriksaan selesai.</li>
    </ul>

    <h2>Bab 3: Pengunggahan Laporan Kepatuhan (Format PDF/PNG)</h2>
    <p class="section-intro">Ketentuan unggah dokumen laporan kepatuhan ke sistem.</p>
    <p>Menu Laporan & Kepatuhan digunakan untuk mengunggah dokumen laporan kepatuhan. Pastikan dokumen berformat PDF atau PNG dan tidak melebihi batas kuota penyimpanan.</p>
    <p>Setiap unggahan akan dicatat dalam audit log beserta metadata dokumen untuk keperluan pelacakan dan arsip.</p>

    <div class="callout callout-warning">
        <strong>Batasan Format:</strong> Hanya dokumen berformat PDF atau PNG yang diterima. Dokumen yang melebihi batas kuota penyimpanan akan ditolak oleh sistem. Pastikan nama file tidak mengandung karakter khusus.
    </div>

    <h2>Bab 4: Pengelolaan Hak Akses & Audit Log Monitoring</h2>
    <p class="section-intro">Pengaturan peran pengguna dan pemantauan aktivitas sistem.</p>
    <p>Hak akses dikelola berdasarkan Role-Based Access Control (RBAC). Perubahan kredensial dan reset password hanya dapat dilakukan oleh Super Admin.</p>
    <p>Pantau seluruh aktivitas melalui menu Audit Log untuk memastikan setiap aksi tercatat, termasuk login, unggah, dan perubahan pengaturan. Gunakan filter rentang tanggal dan tipe aksi untuk memudahkan pencarian, serta ekspor laporan untuk kebutuhan monitoring.</p>

    <div class="callout">
        <strong>Pembatasan Super Admin (RBAC):</strong> Operasi sensitif seperti reset password, perubahan kredensial, dan modifikasi pengaturan keamanan hanya dapat dilakukan oleh akun dengan peran Super Admin. Seluruh perubahan dicatat secara permanen dalam audit log.
    </div>

    <div class="footer">
        <table>
            <tr>
                <td class="footer-left">© 2026 Bank Waway Lampung — Tim IT Support (Ext. 8888) | Dokumen ini bersifat rahasia dan hanya untuk penggunaan internal.</td>
                <td class="footer-right">Halaman {PAGE_NUM} dari {PAGE_COUNT}</td>
            </tr>
        </table>
    </div>

</body>
</html>