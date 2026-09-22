<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\Public\ProductService;

class ProductController extends Controller
{
    public function show(string $slug, ProductService $productService)
    {
        $product = $productService->show($slug);

        return view('public.produk.produk-show', [
            'product' => $product,
        ]);
    }
}
