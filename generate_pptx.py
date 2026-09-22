#!/usr/bin/env python3
"""
Generate a visually-rich presentation (PPTX) in Bahasa Indonesia
summarizing the "Bank Waway" Laravel website & admin system project.

Design goals: big-picture, minimal text, heavy use of visual diagrams
(chevrons, tiles, layered stacks, workflow pipelines, KPI cards, hash chain).
"""

import math
from pptx import Presentation
from pptx.util import Inches, Pt, Emu
from pptx.dml.color import RGBColor
from pptx.enum.text import PP_ALIGN, MSO_ANCHOR
from pptx.enum.shapes import MSO_SHAPE
from pptx.oxml.ns import qn

# ---------------------------------------------------------------------------
# Palette
# ---------------------------------------------------------------------------
NAVY       = RGBColor(0x0B, 0x2E, 0x4F)
BLUE       = RGBColor(0x1E, 0x6F, 0xC8)
LIGHT_BLUE = RGBColor(0x4A, 0x9F, 0xE5)
PALE_BLUE  = RGBColor(0xE7, 0xF1, 0xFA)
GOLD       = RGBColor(0xF2, 0xB1, 0x38)
TEAL       = RGBColor(0x1B, 0x9E, 0x93)
GREEN      = RGBColor(0x2F, 0xA4, 0x54)
RED        = RGBColor(0xD5, 0x4A, 0x4A)
WHITE      = RGBColor(0xFF, 0xFF, 0xFF)
DARK       = RGBColor(0x20, 0x2A, 0x35)
GREY       = RGBColor(0x5A, 0x6A, 0x7A)
LIGHT      = RGBColor(0xF5, 0xF8, 0xFB)
LIGHT_LINE = RGBColor(0xDC, 0xE6, 0xEE)
MID_LINE   = RGBColor(0xB9, 0xC9, 0xD8)

SW, SH = Inches(13.333), Inches(7.5)
prs = Presentation()
prs.slide_width = SW
prs.slide_height = SH
BLANK = prs.slide_layouts[6]


# ---------------------------------------------------------------------------
# Shape helpers
# ---------------------------------------------------------------------------
def _no_shadow(shape):
    shape.shadow.inherit = False
    return shape


def rect(slide, x, y, w, h, color, line=None, lw=None, rounded=False, radius=0.08):
    shp_type = MSO_SHAPE.ROUNDED_RECTANGLE if rounded else MSO_SHAPE.RECTANGLE
    s = slide.shapes.add_shape(shp_type, x, y, w, h)
    if rounded:
        s.adjustments[0] = radius
    s.fill.solid()
    s.fill.fore_color.rgb = color
    if line is None:
        s.line.fill.background()
    else:
        s.line.color.rgb = line
        s.line.width = lw or Pt(1)
    return _no_shadow(s)


def oval(slide, x, y, w, h, color, line=None, lw=None):
    s = slide.shapes.add_shape(MSO_SHAPE.OVAL, x, y, w, h)
    s.fill.solid()
    s.fill.fore_color.rgb = color
    if line is None:
        s.line.fill.background()
    else:
        s.line.color.rgb = line
        s.line.width = lw or Pt(1)
    return _no_shadow(s)


def chevron(slide, x, y, w, h, color, text, text_color=WHITE, size=13):
    s = slide.shapes.add_shape(MSO_SHAPE.CHEVRON, x, y, w, h)
    s.fill.solid()
    s.fill.fore_color.rgb = color
    s.line.fill.background()
    _no_shadow(s)
    tf = s.text_frame
    tf.word_wrap = True
    tf.margin_left = Inches(0.18)
    tf.margin_right = Inches(0.05)
    tf.vertical_anchor = MSO_ANCHOR.MIDDLE
    p = tf.paragraphs[0]
    p.alignment = PP_ALIGN.CENTER
    p.text = text
    p.font.name = "Segoe UI"
    p.font.size = Pt(size)
    p.font.bold = True
    p.font.color.rgb = text_color
    return s


