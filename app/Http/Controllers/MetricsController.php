<?php

namespace App\Http\Controllers;

use App\Services\MetricsService;

class MetricsController extends Controller
{
    public function __construct(private readonly MetricsService $metricsService) {}

    public function getTotalGross()
    {
        $totalGross = $this->metricsService->getTotalGross();

        return response()->json([
            'totalGross' => $totalGross
        ], 200);
    }

    public function getTotalAssets()
    {
        $totalAssets =  $this->metricsService->getTotalAssets();

        return response()->json([
            'totalAssets' => $totalAssets
        ], 200);
    }

    public function getMonthlyTransactions()
    {
        $transactions = $this->metricsService->getMonthlyTransactions();

        return response()->json($transactions, 200);
    }

    public function getAssetsGroupedByType()
    {
        return $this->metricsService->getAssetsGroupedByType();
    }
}
