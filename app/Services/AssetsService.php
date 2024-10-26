<?php

namespace App\Services;

use App\Enums\TransactionTypeEnum;
use App\Exceptions\GeneralException;
use App\Exceptions\GeneralJsonException;
use App\Http\Requests\Assets\AssetStoreRequest;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetsService
{

  public function __construct() {}


  public function getAll(Request $request)
  {
    $search = $request->query('search');
    $perPage = $request->query('perPage') ?? 5;

    $query = Asset::with('transactions')->where('deleted_at', null);

    if ($search) {
      $query->where('name', 'ILIKE', '%' . $search . '%');
    }

    $assets = $query->paginate($perPage);
    return AssetResource::collection($assets);
  }


  public function create(AssetStoreRequest $request)
  {
    $assetExist = Asset::where(['name' => $request['name'], 'type' => $request['type']])->first();

    if ($assetExist) {
      throw new GeneralException('Asset already exist', 409);
    }

    DB::transaction(function () use ($request) {
      $asset = Asset::create([
        'name' => $request['name'],
        'purchase_date' => $request['purchaseDate'],
        'quantity' => $request['quantity'],
        'quote' => $request['quote'],
        'type' => $request['type'],
      ]);

      $transaction = Transaction::create([
        'asset_id' => $asset['id'],
        'type' => TransactionTypeEnum::BUY,
        'quantity' => $request['quantity'],
        'unit_price' => $request['quote'],
        'transaction_date' => $request['purchaseDate'] ?? now(),
      ]);

      return new AssetResource($asset);
    });
  }

  public function getOne($id)
  {
    $asset = Asset::find($id);

    if (!$asset) {
      throw new GeneralException('Asset not found', 404);
    }

    return new AssetResource($asset);
  }


  public function delete($id)
  {
    $asset = Asset::find($id);

    if (!$asset) {
      throw new GeneralException('Asset not found', 404);
    }

    $asset->delete();

    return response()->noContent();
  }
}