def box(slide, x, y, w, h, color, title, subtitle=None, title_color=WHITE,
        sub_color=RGBColor(0xE0, 0xEC, 0xF6), tsize=15, ssize=11, rounded=True,
        align=PP_ALIGN.CENTER):
    s = rect(slide, x, y, w, h, color, rounded=rounded)
    tf = s.text_frame
    tf.word_wrap = True
    tf.margin_left = Inches(0.12)
    tf.margin_right = Inches(0.12)
    tf.vertical_anchor = MSO_ANCHOR.MIDDLE
    p = tf.paragraphs[0]
    p.alignment = align
    p.text = title
    p.font.name = "Segoe UI"
    p.font.size = Pt(tsize)
    p.font.bold = True
    p.font.color.rgb = title_color
    if subtitle:
        p2 = tf.add_paragraph()
        p2.space_before = Pt(3)
        p2.alignment = align
        p2.text = subtitle
        p2.font.name = "Segoe UI"
        p2.font.size = Pt(ssize)
        p2.font.color.rgb = sub_color
    return s


def textbox(slide, x, y, w, h, text, size=14, color=DARK, bold=False,
            align=PP_ALIGN.LEFT, line_spacing=1.15, anchor=MSO_ANCHOR.TOP):
    tb = slide.shapes.add_textbox(x, y, w, h)
    tf = tb.text_frame
    tf.word_wrap = True
    tf.vertical_anchor = anchor
    p = tf.paragraphs[0]
    p.alignment = align
    p.line_spacing = line_spacing
    p.text = text
    p.font.name = "Segoe UI"
    p.font.size = Pt(size)
    p.font.bold = bold
    p.font.color.rgb = color
    return tb


# ---------------------------------------------------------------------------
# Frame helpers (per-slide chrome)
# ---------------------------------------------------------------------------
def side_accent(slide):
    rect(slide, 0, 0, Inches(0.2), SH, NAVY)


def header(slide, title, kicker=None):
    rect(slide, Inches(0.55), Inches(0.35), Inches(0.09), Inches(0.6), GOLD)
    textbox(slide, Inches(0.82), Inches(0.3), Inches(11.7), Inches(0.7), title,
            size=28, bold=True, color=NAVY)
    if kicker:
        textbox(slide, Inches(0.85), Inches(1.0), Inches(11.6), Inches(0.4), kicker,
                size=13, color=GREY)
    rect(slide, Inches(0.55), Inches(1.55), Inches(12.2), Inches(0.02), LIGHT_LINE)


def footer(slide, page, label="Bank Waway \u2014 Presentasi"):
    rect(slide, Inches(0.55), Inches(7.08), Inches(12.2), Inches(0.02), LIGHT_LINE)
    textbox(slide, Inches(0.55), Inches(7.15), Inches(8), Inches(0.28), label,
            size=9, color=GREY)
    textbox(slide, Inches(11.8), Inches(7.15), Inches(0.95), Inches(0.28), str(page),
            size=9, color=GREY, align=PP_ALIGN.RIGHT)


def kicker_badge(slide, x, y, text, color=BLUE, w=None):
    w = w or Inches(0.55 * len(text) + 0.5)
    s = rect(slide, x, y, w, Inches(0.32), color, rounded=True, radius=0.5)
    tf = s.text_frame
    tf.margin_left = tf.margin_right = Inches(0.05)
    tf.vertical_anchor = MSO_ANCHOR.MIDDLE
    p = tf.paragraphs[0]
    p.alignment = PP_ALIGN.CENTER
    p.text = text
    p.font.name = "Segoe UI"
    p.font.size = Pt(11)
    p.font.bold = True
    p.font.color.rgb = WHITE
    return s


def new_slide():
    return prs.slides.add_slide(BLANK)


def full_bg_slide(color):
    s = new_slide()
    rect(s, 0, 0, SW, SH, color)
    return s


