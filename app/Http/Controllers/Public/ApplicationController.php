<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\CalculateSimulationRequest;
use App\Http\Requests\Public\StoreProductApplicationRequest;
use App\Models\Berita;
use App\Models\Setting;
use App\Services\Public\ApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function kalkulator(Request $request, ApplicationService $service)
    {
        return view('public.produk.kalkulator', [
            'settings' => Setting::first(),
            'products' => $this->getProducts(),
            'productTypes' => $service->allProductTypes(),
        ]);
    }

    public function index(Request $request, ApplicationService $service)
    {
        return view('public.produk.pengajuan', [
            'settings' => Setting::first(),
            'products' => $this->getProducts(),
            'productTypes' => $service->allProductTypes(),
        ]);
    }

    public function kreditPegawai(Request $request, ApplicationService $service)
    {
        return view('public.produk.kredit-pegawai', [
            'settings' => Setting::first(),
            'products' => $this->getProducts(),
            'productTypes' => $service->allProductTypes(),
        ]);
    }

    public function calculate(CalculateSimulationRequest $request, ApplicationService $service)
    {
        $validated = $request->validated();

        $result = $this->computeSimulation(
            $validated['product_type'],
            (float) $validated['amount'],
            (int) $validated['tenure']
        );

        return view('public.produk.kalkulator', [
            'settings' => Setting::first(),
            'result' => $result,
            'products' => $this->getProducts(),
            'productTypes' => $service->allProductTypes(),
        ]);
    }

    public function store(StoreProductApplicationRequest $request, ApplicationService $service)
    {
        $validated = $request->validated();

        $application = $service->createApplication($validated, $request);

        return redirect()
            ->route('public.pengajuan.index')
            ->with('success', 'Pengajuan produk Anda telah berhasil dikirim dengan nomor referensi ' . $application->application_code . '. Tim kami akan segera menghubungi Anda.');
    }

    protected function computeSimulation(string $productType, float $amount, int $tenure): array
    {
        if ($productType === 'kredit') {
            return $this->simulateCredit($amount, $tenure);
        }

        if ($productType === 'deposito') {
            return $this->simulateDeposit($amount, $tenure);
        }

        return $this->simulateSaving($amount, $tenure);
    }

    protected function simulateCredit(float $amount, int $tenure): array
    {
        $annualRate = 0.0924;
        $monthlyRate = $annualRate / 12;
        $monthlyPayment = 0.0;

        if ($monthlyRate > 0) {
            $monthlyPayment = $amount * $monthlyRate * pow(1 + $monthlyRate, $tenure) / (pow(1 + $monthlyRate, $tenure) - 1);
        } else {
            $monthlyPayment = $amount / $tenure;
        }

        $totalPayment = $monthlyPayment * $tenure;
        $totalInterest = $totalPayment - $amount;

        return [
            'type' => 'kredit',
            'amount' => $amount,
            'tenure' => $tenure,
            'monthly_payment' => round($monthlyPayment, 2),
            'total_interest' => round($totalInterest, 2),
            'total_payment' => round($totalPayment, 2),
            'annual_rate' => $annualRate * 100,
        ];
    }

    protected function simulateDeposit(float $amount, int $tenure): array
    {
        $annualRate = 0.035;
        $years = $tenure / 12;
        $matureAmount = $amount * pow(1 + $annualRate, $years);
        $interest = $matureAmount - $amount;

        return [
            'type' => 'deposito',
            'amount' => $amount,
            'tenure' => $tenure,
            'interest_payout' => round($interest, 2),
            'maturity_value' => round($matureAmount, 2),
            'annual_rate' => $annualRate * 100,
        ];
    }

    protected function simulateSaving(float $amount, int $tenure): array
    {
        $annualRate = 0.018;
        $years = $tenure / 12;
        $matureAmount = $amount * pow(1 + $annualRate, $years);
        $interest = $matureAmount - $amount;

        return [
            'type' => 'tabungan',
            'amount' => $amount,
            'tenure' => $tenure,
            'interest_payout' => round($interest, 2),
            'maturity_value' => round($matureAmount, 2),
            'annual_rate' => $annualRate * 100,
        ];
    }

    protected function getProducts(): \Illuminate\Support\Collection
    {
        return Berita::where('status', 'published')
            ->where('category', 'like', '%produk%')
            ->orderByDesc('created_at')
            ->get();
    }
}
