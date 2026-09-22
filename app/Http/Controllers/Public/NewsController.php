<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\Public\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request, NewsService $newsService)
    {
        $category = $request->query('category');

        return view('public.informasi.berita', [
            'news' => $newsService->paginate(9, $category),
            'categories' => $newsService->categories(),
            'activeCategory' => $category,
        ]);
    }

    public function show($id, NewsService $newsService)
    {
        $news = $newsService->findByIdOrSlug($id);

        if ($news === null) {
            abort(404);
        }

        $news->increment('views');
        $news = $news->fresh();

        return view('public.informasi.berita-show', [
            'item' => $newsService->decorate($news),
        ]);
    }
}