# ---------------------------------------------------------------------------
# SLIDE 1 — Title
# ---------------------------------------------------------------------------
def s_title():
    s = full_bg_slide(NAVY)
    rect(s, Inches(9.4), Inches(-1.2), Inches(6), Inches(6), RGBColor(0x14, 0x3B, 0x64), rounded=True)
    rect(s, Inches(11.4), Inches(4.6), Inches(3.6), Inches(3.6), RGBColor(0x17, 0x45, 0x74), rounded=True)
    rect(s, Inches(0.2), Inches(2.9), Inches(0.16), Inches(1.7), GOLD)

    # logo-ish mark
    oval(s, Inches(1.1), Inches(1.05), Inches(1.2), Inches(1.2), BLUE)
    textbox(s, Inches(1.1), Inches(1.4), Inches(1.2), Inches(0.6), "BW", size=28,
            bold=True, color=WHITE, align=PP_ALIGN.CENTER)

    textbox(s, Inches(2.6), Inches(1.2), Inches(8), Inches(1.1), "Bank Waway", size=54,
            bold=True, color=WHITE)
    textbox(s, Inches(2.65), Inches(2.15), Inches(8), Inches(0.6),
            "Sistem Website & Admin", size=26, bold=True, color=LIGHT_BLUE)

    # three big-picture pillars
    pillars = [
        ("Website Publik", "Informasi & produk", BLUE),
        ("Panel Admin", "Kelola & kelola data", TEAL),
        ("Keamanan", "Audit & kepatuhan", GOLD),
    ]
    x = Inches(1.1)
    y = Inches(3.5)
    for t, sub, c in pillars:
        box(s, x, y, Inches(3.6), Inches(1.05), c, t, sub, tsize=17, ssize=12)
        x += Inches(3.85)

    textbox(s, Inches(1.1), Inches(5.0), Inches(11), Inches(0.45),
            "Platform perbankan berbasis Laravel 13 untuk masyarakat", size=14,
            color=RGBColor(0xB9, 0xD0, 0xE6))
    textbox(s, Inches(1.1), Inches(5.5), Inches(11), Inches(0.45),
            "Serangkaian slide untuk memberikan gambaran besar (big picture)",
            size=12, color=RGBColor(0x8F, 0xAD, 0xCA))

    textbox(s, Inches(11.2), Inches(7.05), Inches(1.8), Inches(0.3), "1", size=9,
            color=RGBColor(0x9B, 0xB4, 0xCF), align=PP_ALIGN.RIGHT)


# ---------------------------------------------------------------------------
# SLIDE 2 — Agenda (visual tabs)
# ---------------------------------------------------------------------------
def s_agenda():
    s = new_slide()
    side_accent(s)
    header(s, "Agenda", "Gambaran besar presentasi")

    items = [
        ("01", "Sekilas Proyek"),
        ("02", "Arsitektur Aplikasi"),
        ("03", "Website Publik"),
        ("04", "Panel Admin"),
        ("05", "Keamanan & Autentikasi"),
        ("06", "Audit Log"),
        ("07", "Kepatuhan & Laporan"),
        ("08", "Otomatisasi & Backup"),
    ]
    cols = 4
    cw, ch, gx, gy = Inches(2.85), Inches(1.7), Inches(0.24), Inches(0.4)
    x0, y0 = Inches(0.85), Inches(2.1)
    palette = [BLUE, TEAL, LIGHT_BLUE, GOLD, NAVY, TEAL, LIGHT_BLUE, GOLD]

    for i, (num, label) in enumerate(items):
        col, row = i % cols, i // cols
        x = x0 + col * (cw + gx)
        y = y0 + row * (ch + gy)
        card = rect(s, x, y, cw, ch, LIGHT, line=LIGHT_LINE, lw=Pt(1), rounded=True)
        oval(s, x + Inches(0.28), y + Inches(0.24), Inches(0.7), Inches(0.7), palette[i])
        textbox(s, x + Inches(0.28), y + Inches(0.4), Inches(0.7), Inches(0.45), num,
                size=17, bold=True, color=WHITE, align=PP_ALIGN.CENTER)
        textbox(s, x + Inches(0.28), y + Inches(1.05), cw - Inches(0.5), Inches(0.5),
                label, size=14, bold=True, color=NAVY)

    footer(s, 2)


