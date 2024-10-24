<?php

namespace App\Services;

use App\Http\Requests\Assets\AssetStoreRequest;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetsService
{

  public function __construct() {}


  public function getAll(Request $request)
  {
    $search = $request->query('search');
    $perPage = $request->query('perPage') ?? 5;

    $query = Asset::with('transactions')->where('deleted_at', null);

    if ($search) {
      $query->where('name', 'like', '%' . $search . '%');
    }

    $assets = $query->paginate($perPage);
    return AssetResource::collection($assets);
  }


  public function create(AssetStoreRequest $request)
  {
    $assetExist = Asset::where(['name' => $request['name'], 'type' => $request['type']])->first();

    if ($assetExist) {
      return response()->json([
        'statusCode' => 409,
        'message' => 'Asset already exist'
      ], 409);
    }

    $asset = Asset::create([
      'name' => $request['name'],
      'purchase_date' => $request['purchase_date'],
      'quantity' => $request['quantity'],
      'quote' => $request['quote'],
      'type' => $request['type'],
    ]);

    return new AssetResource($asset);
  }

  public function getOne(Asset $asset)
  {
    $assetExist = Asset::where(['name' => $asset['name'], 'type' => $asset['type']])->first();

    if (!$assetExist) {
      return response()->json([
        'statusCode' => 404,
        'message' => 'Asset not found'
      ], 404);
    }

    return new AssetResource($assetExist);
  }


  public function delete(Asset $asset)
  {
    $assetExist = Asset::where(['name' => $asset['name'], 'type' => $asset['type']])->first();

    if (!$assetExist) {
      return response()->json([
        'statusCode' => 404,
        'message' => 'Asset not found'
      ], 404);
    }

    return response()->noContent();
  }
}
