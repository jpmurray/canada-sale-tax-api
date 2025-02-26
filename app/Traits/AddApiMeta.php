<?php

namespace App\Traits;

use App\Models\Alert;
use Illuminate\Http\Request;

trait AddApiMeta
{
    private function generateMeta()
    {
        return [
            'meta' => [
                'timestamp' => now()->toJSON(),
                'version' => 3,
                'alerts' => Alert::where('active', true)->get(["type", "message", "created_at"]),
            ],
        ];
    }
}
