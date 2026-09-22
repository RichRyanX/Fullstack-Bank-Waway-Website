@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Karier')

@section('styles')
<style>
        /* ===== Hero Karir ===== */
        .karir-hero {
            position: relative;
            min-height: 480px;
            display: flex;
            align-items: center;
            color: #fff;
            overflow: hidden;
        }

        .karir-hero .hero-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .karir-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg, rgba(15, 26, 51, .92) 15%, rgba(15, 26, 51, .55) 75%);
        }

        .karir-hero .container {
            position: relative;
            z-index: 2;
        }

        .karir-badge {
            display: inline-block;
            background: var(--blue);
            color: #fff;
            padding: 7px 16px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .karir-hero h1 {
            font-size: 42px;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -.5px;
            max-width: 640px;
            margin-bottom: 18px;
        }

        .karir-hero p {
            font-size: 16px;
            max-width: 560px;
            opacity: .88;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .btn-karir-primary {
            background: var(--blue);
            color: #fff;
            border: none;
            padding: 14px 26px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            display: inline-flex;
            transition: .2s;
            text-decoration: none;
        }

        .btn-karir-primary:hover {
            background: var(--blue)
        }

        /* ===== Stats row ===== */
        .karir-stats {
            max-width: var(--container);
            margin: 50px auto 0;
            padding: 0 24px;
            position: relative;
            z-index: 3;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 24px;
        }

        .karir-stat-card {
            background: #fff;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
            display: flex;
            align-items: flex-start;
            gap: 18px;
            border: 1px solid #edf2f7;
        }

        .karir-stat-card .ic {
            width: 52px;
            height: 52px;
            background: #eef7f8;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .karir-stat-card h4 {
            font-size: 16px;
            font-weight: 700;
            color: #0f1a33;
            margin-bottom: 6px;
        }

        .karir-stat-card p {
            font-size: 13.5px;
            color: #555;
            line-height: 1.5;
            margin: 0;
        }

        /* ===== Lowongan Section ===== */
        .karir-content-section {
            padding: 70px 0 90px;
        }

        .karir-filter-row {
            display: flex;
            gap: 12px;
            margin-bottom: 35px;
            flex-wrap: wrap;
        }

        .karir-search-input {
            flex: 1;
            min-width: 260px;
            padding: 14px 18px;
            border-radius: 10px;
            border: 1px solid #d2d6dc;
            font-size: 15px;
            outline: none;
            transition: .2s;
            background: #fff;
        }

        .karir-search-input:focus {
            border-color: #00838f;
            box-shadow: 0 0 0 3px rgba(0, 131, 143, .12);
        }

        .karir-search-btn {
            background: #0f1a33;
            color: #fff;
            border: none;
            padding: 0 28px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
        }

        .karir-search-btn:hover {
            background: #1d305e;
        }

        .job-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .job-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .03);
        }

        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
            border-color: #cbd5e1;
        }

        .job-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .job-tag {
            background: var(--blue);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 99px;
        }

        .job-loc {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        .job-card h3 {
            font-size: 19px;
            font-weight: 700;
            color: #0f1a33;
            margin-bottom: 10px;
        }

        .job-desc {
            font-size: 14px;
            color: #475569;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .job-card-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-lamar {
            flex: 1;
            background: var(--blue);
            color: #fff;
            text-align: center;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: .2s;
            display: inline-block;
        }

        .btn-lamar:hover {
            background: var(--blue);
        }

        .btn-download {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: .2s;
        }

        .btn-download:hover {
            background: #e2e8f0;
        }

        .job-card-cta {
            background: linear-gradient(135deg, #0f1a33 0%, #1d305e 100%);
            border-radius: 16px;
            padding: 32px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            text-align: left;
        }

        .job-card-cta .ic {
            font-size: 32px;
            background: rgba(255, 255, 255, .1);
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .job-card-cta h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .job-card-cta p {
            font-size: 14px;
            opacity: .85;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn-drop {
            background: var(--blue);
            color: #fff;
            border: none;
            padding: 12px 22px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: .2s;
        }

        .btn-drop:hover {
            background: var(--blue);
        }

        /* ===== Proses Rekrutmen ===== */
        .proses-section {
            background: #f8fafc;
            padding: 90px 0;
            border-top: 1px solid #e2e8f0;
        }

        .proses-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 40px;
        }

        .proses-step {
            background: #fff;
            padding: 32px 24px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .02);
        }

        .ic-circle {
            width: 60px;
            height: 60px;
            background: #eef7f8;
            color: #00838f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 20px;
        }

        .proses-step h5 {
            font-size: 17px;
            font-weight: 700;
            color: #0f1a33;
            margin-bottom: 8px;
        }

        .proses-step p {
            font-size: 13.5px;
            color: #64748b;
            line-height: 1.5;
            margin: 0;
        }

        @media(max-width: 1024px) {
            .karir-stats {
                grid-template-columns: 1fr;
            }
            .job-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .proses-steps {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 768px) {
            .karir-hero h1 {
                font-size: 32px;
            }
            .job-grid {
                grid-template-columns: 1fr;
            }
            .proses-steps {
                grid-template-columns: 1fr;
            }
        }
</style>
@endsection

@section('content')

    <!-- ===== HERO KARIR ===== -->
    <section class="karir-hero">
        <img class="hero-bg" src="{{ asset('frontend/images/kantor.jpg') }}" alt="Gedung Bank Waway Lampung">
        <div class="container">
            <span class="karir-badge">Karier Bank Waway</span>
            <h1>Bangun Masa Depan Cemerlang Bersama Kami</h1>
            <p>Bergabunglah dengan institusi keuangan terkemuka di Lampung yang mengutamakan integritas, inovasi, dan pertumbuhan profesional.</p>
            <a href="#lowongan" class="btn-karir-primary">Lihat Lowongan</a>
        </div>
    </section>

    <!-- ===== STATS ROW ===== -->
    <div class="karir-stats">
        <div class="karir-stat-card">
            <div class="ic">🌟</div>
            <div>
                <h4>Budaya Kerja Dinamis</h4>
                <p>Lingkungan kerja inklusif yang mendukung kolaborasi dan inovasi.</p>
            </div>
        </div>
        <div class="karir-stat-card">
            <div class="ic">📈</div>
            <div>
                <h4>Pengembangan Karir</h4>
                <p>Pelatihan berkelanjutan untuk peningkatan kompetensi.</p>
            </div>
        </div>
        <div class="karir-stat-card">
            <div class="ic">🛡️</div>
            <div>
                <h4>Kesejahteraan</h4>
                <p>Paket kompensasi dan jaminan kesehatan yang kompetitif.</p>
            </div>
        </div>
    </div>

    <!-- ===== LOWONGAN PEKERJAAN ===== -->
    <section class="karir-content-section" id="lowongan">
        <div class="container">
            <h2 class="section-title">Lowongan Pekerjaan Tersedia</h2>
            <p class="section-sub">Temukan posisi yang sesuai dengan keahlian dan minat Anda untuk bergabung bersama Bank Waway.</p>

            <form class="karir-filter-row" id="karirFilterForm">
                <input type="text" class="karir-search-input" id="cariPosisi" placeholder="Cari posisi pekerjaan...">
                <button type="submit" class="karir-search-btn">Cari</button>
            </form>

            <div class="job-grid">
                
                <article class="job-card">
                    <div>
                        <div class="job-top">
                            <span class="job-tag">Full Time</span>
                            <span class="job-loc">Bandar Lampung</span>
                        </div>
                        <h3>Account Officer (AO)</h3>
                        <p class="job-desc">Bertanggung jawab dalam pengelolaan portofolio kredit serta pengembangan nasabah baru segmen komersial dan UMKM.</p>
                    </div>
                    <div class="job-card-actions">
                        <a href="https://script.google.com/macros/s/AKfycbwI71v0XXHJj4tPUw_K0vuUbYOSc05d3AyC81-6t4XgCzgi8MC1lYTxwzI9Gpuw-566/exec"
                            target="_blank" rel="noopener" class="btn-lamar">Lamar Sekarang</a>
                        <button class="btn-download" aria-label="Unduh Detail">⬇️</button>
                    </div>
                </article>

                <article class="job-card">
                    <div>
                        <div class="job-top">
                            <span class="job-tag">Full Time</span>
                            <span class="job-loc">Lampung</span>
                        </div>
                        <h3>Customer Service (CS)</h3>
                        <p class="job-desc">Memberikan pelayanan prima kepada nasabah terkait informasi produk, penanganan keluhan, serta transaksi perbankan harian.</p>
                    </div>
                    <div class="job-card-actions">
                        <a href="https://script.google.com/macros/s/AKfycbwI71v0XXHJj4tPUw_K0vuUbYOSc05d3AyC81-6t4XgCzgi8MC1lYTxwzI9Gpuw-566/exec"
                            target="_blank" rel="noopener" class="btn-lamar">Lamar Sekarang</a>
                        <button class="btn-download" aria-label="Unduh Detail">⬇️</button>
                    </div>
                </article>

                <article class="job-card">
                    <div>
                        <div class="job-top">
                            <span class="job-tag">Full Time</span>
                            <span class="job-loc">Bandar Lampung</span>
                        </div>
                        <h3>Staff IT & Developer</h3>
                        <p class="job-desc">Mengembangkan dan memelihara sistem aplikasi perbankan digital serta infrastruktur teknologi informasi bank.</p>
                    </div>
                    <div class="job-card-actions">
                        <a href="https://script.google.com/macros/s/AKfycbwI71v0XXHJj4tPUw_K0vuUbYOSc05d3AyC81-6t4XgCzgi8MC1lYTxwzI9Gpuw-566/exec"
                            target="_blank" rel="noopener" class="btn-lamar">Lamar Sekarang</a>
                        <button class="btn-download" aria-label="Unduh Detail">⬇️</button>
                    </div>
                </article>

                <article class="job-card">
                    <div>
                        <div class="job-top">
                            <span class="job-tag">Contract</span>
                            <span class="job-loc">Bandar Lampung</span>
                        </div>
                        <h3>Admin Kredit</h3>
                        <p class="job-desc">Mengawasi proses administrasi kredit dan memastikan kepatuhan terhadap regulasi perbankan yang berlaku.</p>
                    </div>
                    <div class="job-card-actions">
                        <a href="https://script.google.com/macros/s/AKfycbwI71v0XXHJj4tPUw_K0vuUbYOSc05d3AyC81-6t4XgCzgi8MC1lYTxwzI9Gpuw-566/exec"
                            target="_blank" rel="noopener" class="btn-lamar">Lamar Sekarang</a>
                        <button class="btn-download" aria-label="Unduh Detail">⬇️</button>
                    </div>
                </article>

                <div class="job-card-cta">
                    <div class="ic">👤➕</div>
                    <h4>Posisi Tidak Ditemukan?</h4>
                    <p>Kirimkan CV Anda ke database talenta kami untuk peluang di masa mendatang.</p>
                    <button class="btn-drop">Drop Resume</button>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== PROSES REKRUTMEN ===== -->
    <section class="proses-section">
        <div class="container">
            <h2 class="section-title" style="text-align: center;">Proses Rekrutmen Kami</h2>
            <p class="section-sub" style="text-align: center;">Sistem seleksi yang transparan dan kompetitif untuk mendapatkan talenta terbaik.</p>

            <div class="proses-steps">
                <div class="proses-step">
                    <div class="ic-circle">📝</div>
                    <h5>Pendaftaran Online</h5>
                    <p>Kirimkan berkas melalui portal karier resmi.</p>
                </div>
                <div class="proses-step">
                    <div class="ic-circle">🧠</div>
                    <h5>Tes Assessment</h5>
                    <p>Evaluasi kemampuan kognitif dan perilaku.</p>
                </div>
                <div class="proses-step">
                    <div class="ic-circle">💬</div>
                    <h5>Wawancara</h5>
                    <p>Diskusi mendalam dengan tim HR dan User.</p>
                </div>
                <div class="proses-step">
                    <div class="ic-circle">✅</div>
                    <h5>Onboarding</h5>
                    <p>Selamat bergabung di keluarga besar Bank Waway.</p>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    document.getElementById('karirFilterForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const keyword = document.getElementById('cariPosisi').value.trim().toLowerCase();
        document.querySelectorAll('.job-card').forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            card.style.display = (!keyword || title.includes(keyword)) ? '' : 'none';
        });
    });
</script>
@endsection
