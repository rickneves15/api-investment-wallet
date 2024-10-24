<?php

namespace App\Services;

use App\Enums\TransactionTypeEnum;
use App\Exceptions\GeneralException;
use App\Http\Requests\Transactions\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Asset;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionsService
{

  public function __construct() {}

  public function buy(TransactionRequest $request)
  {
    $asset = Asset::find($request['assetId']);

    if (!$asset) {
      throw new GeneralException('Asset not found', 404);
    }

    return DB::transaction(function () use ($request, $asset) {
      $transaction = Transaction::create([
        'asset_id' => $request['assetId'],
        'type' => TransactionTypeEnum::BUY,
        'quantity' => $request['quantity'],
        'unit_price' => $request['unitPrice'],
        'transaction_date' => now(),
      ]);

      $asset->quantity += $request['quantity'];
      $asset->save();

      return new TransactionResource($transaction);
    });
  }

  public function sell(TransactionRequest $request)
  {
    $asset = Asset::find($request['assetId']);

    if (!$asset) {
      throw new GeneralException('Asset not found', 404);
    }

    return DB::transaction(function () use ($request, $asset) {

      if ($asset->quantity < $request['quantity']) {
        throw new GeneralException('Not enough quantity to sell', 409);
      }

      $transaction = Transaction::create([
        'asset_id' => $request['assetId'],
        'type' => TransactionTypeEnum::SELL,
        'quantity' => $request['quantity'],
        'unit_price' => $request['unitPrice'],
        'transaction_date' => now(),
      ]);

      $asset->quantity -= $request['quantity'];
      $asset->save();

      return new TransactionResource($transaction);
    });
  }
}
