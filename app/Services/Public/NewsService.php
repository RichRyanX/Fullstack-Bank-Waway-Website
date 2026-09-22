<?php

namespace App\Services\Public;

use App\Models\Berita;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class NewsService
{
    public function paginate(int $perPage = 9, ?string $category = null): LengthAwarePaginator
    {
        return Berita::query()
            ->where('status', 'published')
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function categories(): Collection
    {
        return Berita::where('status', 'published')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }

    public function findByIdOrSlug($identifier): ?Berita
    {
        $query = Berita::where('status', 'published');

        if (ctype_digit((string) $identifier)) {
            return $query->find((int) $identifier);
        }

        $slug = $this->slugify((string) $identifier);

        return $query->get()
            ->first(fn (Berita $berita) => $this->slugify($berita->title) === $slug);
    }

    public function decorate(Berita $berita): Berita
    {
        $berita->setAttribute('excerpt', $this->buildExcerpt($berita->content));
        $berita->setAttribute('published_at', $berita->created_at);
        $berita->setAttribute('content_blocks', $this->buildContentBlocks($berita->content));

        return $berita;
    }

    protected function slugify(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '-', $value);

        return trim((string) $value, '-');
    }

    protected function buildExcerpt(?string $content, int $length = 160): string
    {
        $plain = trim(strip_tags((string) $content));
        $plain = preg_replace('/\s+/', ' ', $plain);

        if (mb_strlen($plain) <= $length) {
            return $plain;
        }

        return mb_substr($plain, 0, $length) . '…';
    }

    protected function buildContentBlocks(?string $content): array
    {
        $blocks = [];

        foreach (preg_split('/\R{2,}/', trim((string) $content)) as $paragraph) {
            if ($paragraph !== '') {
                $blocks[] = [
                    'type' => 'paragraph',
                    'text' => trim($paragraph),
                ];
            }
        }

        return $blocks;
    }
}