# ---------------------------------------------------------------------------
# SLIDE 3 — Big picture: 3 layers
# ---------------------------------------------------------------------------
def s_overview():
    s = new_slide()
    side_accent(s)
    header(s, "Sekilas Proyek", "Satu aplikasi, tiga lapisan utama")

    # layer 1
    box(s, Inches(0.85), Inches(2.0), Inches(11.6), Inches(1.35), BLUE,
        "LAPISAN PUBLIK", "Situs web yang dilihat & digunakan pelanggan")
    items1 = ["Beranda", "Profil", "Produk", "Berita", "Laporan", "Kontak", "WBS", "Kalkulator", "Pengajuan"]
    tx = Inches(1.15)
    for it in items1:
        kicker_badge(s, tx, Inches(2.62), it, color=RGBColor(0x2E, 0x81, 0xD6), w=None)
        tx += Inches(0.06 + 0.15 * len(it) + 0.4)

    # layer 2
    box(s, Inches(0.85), Inches(3.7), Inches(11.6), Inches(1.35), TEAL,
        "PANEL ADMIN", "Back-office untuk staf mengelola konten & data")
    items2 = ["Dashboard", "Berita", "Laporan", "Kepatuhan", "Audit Log", "Bantuan", "Konten", "Pengaturan"]
    tx = Inches(1.15)
    for it in items2:
        kicker_badge(s, tx, Inches(4.32), it, color=RGBColor(0x27, 0x8C, 0x83), w=None)
        tx += Inches(0.06 + 0.15 * len(it) + 0.4)

    # layer 3
    box(s, Inches(0.85), Inches(5.4), Inches(11.6), Inches(1.35), NAVY,
        "FONDASI", "Keamanan, audit, otomatisasi & database")
    items3 = ["Auth + 2FA", "Audit Chain", "Arsip 90 hari", "Backup", "Scheduler", "Database"]
    tx = Inches(1.15)
    for it in items3:
        kicker_badge(s, tx, Inches(6.02), it, color=RGBColor(0x2A, 0x53, 0x7E), w=None)
        tx += Inches(0.06 + 0.15 * len(it) + 0.4)

    footer(s, 3)


# ---------------------------------------------------------------------------
# SLIDE 4 — Architecture stack (layered diagram)
# ---------------------------------------------------------------------------
def s_architecture():
    s = new_slide()
    side_accent(s)
    header(s, "Arsitektur Aplikasi", "Alur dari browser hingga database")

    layers = [
        ("Laravel 13 + PHP 8.3", "Framework & bahasa", BLUE),
        ("Routes (web.php / admin-api)", "Menangani request", TEAL),
        ("Controller", "HTTP logic", LIGHT_BLUE),
        ("Service Layer", "Business logic", GOLD),
        ("Model / Eloquent", "Interaksi data", NAVY),
        ("Database (SQLite)", "Penyimpanan data", GREY),
    ]
    y = Inches(2.0)
    lh, gap = Inches(0.68), Inches(0.08)
    for i, (title, sub, c) in enumerate(layers):
        x = Inches(0.85)
        cv = rect(s, x, y, Inches(11.6), lh, c, rounded=True, radius=0.12)
        tf = cv.text_frame
        tf.margin_left = Inches(0.35)
        tf.vertical_anchor = MSO_ANCHOR.MIDDLE
        p = tf.paragraphs[0]
        p.text = title
        p.font.name = "Segoe UI"
        p.font.size = Pt(17)
        p.font.bold = True
        p.font.color.rgb = WHITE
        p2 = tf.add_paragraph()
        p2.text = sub
        p2.font.name = "Segoe UI"
        p2.font.size = Pt(11)
        p2.font.color.rgb = RGBColor(0xE0, 0xEC, 0xF6)
        # arrow between layers
        if i < len(layers) - 1:
            ar = s.shapes.add_shape(MSO_SHAPE.DOWN_ARROW, x + Inches(5.7), y + lh + Inches(0.005),
                                    Inches(0.35), gap + Inches(0.03))
            _no_shadow(ar)
            ar.width = Inches(0.3)
            ar.height = gap + Inches(0.03)
            ar.fill.solid()
            ar.fill.fore_color.rgb = MID_LINE
            ar.line.fill.background()
        y += lh + gap

    textbox(s, Inches(0.85), Inches(6.05), Inches(11.6), Inches(0.5),
            "Alur: Browser \u2192 Route \u2192 Middleware (SecurityHeaders, throttle, auth) \u2192 Controller \u2192 Service \u2192 Model \u2192 DB",
            size=13, color=GREY, align=PP_ALIGN.CENTER)

    footer(s, 4, "Arsitektur Aplikasi")


