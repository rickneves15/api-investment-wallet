<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\AssetTypeEnum;
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

    protected function casts(): array
    {
        return [
            'type' => AssetTypeEnum::class,
        ];
    }
}
