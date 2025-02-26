<?php

namespace App\Http\Resources\v3;

use App\Traits\AddApiMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RateCollection extends ResourceCollection
{

    use AddApiMeta;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */

    public function with(Request $request): array
    {
        return $this->generateMeta();
    }
}
