<?php

use App\Enums\AssetTypeEnum;
use App\Http\Requests\Assets\AssetStoreRequest;
use App\Http\Resources\AssetResource;
use Tests\TestCase;
use App\Services\AssetsService;
use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AssetsServiceTest extends TestCase
{

  use RefreshDatabase;

  private $assetsService;

  public function setUp(): void
  {
    parent::setUp();
    $this->assetsService = new AssetsService();
  }

  public function testGetAllReturnsPaginatedAssets()
  {
    Asset::factory()->count(10)->create();

    $request = new Request(['perPage' => 5]);

    $response = $this->assetsService->getAll($request);

    $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
    $this->assertCount(5, $response->items());
  }

  public function testGetAllFiltersAssetsByName()
  {
    $data = Asset::factory()->create(['name' => 'test']);
    Asset::factory()->count(10)->create();

    $request = new Request(['search' => 'test']);

    $response = $this->assetsService->getAll($request);

    $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
    $this->assertCount(1, $response->items());
    $this->assertEquals($data->name, $response->items()[0]->name);
    $this->assertEquals($data->purchase_date, $response->items()[0]->purchase_date);
    $this->assertEquals($data->quantity, $response->items()[0]->quantity);
    $this->assertEquals($data->quote, $response->items()[0]->quote);
    $this->assertEquals($data->type, $response->items()[0]->type);
  }

  public function testCreateNewAsset()
  {
    $request = new AssetStoreRequest(Asset::factory()->make()->toArray());
    $response = $this->assetsService->create($request);


    $this->assertInstanceOf(AssetResource::class, $response);
    $this->assertArrayHasKey('name', $response);
    $this->assertArrayHasKey('purchase_date', $response);
    $this->assertArrayHasKey('quantity', $response);
    $this->assertArrayHasKey('quote', $response);
    $this->assertArrayHasKey('type', $response);
  }

  public function testCreateReturnsErrorIfAssetAlreadyExist()
  {
    Asset::factory()->create(['name' => 'Test Asset', 'type' => AssetTypeEnum::ACTION]);

    $request = new AssetStoreRequest(Asset::factory()->make(['name' => 'Test Asset', 'type' => AssetTypeEnum::ACTION])->toArray());
    $response = $this->assetsService->create($request);

    $this->assertEquals(409, $response->original['statusCode']);
    $this->assertEquals('Asset already exist', $response->original['message']);
  }

  public function testGetOneReturnsAsset()
  {
    $asset = Asset::factory()->create();

    $response = $this->assetsService->getOne($asset);


    $this->assertInstanceOf(AssetResource::class, $response);
    $this->assertEquals($asset->name, $response->name);
    $this->assertEquals($asset->purchase_date, $response->purchase_date);
    $this->assertEquals($asset->quantity, $response->quantity);
    $this->assertEquals($asset->quote, $response->quote);
    $this->assertEquals($asset->type, $response->type);
  }

  public function testGetOneReturnsErrorIfAssetNotFound()
  {
    $response = $this->assetsService->getOne(new Asset());

    $this->assertEquals(404, $response->original['statusCode']);
    $this->assertEquals('Asset not found', $response->original['message']);
  }

  public function testDeleteDeletesAsset()
  {
    $asset = Asset::factory()->create();

    $this->assetsService->delete($asset);

    $this->assertNull(Asset::where('name', $asset->name)->where('type', $asset->type)->where('deleted_at', '!=', null)->first());
  }

  public function testDeleteReturnsErrorIfAssetNotFound()
  {
    $response = $this->assetsService->delete(new Asset());

    $this->assertEquals(404, $response->original['statusCode']);
    $this->assertEquals('Asset not found', $response->original['message']);
  }
}
