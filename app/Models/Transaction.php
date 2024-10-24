<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'asset_id',
        'type',
        'quantity',
        'unit_price',
        'transaction_date',
    ];

    protected function casts(): array
    {
        return [
            'type' => TransactionTypeEnum::class,
        ];
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
