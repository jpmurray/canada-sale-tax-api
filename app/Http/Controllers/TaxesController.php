<?php

namespace App\Http\Controllers;

use App\Rates;
use App\Traits\Rates as RatesTrait;

class TaxesController extends Controller
{
    use RatesTrait;

    public function getGst()
    {
        $rate = Rates::where('province', 'all')->orderBy('start', 'DESC')->first();

        return [
            'rate' => $rate->gst,
            'last_modified' => $rate->updated_at->toDateString(),
        ];
    }

    public function getHst($province)
    {
        if ($province == "all") {
            $rates = Rates::where('province', '!=', 'all')->get()->groupBy('province');
            $rates = $rates->map(function ($rates, $province) {
                $rates = $rates->sortByDesc('start');
                $rate = $rates->first();

                return [
                    'rate' => $rate->hst,
                    'last_modified' => $rate->updated_at->toDateString(),
                ];
            });

            return response()->json($rates);
        }

        $rate = Rates::where('province', $province)->orderBy('start', 'DESC')->first();
        
        if ($rate->hst == 0) {
            return response()->json(['code' => 1000, 'message' => "There is no applicable HST in the {$province} region"]);
        }
        
        return [
            'rate' => $rate->hst,
            'last_modified' => $rate->updated_at->toDateString(),
        ];
    }

    public function getPst($province)
    {

        if ($province == "all") {
            $rates = Rates::where('province', '!=', 'all')->get()->groupBy('province');
            $rates = $rates->map(function ($rates, $province) {
                $rates = $rates->sortByDesc('start');
                $rate = $rates->first();

                return [
                    'rate' => $rate->pst,
                    'last_modified' => $rate->updated_at->toDateString(),
                ];
            });

            return response()->json($rates);
        }

        $rate = Rates::where('province', $province)->orderBy('start', 'DESC')->first();

        if ($rate->pst == 0) {
            return response()->json(['code' => 1000, 'message' => "There is no applicable PST in the {$province} region"]);
        }

        return [
        'rate' => $rate->pst,
        'last_modified' => $rate->updated_at->toDateString(),
        ];
    }

    public function getTotal($province)
    {

        if ($province == "all") {
            $rates = Rates::where('province', '!=', 'all')->get()->groupBy('province');
            $rates = $rates->map(function ($rates, $province) {
                $rates = $rates->sortByDesc('start');
                $rate = $rates->first();

                return [
                    'rate' => $rate->applicable,
                    'last_modified' => $rate->updated_at->toDateString(),
                ];
            });

            return response()->json($rates);
        }

        $rate = Rates::where('province', $province)->orderBy('start', 'DESC')->first();

        if ($rate->pst == 0) {
            return response()->json(['code' => 1000, 'message' => "There is no applicable PST in the {$province} region"]);
        }

        return [
            'rate' => $rate->applicable,
            'last_modified' => $rate->updated_at->toDateString(),
        ];
    }
}
