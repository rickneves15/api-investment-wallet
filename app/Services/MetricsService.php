<?php

namespace App\Services;

use App\Http\Resources\AssetsGroupByTypeResource;
use App\Models\Asset;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MetricsService
{

  public function getTotalGross()
  {
    return floatval(Asset::sum(DB::raw('quantity * quote')));
  }

  public function getTotalAssets()
  {
    return Asset::count();
  }

  public function getMonthlyTransactions()
  {
    return [
      'buyTransactions' => Transaction::whereYear('transaction_date', Carbon::now()->year)
        ->whereMonth('transaction_date', Carbon::now()->month)
        ->where('type', 'buy')
        ->count(),
      'sellTransactions' => Transaction::whereYear('transaction_date', Carbon::now()->year)
        ->whereMonth('transaction_date', Carbon::now()->month)
        ->where('type', 'sell')
        ->count(),
    ];
  }

  public function getAssetsGroupedByType()
  {
    $data = DB::table('assets')->select(
      'assets.type',
      DB::raw('SUM(assets.quantity * assets.quote) as total'),
    )
      ->leftJoin('transactions', 'assets.id', '=', 'transactions.asset_id')
      ->where('deleted_at', null)
      ->groupBy('assets.type')
      ->get()
      ->toArray();

    return AssetsGroupByTypeResource::collection($data)->collection;
  }
}
