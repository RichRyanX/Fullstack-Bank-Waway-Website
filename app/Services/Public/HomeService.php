<?php

namespace App\Services\Public;

use App\Models\Badge;
use App\Models\Berita;
use App\Models\Laporan;
use App\Models\Setting;

class HomeService
{
    public function getHomePayload(): array
    {
        return [
            'hero' => $this->getHero(),
            'stats' => $this->getStatistics(),
            'banners' => $this->getPromotionalBanners(),
            'products' => $this->getFeaturedProducts(),
            'news' => $this->getPublishedNews(),
            'settings' => $this->getSettings(),
            'total_banners' => $this->getPromotionalBanners()->count(),
        ];
    }

    protected function getSettings(): ?Setting
    {
        return Setting::first();
    }

    protected function getHero(): array
    {
        $setting = $this->getSettings();

        return [
            'title' => $setting->site_name ?? 'Bank Waway',
            'tagline' => $setting->site_tagline ?? 'Melayani masyarakat dengan layanan perbankan yang aman, sehat, dan terpercaya untuk kesejahteraan bersama.',
            'cta_text' => 'Lihat Produk',
            'cta_link' => '#produk',
        ];
    }

    protected function getStatistics(): array
    {
        $publishedNews = Berita::where('status', 'published')->count();
        $totalReports = Laporan::where('status', 'active')->count();
        $activeBadges = Badge::where('active', true)->count();
        $totalViews = (int) Berita::where('status', 'published')->sum('views');

        return [
            ['label' => 'Berita Terbit', 'value' => $publishedNews],
            ['label' => 'Laporan Publikasi', 'value' => $totalReports],
            ['label' => 'Sertifikasi Resmi', 'value' => $activeBadges],
            ['label' => 'Total Pembaca', 'value' => $totalViews],
        ];
    }

    protected function getPromotionalBanners(): \Illuminate\Support\Collection
    {
        $banners = Berita::where('status', 'published')
            ->where('category', 'like', '%promo%')
            ->latest()
            ->take(3)
            ->get()
            ->map(function (Berita $berita) {
                return (object) [
                    'id' => $berita->id,
                    'title' => $berita->title ?? 'Promo Bank Waway',
                    'content' => $berita->content ?? '',
                    'excerpt' => $berita->excerpt ?? '',
                    'category' => $berita->category ?? 'promo',
                    'link' => '#berita',
                ];
            });

        return $banners;
    }

    protected function getFeaturedProducts(): array
    {
        $fromContent = Berita::where('status', 'published')
            ->where('category', 'like', '%produk%')
            ->latest()
            ->take(3)
            ->get()
            ->map(function (Berita $berita) {
                return [
                    'id' => $berita->id,
                    'name' => $berita->title,
                    'description' => $berita->content,
                    'feature' => 'Produk',
                ];
            })
            ->toArray();

        if (!empty($fromContent)) {
            return $fromContent;
        }

        return [
            [
                'name' => 'Simpanan',
                'description' => 'Tabungan dan deposito dengan bunga kompetitif serta aman dijamin oleh LPS.',
                'feature' => 'Dijamin LPS',
            ],
            [
                'name' => 'Kredit',
                'description' => 'Kredit modal kerja dan kredit usaha rakyat untuk mendukung pengembangan usaha.',
                'feature' => 'KUR',
            ],
            [
                'name' => 'Layanan Digital',
                'description' => 'Akses perbankan mudah melalui layanan mobile dan internet banking.',
                'feature' => 'Mobile & Internet Banking',
            ],
        ];
    }

    protected function getPublishedNews(): \Illuminate\Support\Collection
    {
        return Berita::where('status', 'published')
            ->latest()
            ->take(6)
            ->get()
            ->map(function (Berita $berita) {
                $berita->setAttribute('excerpt', $this->buildExcerpt($berita->content));
                $berita->setAttribute('published_at', $berita->created_at);

                return $berita;
            });
    }

    protected function buildExcerpt(?string $content, int $length = 120): string
    {
        $plain = trim(strip_tags((string) $content));
        $plain = preg_replace('/\s+/', ' ', $plain);

        if (mb_strlen($plain) <= $length) {
            return $plain;
        }

        return mb_substr($plain, 0, $length) . '…';
    }
}
