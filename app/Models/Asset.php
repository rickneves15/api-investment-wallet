<?php

namespace App\Models;

use App\Enums\AssetTypeEnum;
use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'purchase_date',
        'quantity',
        'quote',
        'type',
    ];

    protected $appends = ['total_invested'];

    protected function casts(): array
    {
        return [
            'type' => AssetTypeEnum::class
        ];
    }

    public function getTotalInvestedAttribute()
    {
        $totalInvested = 0;

        if ($this->transactions->count() > 0) {
            foreach ($this->transactions as $transaction) {
                if ($transaction->type == TransactionTypeEnum::BUY) {
                    $totalInvested += ($transaction->quantity * $transaction->unit_price);
                } elseif ($transaction->type == TransactionTypeEnum::SELL) {
                    $totalInvested -= ($transaction->quantity * $transaction->unit_price);
                }
            }
        }

        return round($totalInvested, 2);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