# ---------------------------------------------------------------------------
# SLIDE 5 — Public website (feature tiles + flow)
# ---------------------------------------------------------------------------
def s_public():
    s = new_slide()
    side_accent(s)
    header(s, "Website Publik", "Halaman yang dilihat pelanggan")

    # left: feature tiles
    tiles = [
        ("Beranda Dinamis", "Hero, statistik, banner, produk", BLUE),
        ("Katalog Produk", "Tabungan, deposito, pinjaman", TEAL),
        ("Berita & Info", "Berita terbit / draf", LIGHT_BLUE),
        ("Laporan Publik", "PDF & arsip laporan", GOLD),
        ("Pengajuan Online", "Form + kode aplikasi", NAVY),
        ("Kalkulator Kredit", "Hitung cicilan", GREEN),
    ]
    cols, rows = 2, 3
    cw, ch, gx, gy = Inches(3.15), Inches(1.35), Inches(0.35), Inches(0.22)
    x0, y0 = Inches(0.85), Inches(2.0)
    for i, (t, sub, c) in enumerate(tiles):
        col, row = i % cols, i // cols
        x = x0 + col * (cw + gx)
        y = y0 + row * (ch + gy)
        box(s, x, y, cw, ch, PALE_BLUE, t, sub, title_color=NAVY, sub_color=GREY,
            tsize=15, ssize=11)
        # small accent bar
        rect(s, x, y, Inches(0.06), ch, c)

    # right: customer flow
    fx = Inches(7.75)
    textbox(s, fx, Inches(2.0), Inches(4.8), Inches(0.4), "Alur Pelanggan", size=16,
            bold=True, color=NAVY)
    flow = [("Kunjungi", BLUE), ("Lihat Produk", TEAL), ("Ajukan / Hitung", LIGHT_BLUE),
            ("Hubungi / WBS", GOLD)]
    fy = Inches(2.5)
    for t, c in flow:
        chevron(s, fx, fy, Inches(4.6), Inches(0.62), c, t, size=14)
        fy += Inches(0.62)

    footer(s, 5, "Website Publik")


# ---------------------------------------------------------------------------
# SLIDE 6 — Admin panel (module grid)
# ---------------------------------------------------------------------------
def s_admin():
    s = new_slide()
    side_accent(s)
    header(s, "Panel Admin", "Modul back-office")

    modules = [
        ("Dashboard", "Statistik & grafik", BLUE),
        ("Berita", "Kelola publikasi", TEAL),
        ("Laporan", "Manajemen laporan", LIGHT_BLUE),
        ("Kepatuhan", "Dokumen kepatuhan", GOLD),
        ("Audit Log", "Jejak aktivitas", NAVY),
        ("Bantuan", "Tiket dukungan", GREEN),
        ("Konten Web", "Editor konten", BLUE),
        ("Pengaturan", "Maintenance & backup", TEAL),
    ]
    cols, rows = 4, 2
    cw, ch, gx, gy = Inches(2.75), Inches(1.5), Inches(0.32), Inches(0.35)
    x0, y0 = Inches(0.85), Inches(2.15)
    for i, (t, sub, c) in enumerate(modules):
        col, row = i % cols, i // cols
        x = x0 + col * (cw + gx)
        y = y0 + row * (ch + gy)
        box(s, x, y, cw, ch, c, t, sub, tsize=16, ssize=11,
            sub_color=RGBColor(0xE0, 0xEC, 0xF6))

    footer(s, 6, "Panel Admin")


