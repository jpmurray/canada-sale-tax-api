<?php

namespace App\Http\Resources\v3;

use App\Traits\AddApiMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{

    use AddApiMeta;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "province" => $this->when($this->province, $this->province),
            "start" => $this->when($this->start, $this->start->toDatetimeString()),
            "type" => $this->when($this->type, $this->type),
            "gst" => $this->when($this->gst, $this->gst),
            "pst" => $this->when($this->pst, $this->pst),
            "hst" => $this->when($this->hst, $this->hst),
            "applicable" => $this->when($this->applicable, $this->applicable),
            "source" => $this->when($this->source, $this->source),
            "updated_at" => $this->when($this->updated_at, $this->updated_at->toDatetimeString()),
            "incoming_changes" => $this->incoming_changes ? $this->incoming_changes->toDatetimeString() : false,
        ];
    }

    public function with(Request $request): array
    {
        return $this->generateMeta();
    }
}
