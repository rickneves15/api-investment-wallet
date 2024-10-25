<?php

namespace App\Http\Resources\Helper;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginatedJsonResource extends JsonResource
{
    /**
     * Create a new resource collection instance.
     *
     * @param  mixed  $resource
     * @return PaginatedJsonResourceCollection
     */
    protected static function newCollection($resource): PaginatedJsonResourceCollection
    {
        return new PaginatedJsonResourceCollection($resource, static::class);
    }
}