# ---------------------------------------------------------------------------
# SLIDE 7 — Authentication & security (shield + chain)
# ---------------------------------------------------------------------------
def s_security():
    s = new_slide()
    side_accent(s)
    header(s, "Keamanan & Autentikasi", "Melindungi panel admin")

    feats = [
        ("Login Admin", "Guard khusus admin", BLUE),
        ("2FA", "Kode sekali pakai", TEAL),
        ("Lockout", "Kunci setelah 5 gagal", RED),
        ("Maintenance", "Blokir saat pemeliharaan", GOLD),
        ("Throttle", "Batasi jumlah request", NAVY),
        ("Sanitasi", "Bersihkan input", GREEN),
    ]
    cols, rows = 3, 2
    cw, ch, gx, gy = Inches(3.7), Inches(1.5), Inches(0.35), Inches(0.35)
    x0, y0 = Inches(0.85), Inches(2.05)
    for i, (t, sub, c) in enumerate(feats):
        col, row = i % cols, i // cols
        x = x0 + col * (cw + gx)
        y = y0 + row * (ch + gy)
        box(s, x, y, cw, ch, c, t, sub, tsize=16, ssize=12)

    # security headers bar
    rect(s, Inches(0.85), Inches(5.5), Inches(11.6), Inches(0.7), LIGHT, line=LIGHT_LINE, rounded=True)
    textbox(s, Inches(1.1), Inches(5.62), Inches(11), Inches(0.5),
            "Middleware SecurityHeaders: X-Frame-Options  \u2022  X-Content-Type-Options  \u2022  Referrer-Policy  \u2022  Permissions-Policy",
            size=13, color=NAVY, align=PP_ALIGN.CENTER)

    footer(s, 7, "Keamanan & Autentikasi")


# ---------------------------------------------------------------------------
# SLIDE 8 — Audit log: tamper-evident chain diagram
# ---------------------------------------------------------------------------
def s_audit():
    s = new_slide()
    side_accent(s)
    header(s, "Audit Log \u2014 Rantai Anti-Tamper", "Jejak semua aksi admin")

    # label
    textbox(s, Inches(0.85), Inches(1.85), Inches(11.6), Inches(0.4),
            "Setiap catatan menyimpan hash SHA-256 dari isinya + hash catatan sebelumnya",
            size=13, color=GREY, align=PP_ALIGN.CENTER)

    # 4 nodes chain
    nodes = [
        ("Log #1", "hash[1]", BLUE),
        ("Log #2", "hash[2]", TEAL),
        ("Log #3", "hash[3]", GOLD),
        ("Log #4", "hash[4]", NAVY),
    ]
    x = Inches(1.0)
    nw, nh = Inches(2.4), Inches(1.5)
    ny = Inches(2.5)
    for title, hname, c in nodes:
        oval(s, x + Inches(0.47), ny, Inches(0.5), Inches(0.5), c)
        textbox(s, x + Inches(0.47), ny + Inches(0.62), Inches(0.5), Inches(0.3), title,
                size=11, bold=True, color=DARK, align=PP_ALIGN.CENTER)
        box(s, x, ny - Inches(1.0), nw, Inches(0.62), c, hname, "", tsize=14)
        if x < Inches(1.0) + 3 * (nw + Inches(0.35)):
            # link line + arrow
            rect(s, x + nw, ny - Inches(0.68), Inches(0.35), Inches(0.03), MID_LINE)
            ar = s.shapes.add_shape(MSO_SHAPE.RIGHT_ARROW, x + nw + Inches(0.05), ny - Inches(0.78),
                                    Inches(0.3), Inches(0.18))
            _no_shadow(ar)
            ar.fill.solid()
            ar.fill.fore_color.rgb = MID_LINE
            ar.line.fill.background()
        x += nw + Inches(0.35)

    # "previous_hash" callout
    textbox(s, Inches(0.85), Inches(4.35), Inches(11.6), Inches(0.4),
            "prev_hash \u2192 hash = SHA-256( payload + prev_hash )", size=13,
            bold=True, color=NAVY, align=PP_ALIGN.CENTER)

    # metadata cards
    meta = [
        ("Detail Aksi", "admin, modul, aksi, route, status", BLUE),
        ("Asal Request", "IP, user-agent, session", TEAL),
        ("Sebelum / Sesudah", "nilai lama & baru", GOLD),
    ]
    mx = Inches(0.85)
    for t, sub, c in meta:
        box(s, mx, Inches(5.0), Inches(3.8), Inches(1.05), c, t, sub, tsize=15, ssize=11)
        mx += Inches(3.95)

    footer(s, 8, "Audit Log")


