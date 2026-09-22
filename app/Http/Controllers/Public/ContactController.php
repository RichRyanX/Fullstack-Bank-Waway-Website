<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreContactInquiryRequest;
use App\Models\Setting;
use App\Services\Public\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact(Request $request, ContactService $service)
    {
        return view('public.bantuan.contact', [
            'settings' => Setting::first(),
        ]);
    }

    public function whistleblowing(Request $request, ContactService $service)
    {
        return view('public.whistleblowing.index', [
            'settings' => Setting::first(),
        ]);
    }

    public function storeContact(StoreContactInquiryRequest $request, ContactService $service)
    {
        $validated = $request->validated();

        $service->createInquiry($validated, $request);

        return redirect()
            ->route('public.kontak.index')
            ->with('success', 'Pertanyaan Anda telah berhasil dikirim. Tim kami akan segera menghubungi Anda.');
    }

}
