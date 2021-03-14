<?php

namespace App\Http\Controllers;

use App\Rates;
use App\Services\Stats;
use Illuminate\Support\Facades\Cache;

class RatesAPIV1Controller extends Controller
{
    public function __construct()
    {
        (new Stats())->setRequest(request())->dispatch();
    }

    public function getGst()
    {
        return Cache::remember('gst-rates', 86400, function () {
            $rate = Rates::where('province', 'all')->orderBy('start', 'DESC')->first();

            return [
                'rate' => $rate->gst,
                'last_modified' => $rate->updated_at->toDateString(),
            ];
        });
    }

    private function provinceRates($province, $field)
    {
        if ($province == 'all') {
            $rates = Rates::where('province', '!=', 'all')->get()->groupBy('province');

            $rates = $rates->map(function ($rates, $province) use ($field) {
                $rates = $rates->sortByDesc('start');
                $rate = $rates->first();

                return [
                    'rate' => $rate->$field,
                    'last_modified' => $rate->updated_at->toDateString(),
                ];
            })->toArray();

            ksort($rates);

            return response()->json($rates);
        } else {
            $rate = Rates::where('province', $province)->orderBy('start', 'DESC')->first();

            if ($rate->$field == 0) {
                return response()->json(['code' => 1000, 'message' => "There is no applicable {$field} in the {$province} region"]);
            }

            return [
                'rate' => $rate->$field,
                'last_modified' => $rate->updated_at->toDateString(),
            ];
        }
    }

    public function getHst($province)
    {
        return Cache::remember("hst-{$province}", 86400, function () use ($province) {
            return $this->provinceRates($province, 'hst');
        });
    }

    public function getPst($province)
    {
        return Cache::remember("pst-{$province}", 86400, function () use ($province) {
            return $this->provinceRates($province, 'pst');
        });
    }

    public function getTotal($province)
    {
        return Cache::remember("applicable-{$province}", 86400, function () use ($province) {
            return $this->provinceRates($province, 'applicable');
        });
    }
}
