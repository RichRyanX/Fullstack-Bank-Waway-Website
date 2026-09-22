<?php

namespace App\Services\Public;

use App\Models\Berita;
use App\Models\Setting;

class ProductService
{
    public function show(string $slug): array
    {
        $product = Berita::where('status', 'published')
            ->get()
            ->first(fn (Berita $berita) => $this->slugify($berita->title) === $slug);

        if ($product !== null) {
            $sections = $this->parseSections((string) $product->content);

            return [
                'id' => $product->id,
                'name' => $product->title,
                'slug' => $slug,
                'category' => $product->category,
                'published_at' => $product->created_at,
                'description' => $sections['description'],
                'benefits' => $sections['benefits'],
                'requirements' => $sections['requirements'],
                'tenors' => $this->buildTenors(),
                'actions' => $this->buildActions(),
            ];
        }

        return $this->buildDefaults($slug);
    }

    protected function buildDefaults(string $slug): array
    {
        $catalog = $this->catalog();

        $data = $catalog[$slug] ?? [
            'name' => ucfirst($slug),
            'tagline' => 'Wujudkan tujuan finansial Anda dengan produk layanan Bank Waway.',
            'benefits' => [],
            'requirements' => [],
        ];

        return [
            'id' => null,
            'name' => $data['name'],
            'slug' => $slug,
            'category' => $data['category'] ?? 'Produk Unggulan',
            'published_at' => now(),
            'description' => $data['tagline'],
            'benefits' => $data['benefits'],
            'requirements' => $data['requirements'],
            'tenors' => $this->buildTenors(),
            'actions' => $this->buildActions(),
        ];
    }

    protected function catalog(): array
    {
        return [
            'deposito' => [
                'name' => 'Deposito Waway',
                'category' => 'Produk Unggulan',
                'tagline' => 'Wujudkan masa depan finansial yang lebih cerah dengan suku bunga kompetitif dan fleksibilitas jangka waktu yang sesuai dengan rencana investasi Anda.',
                'benefits' => [
                    'Simpanan Anda aman terlindungi secara hukum.',
                    'Nikmati persentase bagi hasil di atas rata-rata pasar.',
                    'Pembukaan rekening tanpa hambatan birokrasi.',
                ],
                'requirements' => [],
            ],
            'pinjaman' => [
                'name' => 'Pinjaman Waway',
                'category' => 'Produk Kredit',
                'tagline' => 'Wujudkan impian memiliki hunian, kendaraan, atau pengembangan usaha dengan pembiayaan ringan kami.',
                'benefits' => [
                    'Proses pengajuan yang cepat dan mudah.',
                    'Bunga kompetitif dengan tenor fleksibel.',
                ],
                'requirements' => [],
            ],
            'tabungan' => [
                'name' => 'Tabungan Waway',
                'category' => 'Produk Simpanan',
                'tagline' => 'Nikmati kemudahan menabung dengan bunga kompetitif dan biaya administrasi ringan untuk masa depan Anda.',
                'benefits' => [
                    'Bunga kompetitif dan biaya administrasi ringan.',
                    'Akses transaksi yang mudah melalui layanan digital.',
                ],
                'requirements' => [],
            ],
        ];
    }

    protected function buildTenors(): array
    {
        return [
            [
                'icon' => '📅',
                'label' => '1 Bulan',
                'text' => 'Likuiditas tinggi untuk kebutuhan finansial jangka sangat pendek dengan bunga kompetitif.',
                'featured' => false,
            ],
            [
                'icon' => '🗓️',
                'label' => '3 Bulan',
                'text' => 'Keseimbangan ideal antara fleksibilitas dana dan pertumbuhan nilai investasi Anda.',
                'featured' => false,
            ],
            [
                'icon' => '⏰',
                'label' => '6 Bulan',
                'text' => 'Optimalkan pertumbuhan aset Anda dengan periode tenor tengah yang lebih menguntungkan.',
                'featured' => false,
            ],
            [
                'icon' => '💡',
                'label' => '12 Bulan',
                'text' => 'Dapatkan imbal hasil maksimal untuk perencanaan masa depan yang lebih kokoh dan stabil.',
                'featured' => true,
            ],
        ];
    }

    protected function parseSections(string $content): array
    {
        $benefits = [];
        $requirements = [];
        $description = [];

        $lines = preg_split('/\R/', $content) ?: [];
        $current = 'description';

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $heading = $this->detectHeading($line);

            if ($heading !== null) {
                $current = $heading;
                continue;
            }

            if ($current === 'benefits') {
                $benefits[] = $this->cleanLine($line);
            } elseif ($current === 'requirements') {
                $requirements[] = $this->cleanLine($line);
            } else {
                $description[] = $line;
            }
        }

        return [
            'benefits' => $benefits,
            'requirements' => $requirements,
            'description' => implode("\n", $description),
        ];
    }

    protected function detectHeading(string $line): ?string
    {
        $lower = mb_strtolower($line);

        foreach (['manfaat', 'keuntungan', 'fitur', 'keunggulan', 'kelebihan'] as $keyword) {
            if (str_contains($lower, $keyword)) {
                return 'benefits';
            }
        }

        foreach (['persyaratan', 'syarat', 'ketentuan'] as $keyword) {
            if (str_contains($lower, $keyword)) {
                return 'requirements';
            }
        }

        return null;
    }

    protected function cleanLine(string $line): string
    {
        return trim((string) preg_replace('/^[\-\*\u2022\s\d\.\)]+/', '', $line));
    }

    protected function slugify(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '-', $value);

        return trim((string) $value, '-');
    }

    protected function buildActions(): array
    {
        $setting = Setting::first();

        $actions = [
            [
                'text' => 'Hubungi Kami',
                'url' => $setting->whatsapp_url ?? '#kontak',
                'type' => 'primary',
            ],
            [
                'text' => 'Lihat Berita',
                'url' => route('public.berita.index'),
                'type' => 'secondary',
            ],
        ];

        return $actions;
    }
}
