<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'purchaseDate' => $this->purchase_date,
            'quantity' => $this->quantity,
            'quote' => $this->quote,
            'type' => $this->type,
            'totalInvested' => $this->total_invested,
            'transactions' => TransactionResource::collection($this->transactions),
        ];
    }
}
