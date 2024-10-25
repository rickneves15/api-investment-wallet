<?php

namespace Tests\Unit\Services;

use App\Models\Asset;
use App\Models\Transaction;
use App\Services\MetricsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MetricsServiceTest extends TestCase
{
    use RefreshDatabase;

    private $metricsService;

    public function setUp(): void
    {
        parent::setUp();
        $this->metricsService = new MetricsService();

        Asset::factory()->count(10)->create();
        Asset::query()->inRandomOrder()->limit(10)->get()
            ->each(function (Asset $asset) {
                Transaction::factory()->count(10)->create(['asset_id' => $asset->id]);
            });
    }

    public function testGetTotalGrossAssetValue()
    {


        $totalGross = $this->metricsService->getTotalGross();


        $this->assertIsFloat($totalGross);
    }

    public function testGetTotalAssets()
    {

        $totalAssets = $this->metricsService->getTotalAssets();

        $this->assertIsInt($totalAssets);
    }

    public function testGetMonthlyTransactions()
    {
        $data = $this->metricsService->getMonthlyTransactions();

        $this->assertArrayHasKey('buyTransactions', $data);
        $this->assertArrayHasKey('sellTransactions', $data);
    }

    public function testGetAssetsGroupedByType()
    {
        $data = $this->metricsService->getAssetsGroupedByType();

        $this->assertIsString($data[0]->type);
        $this->assertIsNumeric($data[0]->total);
    }
}
