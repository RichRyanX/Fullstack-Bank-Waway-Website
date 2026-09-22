<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\Public\HomeService;

class HomeController extends Controller
{
    public function index(HomeService $homeService)
    {
        $payload = $homeService->getHomePayload();

        return view('public.beranda.home', $payload);
    }
}
