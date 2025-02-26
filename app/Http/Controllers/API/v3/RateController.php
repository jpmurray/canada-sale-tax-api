<?php

namespace App\Http\Controllers\API\v3;

use App\Models\Rate;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\v3\RateResource;
use App\Http\Resources\v3\RateCollection;

class RateController extends Controller
{

    /**
     * Retuns the currently applicable GST information.
     */
    public function getCurrentGst()
    {
        request()->user()->tokenCan('read');

        return Cache::remember('v3-gst-current-rate', 86400, function () {
            $rates = Rate::where('province', 'fe')
                ->where('start', '<=', Carbon::now())
                ->orderBy('start', 'DESC')
                ->first();

            $future_rates = Rate::where('province', 'fe')
                ->where('start', '>', Carbon::now())
                ->orderBy('start', 'DESC')
                ->first();

            if (is_null($future_rates)) {
                $rates['incoming_changes'] = false;
            } else {
                $rates['incoming_changes'] = $future_rates->start;
            }

            return new RateResource($rates);
        });
    }

    /**
     * Retuns the future applicable GST information.
     */
    public function getFutureGst()
    {
        request()->user()->tokenCan('read');

        return Cache::remember('v3-gst-future-rate', 86400, function () {
            $rate = Rate::where('province', 'all')
                ->where('start', '>', Carbon::now())
                ->orderBy('start', 'DESC')
                ->first();

            if (is_null($rate)) {
                abort(404, 'There is no known future rate for GST.');
            }

            return new RateResource($rate);
        });
    }

    /**
     * Return all of the known GST rates, applicable or not.
     */
    public function getHistoricalGst()
    {
        request()->user()->tokenCan('read');

        return Cache::remember('v3-gst-all-rates', 86400, function () {
            $rates = Rate::where('province', 'fe')
                ->orderBy('start', 'DESC')
                ->get();

            return new RateCollection($rates);
        });
    }

    /**
     * Retuns PST information for all provinces.
     */
    public function getAllPst()
    {
        request()->user()->tokenCan('read');

        return Cache::remember('v3-pst-all-current-rate', 86400, function () {
            $all = Rate::where('province', '!=', 'fe')
                ->orderBy('start', 'DESC')
                ->get()
                ->groupBy('province')
                ->map(function ($rates) {
                    return new RateResource($rates->first());
                })->toArray();

            ksort($all);

            $sorted = collect($all);

            return new RateCollection($sorted->all());
        });
    }

    /**
     * Retuns the currently applicable PST information.
     */
    public function getCurrentPst($province)
    {
        request()->user()->tokenCan('read');

        $this->checkProvinceCodeValidity($province);

        return Cache::remember("pst-{$province}-current-rate", 86400, function () use ($province) {
            $rates = Rate::where('province', $province)
                ->where('start', '<=', Carbon::now())
                ->orderBy('start', 'DESC')
                ->first();

            $future_rates = Rate::where('province', $province)
                ->where('start', '>', Carbon::now())
                ->orderBy('start', 'DESC')
                ->first();

            if (is_null($future_rates)) {
                $rates['incoming_changes'] = false;
            } else {
                $rates['incoming_changes'] = $future_rates->start;
            }

            return new RateResource($rates);
        });
    }

    /**
     * Retuns the future applicable PST information.
     */
    public function getFuturePst($province)
    {
        request()->user()->tokenCan('read');

        $this->checkProvinceCodeValidity($province);

        return Cache::remember("pst-{$province}-future-rate", 86400, function () use ($province) {
            $rate = Rate::where('province', $province)
                ->where('start', '>', Carbon::now())
                ->orderBy('start', 'DESC')
                ->first();

            if (is_null($rate)) {
                abort(404, "There is no known future rate for {$province}.");
            }

            return new RateResource($rate);
        });
    }

    /**
     * Return all of the known PST rates, applicable or not.
     */
    public function getHistoricalPst($province)
    {
        request()->user()->tokenCan('read');

        $this->checkProvinceCodeValidity($province);

        return Cache::remember("{$province}-all-rates", 86400, function () use ($province) {
            return Rate::where('province', $province)
                ->orderBy('start', 'DESC')
                ->get();
        });
    }

    private function checkProvinceCodeValidity($code)
    {
        $provinces = ['ab', 'bc', 'mb', 'nb', 'nl', 'ns', 'nt', 'nu', 'on', 'pe', 'qc', 'sk', 'yt'];
        $province_code_is_valid = in_array((strtolower($code)), $provinces) ? true : false;

        if (! $province_code_is_valid) {
            abort(404, 'Invalid two letter province code.');
        }

        return true;
    }
}
