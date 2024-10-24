<?php

namespace Tests\Unit\Services;

use App\Enums\TransactionTypeEnum;
use App\Exceptions\GeneralException;
use App\Http\Requests\Transactions\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Asset;
use App\Models\Transaction;
use App\Services\TransactionsService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionsServiceTest extends TestCase
{
    use RefreshDatabase;

    private $transactionsService;

    public function setUp(): void
    {
        parent::setUp();
        $this->transactionsService = new TransactionsService();
    }

    public function testBuyReturnsTransaction()
    {
        $asset = Asset::factory()->create();

        $transaction = Transaction::factory()->make([
            'assetId' => $asset['id'],
            "unitPrice" => 141.02
        ])->toArray();


        $request = new TransactionRequest($transaction);


        $response = $this->transactionsService->buy($request);

        $this->assertInstanceOf(TransactionResource::class, $response);
        $this->assertArrayHasKey('asset_id', $response);
        $this->assertArrayHasKey('type', $response);
        $this->assertArrayHasKey('quantity', $response);
        $this->assertArrayHasKey('unit_price', $response);
        $this->assertArrayHasKey('transaction_date', $response);
    }

    public function testBuyAssetNotFound()
    {
        $anExceptionWasThrown = false;

        try {

            $asset = Asset::factory()->create();
            $request = new TransactionRequest([
                'assetId' => $asset['id'],
                'quantity' => 10,
                'unitPrice' => 100,
            ]);

            $asset->delete();
            $this->transactionsService->buy($request);
        } catch (Exception $e) {
            $anExceptionWasThrown = true;

            $this->assertEquals(404, $e->getCode());
            $this->assertEquals('Asset not found', $e->getMessage());
        }

        $this->assertTrue($anExceptionWasThrown);
    }


    public function testSellReturnsTransaction()
    {
        $asset = Asset::factory()->create([
            'quantity' => 10
        ]);

        $transaction = Transaction::factory()->make([
            'assetId' => $asset['id'],
            'quantity' => 5,
            "unitPrice" => 141.02
        ])->toArray();


        $request = new TransactionRequest($transaction);

        $response = $this->transactionsService->sell($request);

        $this->assertInstanceOf(TransactionResource::class, $response);
        $this->assertArrayHasKey('asset_id', $response);
        $this->assertArrayHasKey('type', $response);
        $this->assertArrayHasKey('quantity', $response);
        $this->assertArrayHasKey('unit_price', $response);
        $this->assertArrayHasKey('transaction_date', $response);
    }

    public function testSellAssetNotFound()
    {
        $anExceptionWasThrown = false;

        try {

            $asset = Asset::factory()->create();
            $request = new TransactionRequest([
                'assetId' => $asset['id'],
                'quantity' => 10,
                'unitPrice' => 100,
            ]);

            $asset->delete();
            $this->transactionsService->sell($request);
        } catch (Exception $e) {
            $anExceptionWasThrown = true;

            $this->assertEquals(404, $e->getCode());
            $this->assertEquals('Asset not found', $e->getMessage());
        }

        $this->assertTrue($anExceptionWasThrown);
    }

    public function testSellNotEnoughQuantity()
    {
        $anExceptionWasThrown = false;

        try {
            $asset = Asset::factory()->create([
                'quantity' => 5
            ]);
            $request = new TransactionRequest([
                'assetId' => $asset['id'],
                'quantity' => 10,
                'unitPrice' => 100,
            ]);

            $this->transactionsService->sell($request);
        } catch (Exception $e) {
            $anExceptionWasThrown = true;

            $this->assertEquals(409, $e->getCode());
            $this->assertEquals('Not enough quantity to sell', $e->getMessage());
        }

        $this->assertTrue($anExceptionWasThrown);
    }
}
