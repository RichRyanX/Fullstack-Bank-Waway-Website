@extends('layouts.public')

@section('title', 'Bank Waway Lampung - Whistleblowing System (WBS)')

@section('styles')
<style>
        .wbs-hero-section {
            padding: 64px 0 70px;
        }

        .wbs-hero-grid {
            display: grid;
            grid-template-columns: 1fr 0.9fr;
            gap: 48px;
            align-items: center;
        }

        .wbs-eyebrow-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--navy);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .4px;
            text-transform: uppercase;
            padding: 8px 18px;
            border-radius: 999px;
            margin-bottom: 22px;
        }

        .wbs-hero-grid h1 {
            font-size: 38px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -.5px;
            line-height: 1.2;
            margin-bottom: 18px;
        }

        .wbs-hero-grid>div>p {
            color: var(--text-muted);
            font-size: 15.5px;
            line-height: 1.75;
            max-width: 520px;
            margin-bottom: 28px;
        }

        .wbs-feature-row {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .wbs-feature-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            border: 1px solid var(--border);
            background: #fff;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--navy);
        }

        .wbs-hero-img {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .wbs-hero-img img {
            width: 100%;
            height: 340px;
            object-fit: cover;
        }

        .wbs-main-section {
            padding: 10px 0 90px;
        }

        .wbs-main-grid {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .wbs-sidebar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            align-items: stretch;
        }

        .wbs-side-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 32px;
            height: 100%;
            box-sizing: border-box;
        }

        .wbs-side-card h4 {
            font-size: 17px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 22px;
        }

        .wbs-step {
            display: flex;
            gap: 14px;
            margin-bottom: 20px;
        }

        .wbs-step:last-child {
            margin-bottom: 0;
        }

        .wbs-step .num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--navy);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: none;
        }

        .wbs-step h6 {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 4px;
        }

        .wbs-step p {
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.6;
            margin: 0;
        }

        .wbs-kanal-card {
            background: var(--navy);
            border-radius: var(--radius);
            padding: 32px;
            color: #fff;
            height: 100%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        .wbs-kanal-card h4 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #fff;
        }

        .wbs-kanal-card>p {
            font-size: 13px;
            color: #c7d3ef;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .wbs-kanal-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .wbs-kanal-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            transition: background 0.2s ease;
        }

        .wbs-kanal-item:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .wbs-kanal-item .ic {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .wbs-kanal-item .info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            gap: 3px;
            flex: 1;
            min-width: 0;
        }

        .wbs-kanal-item .lbl {
            font-size: 11px;
            font-weight: 700;
            color: #97a6cc;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .wbs-kanal-item .val {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            word-break: break-word;
        }

        .wbs-quote-card {
            grid-column: 1 / -1;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px 28px;
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .wbs-quote-card .mark {
            font-size: 36px;
            font-weight: 800;
            color: var(--blue);
            line-height: 1;
            flex: none;
        }

        .wbs-quote-card p {
            font-size: 14px;
            color: var(--navy);
            font-style: italic;
            line-height: 1.6;
            margin: 0;
        }

        @media(max-width:900px) {
            .wbs-hero-grid,
            .wbs-sidebar {
                grid-template-columns: 1fr;
            }

            .wbs-hero-grid {
                gap: 32px;
            }

            .wbs-hero-img img {
                height: 240px;
            }
        }
    </style>
@endsection

@section('content')

    <section class="wbs-hero-section" id="wbs">
        <div class="container">
            <div class="wbs-hero-grid">
                <div>
                    <span class="wbs-eyebrow-pill">🛡️ Sistem Pelaporan Pelanggaran</span>
                    <h1>Whistleblowing System (WBS)</h1>
                    <p>Bank Waway Lampung berkomitmen menjunjung tinggi nilai integritas dan profesionalisme. WBS adalah
                        sarana bagi Anda untuk melaporkan segala bentuk indikasi pelanggaran, kecurangan (fraud), atau
                        perilaku tidak etis yang terjadi di lingkungan bank dengan jaminan kerahasiaan identitas.</p>
                    <div class="wbs-feature-row">
                        <span class="wbs-feature-badge">🔒 Anonimitas Terjamin</span>
                        <span class="wbs-feature-badge">⚖️ Sesuai Regulasi OJK</span>
                    </div>
                </div>
                <div class="wbs-hero-img">
                    <img src="{{ asset('frontend/images/wbs-hero.jpg') }}" alt="Kantor Bank Waway Lampung">
                </div>
            </div>
        </div>
    </section>

    <section class="wbs-main-section">
        <div class="container">
            <div class="wbs-main-grid">
                <div class="wbs-sidebar">

                    <div class="wbs-side-card">
                        <h4>Prosedur WBS</h4>

                        <div class="wbs-step">
                            <div class="num">1</div>
                            <div>
                                <h6>Penyampaian</h6>
                                <p>Pelapor mengirimkan aduan melalui formulir ini atau kanal resmi lainnya.</p>
                            </div>
                        </div>

                        <div class="wbs-step">
                            <div class="num">2</div>
                            <div>
                                <h6>Verifikasi</h6>
                                <p>Tim audit internal melakukan validasi data dan bukti awal dalam 3x24 jam.</p>
                            </div>
                        </div>

                        <div class="wbs-step">
                            <div class="num">3</div>
                            <div>
                                <h6>Investigasi</h6>
                                <p>Pemeriksaan mendalam dilakukan terhadap pihak terkait yang dilaporkan.</p>
                            </div>
                        </div>

                        <div class="wbs-step">
                            <div class="num">4</div>
                            <div>
                                <h6>Tindak Lanjut</h6>
                                <p>Pemberian sanksi atau tindakan korektif sesuai kebijakan internal bank.</p>
                            </div>
                        </div>
                    </div>

                    <div class="wbs-kanal-card">
                        <h4>Kanal Lainnya</h4>
                        <p>Selain formulir web, Anda juga dapat melaporkan melalui:</p>

                        <div class="wbs-kanal-list">
                            <div class="wbs-kanal-item">
                                <div class="ic">✉️</div>
                                <div class="info">
                                    <div class="lbl">Email Auditor</div>
                                    <div class="val">Bankwawaylampung@yahoo.com</div>
                                </div>
                            </div>

                            <div class="wbs-kanal-item">
                                <div class="ic">📞</div>
                                <div class="info">
                                    <div class="lbl">Hotline 24/7</div>
                                    <div class="val">+0721 266 869</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wbs-quote-card">
                        <div class="mark">“</div>
                        <p>Integritas adalah melakukan hal yang benar, bahkan ketika tidak ada orang yang melihat.</p>
                    </div>

                </div>

                <div class="tab-cta-banner">
                    <div>
                        <h3>Whistleblowing System</h3>
                        <p>Sistem Pelaporan Pelanggaran PT BPR WAWAY LAMPUNG</p>
                    </div>
                    <a href="https://script.google.com/macros/s/AKfycbxTkiICPnXbB17y3EEUAfb6RuMn_VQu8asQtu7gxXNw0WDdFEFNl_f6WzPeKTHSYpqBLg/exec" class="btn-find">Laporkan Sekarang</a>
                </div>
            </div>
        </div>
    </section>

@endsection