# ---------------------------------------------------------------------------
# SLIDE 9 — Compliance & reports (workflow pipeline)
# ---------------------------------------------------------------------------
def s_compliance():
    s = new_slide()
    side_accent(s)
    header(s, "Kepatuhan & Laporan", "Alur dokumen kepatuhan")

    # workflow chevrons
    textbox(s, Inches(0.85), Inches(1.85), Inches(11.6), Inches(0.4),
            "Alur Status Dokumen", size=15, bold=True, color=NAVY)
    steps = [("Draft", GREY), ("Published", GREEN), ("Archived", LIGHT_BLUE)]
    x = Inches(1.6)
    for t, c in steps:
        chevron(s, x, Inches(2.3), Inches(3.3), Inches(0.8), c, t, size=16)
        x += Inches(3.5)

    # cards
    cards = [
        ("Metadata", "Judul, file, ukuran, tahun fiskal, kategori", BLUE),
        ("Keamanan", "Level keamanan & tanggal retensi", TEAL),
        ("Publikasi", "Unduhan publik dengan otorisasi", GOLD),
        ("Versi", "Riwayat & versi baru laporan", NAVY),
    ]
    cols, rows = 2, 2
    cw, ch, gx, gy = Inches(5.85), Inches(1.35), Inches(0.35), Inches(0.3)
    x0, y0 = Inches(0.85), Inches(3.6)
    for i, (t, sub, c) in enumerate(cards):
        col, row = i % cols, i // cols
        x = x0 + col * (cw + gx)
        y = y0 + row * (ch + gy)
        box(s, x, y, cw, ch, c, t, sub, tsize=15, ssize=11)

    footer(s, 9, "Kepatuhan & Laporan")


# ---------------------------------------------------------------------------
# SLIDE 10 — Automation & scheduled tasks
# ---------------------------------------------------------------------------
def s_automation():
    s = new_slide()
    side_accent(s)
    header(s, "Otomatisasi & Backup", "Pekerjaan berjalan di latar belakang")

    # left: schedule pipeline
    textbox(s, Inches(0.85), Inches(1.95), Inches(5.5), Inches(0.4), "Jadwal Mingguan",
            size=16, bold=True, color=NAVY)
    box(s, Inches(0.85), Inches(2.45), Inches(5.3), Inches(1.5), TEAL,
        "report:weekly-summary", "Senin 08:00 WIB \u2014 email ringkasan", tsize=16, ssize=12)
    box(s, Inches(0.85), Inches(4.15), Inches(5.3), Inches(1.5), BLUE,
        "audit:archive", "Arsip log > 90 hari ke JSON.gz", tsize=16, ssize=12)

    # right: automation cards
    auto = [
        ("Arsip Log", "Log lama dipadatkan & dibersihkan", BLUE),
        ("Ringkasan", "Login, gagal, log, sesi via email", TEAL),
        ("Backup DB", "Salinan SQLite berstempel waktu", GOLD),
        ("Cache & Maintenance", "Bersihkan cache, mode pemeliharaan", NAVY),
    ]
    cols, rows = 1, 4
    cw, ch, gx, gy = Inches(5.85), Inches(1.05), Inches(0.0), Inches(0.22)
    x0, y0 = Inches(6.9), Inches(2.0)
    for i, (t, sub, c) in enumerate(auto):
        col, row = i % cols, i // cols
        x = x0 + col * (cw + gx)
        y = y0 + row * (ch + gy)
        box(s, x, y, cw, ch, c, t, sub, tsize=15, ssize=11)

    footer(s, 10, "Otomatisasi & Backup")


# ---------------------------------------------------------------------------
# SLIDE 11 — Data models (memory/katakana-style tile grid)
# ---------------------------------------------------------------------------
def s_data():
    s = new_slide()
    side_accent(s)
    header(s, "Model Data", "Tabel inti yang menggerakkan aplikasi")

    models = [
        ("AuditLog", "Jejak audit + hash chain", BLUE),
        ("ComplianceReport", "Dokumen kepatuhan", TEAL),
        ("Berita", "Artikel & berita", LIGHT_BLUE),
        ("Laporan", "Laporan publikasi", GOLD),
        ("SupportTicket", "Tiket bantuan & WBS", NAVY),
        ("ProductApplication", "Pengajuan kredit", GREEN),
        ("Badge", "Sertifikasi & penghargaan", BLUE),
        ("Setting", "Konfigurasi aplikasi", TEAL),
        ("Admin / User", "Identitas masuk", GREY),
    ]
    cols, rows = 3, 3
    cw, ch, gx, gy = Inches(3.7), Inches(1.25), Inches(0.35), Inches(0.3)
    x0, y0 = Inches(0.85), Inches(2.1)
    for i, (t, sub, c) in enumerate(models):
        col, row = i % cols, i // cols
        x = x0 + col * (cw + gx)
        y = y0 + row * (ch + gy)
        box(s, x, y, cw, ch, PALE_BLUE, t, sub, title_color=NAVY, sub_color=GREY,
            tsize=16, ssize=11)
        rect(s, x, y, Inches(0.06), ch, c)

    footer(s, 11, "Model Data")


# ---------------------------------------------------------------------------
# SLIDE 12 — Summary / big picture takeaway
# ---------------------------------------------------------------------------
def s_summary():
    s = new_slide()
    side_accent(s)
    header(s, "Ringkasan", "Yang perlu diingat")

    points = [
        ("Satu Aplikasi", "Publik + Admin dalam 1 platform", BLUE),
        ("Laravel 13", "Modern, rapi & terstruktur", TEAL),
        ("Rantai Audit", "Jejak tak bisa diubah", GOLD),
        ("Otomatis", "Arsip, ringkasan, backup", NAVY),
    ]
    cols, rows = 2, 2
    cw, ch, gx, gy = Inches(5.85), Inches(1.5), Inches(0.35), Inches(0.35)
    x0, y0 = Inches(0.85), Inches(2.1)
    for i, (t, sub, c) in enumerate(points):
        col, row = i % cols, i // cols
        x = x0 + col * (cw + gx)
        y = y0 + row * (ch + gy)
        box(s, x, y, cw, ch, c, t, sub, tsize=18, ssize=12)

    # track record row
    rect(s, Inches(0.85), Inches(5.7), Inches(11.6), Inches(0.8), LIGHT, line=LIGHT_LINE, rounded=True)
    textbox(s, Inches(1.1), Inches(5.82), Inches(11), Inches(0.55),
            "Aman  \u2022  Transparan  \u2022  Terpercaya  \u2014  Misinya melayani masyarakat",
            size=16, bold=True, color=NAVY, align=PP_ALIGN.CENTER)

    footer(s, 12, "Ringkasan")


# ---------------------------------------------------------------------------
# SLIDE 13 — Closing
# ---------------------------------------------------------------------------
def s_thanks():
    s = full_bg_slide(NAVY)
    rect(s, Inches(9.4), Inches(-1.2), Inches(6), Inches(6), RGBColor(0x14, 0x3B, 0x64), rounded=True)
    rect(s, Inches(0.2), Inches(3.05), Inches(0.16), Inches(1.5), GOLD)

    textbox(s, Inches(1.0), Inches(2.6), Inches(9.5), Inches(1.2), "Terima Kasih",
            size=52, bold=True, color=WHITE)
    textbox(s, Inches(1.0), Inches(3.7), Inches(9.5), Inches(0.6),
            "Terima kasih atas perhatiannya", size=24, bold=True, color=LIGHT_BLUE)
    textbox(s, Inches(1.0), Inches(4.5), Inches(9.5), Inches(0.6),
            "Sesi Tanya Jawab (Q&A)", size=18, color=RGBColor(0xB8, 0xD0, 0xE6))

    textbox(s, Inches(11.2), Inches(7.05), Inches(1.8), Inches(0.3), "13", size=9,
            color=RGBColor(0x9B, 0xB4, 0xCF), align=PP_ALIGN.RIGHT)


# ---------------------------------------------------------------------------
# Build deck
# ---------------------------------------------------------------------------
s_title()
s_agenda()
s_overview()
s_architecture()
s_public()
s_admin()
s_security()
s_audit()
s_compliance()
s_automation()
s_data()
s_summary()
s_thanks()

out = "Bank_Waway_Presentation.pptx"
prs.save(out)
print(f"Saved: {out}  ({len(prs.slides.__iter__.__self__._sldIdLst)} slides)")
