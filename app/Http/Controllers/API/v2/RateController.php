<?php

namespace App\Http\Controllers\API\v2;

use App\Models\Rate;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\V2RateResource;
use App\Http\Resources\V2RateCollection;

class RateController extends Controller
{
    private $gstFields = ['start', 'type', 'gst', 'applicable', 'source', 'updated_at'];
    private $pstFields = ['start', 'type', 'pst', 'hst', 'gst', 'applicable', 'source', 'updated_at'];
    private $provinces_codes = ['ab', 'bc', 'mb', 'nb', 'nl', 'ns', 'nt', 'nu', 'on', 'pe', 'qc', 'sk', 'yt'];
    private $allPstFields = ['province', 'start', 'type', 'pst', 'hst', 'gst', 'applicable', 'source', 'updated_at'];

    /**
     * Retuns the currently applicable GST information.
     */
    public function getCurrentGst()
    {
        return Cache::remember('v2-gst-current-rate', 86400, function () {
            $rates = Rate::where('province', 'all')
                ->where('start', '<=', Carbon::now())
                ->orderBy('start', 'DESC')
                ->get($this->gstFields)
                ->first();

            $future_rates = Rate::where('province', 'all')
                ->where('start', '>', Carbon::now())
                ->orderBy('start', 'DESC')
                ->get($this->gstFields)
                ->first();

            if (is_null($future_rates)) {
                $rates['incoming_changes'] = false;
            } else {
                $rates['incoming_changes'] = $future_rates->start;
            }

            return new V2RateResource($rates);
        });
    }

    /**
     * Retuns the future applicable GST information.
     */
    public function getFutureGst()
    {
        return Cache::remember('v2-gst-future-rate', 86400, function () {
            $rate = Rate::where('province', 'all')
                ->where('start', '>', Carbon::now())
                ->orderBy('start', 'DESC')->get($this->gstFields)
                ->first();

            if (is_null($rate)) {
                abort(404, 'There is no known future rate for GST.');
            }

            return new V2RateResource($rate);
        });
    }

    /**
     * Return all of the known GST rates, applicable or not.
     */
    public function getHistoricalGst()
    {
        return Cache::remember('v2-gst-all-rates', 86400, function () {
            $rates = Rate::where('province', 'all')
                ->orderBy('start', 'DESC')
                ->get($this->gstFields);

            return new V2RateCollection($rates);
        });
    }

    /**
     * Retuns PST information for all provinces.
     */
    public function getAllPst()
    {
        return Cache::remember('v2-pst-all-current-rate', 86400, function () {
            $all = Rate::where('province', '!=', 'fe')
                ->orderBy('start', 'DESC')
                ->get($this->allPstFields)
                ->groupBy('province')
                ->map(function ($rates) {
                    return new V2RateResource($rates->first());
                })->toArray();

            ksort($all);

            $sorted = collect($all);

            return $sorted->all();
        });
    }

    /**
     * Retuns the currently applicable PST information.
     */
    public function getCurrentPst($province)
    {
        $this->checkProvinceCodeValidity($province);

        return Cache::remember("pst-{$province}-current-rate", 86400, function () use ($province) {
            $rates = Rate::where('province', $province)
                ->where('start', '<=', Carbon::now())
                ->orderBy('start', 'DESC')
                ->get($this->pstFields)
                ->first();

            $future_rates = Rate::where('province', $province)
                ->where('start', '>', Carbon::now())
                ->orderBy('start', 'DESC')
                ->get($this->pstFields)
                ->first();

            if (is_null($future_rates)) {
                $rates['incoming_changes'] = false;
            } else {
                $rates['incoming_changes'] = $future_rates->start;
            }

            return new V2RateResource($rates);
        });
    }

    /**
     * Retuns the future applicable PST information.
     */
    public function getFuturePst($province)
    {
        $this->checkProvinceCodeValidity($province);

        return Cache::remember("pst-{$province}-future-rate", 86400, function () use ($province) {
            $rate = Rate::where('province', $province)
                ->where('start', '>', Carbon::now())
                ->orderBy('start', 'DESC')
                ->get($this->pstFields)
                ->first();

            if (is_null($rate)) {
                abort(404, "There is no known future rate for {$province}.");
            }

            return new V2RateResource($rate);
        });
    }

    /**
     * Return all of the known PST rates, applicable or not.
     */
    public function getHistoricalPst($province)
    {
        $this->checkProvinceCodeValidity($province);

        return Cache::remember("{$province}-all-rates", 86400, function () use ($province) {
            return Rate::where('province', $province)
                ->orderBy('start', 'DESC')
                ->get($this->pstFields);
        });
    }

    private function checkProvinceCodeValidity($code)
    {
        $province_code_is_valid = in_array((strtolower($code)), $this->provinces_codes) ? true : false;

        if (! $province_code_is_valid) {
            abort(404, 'Invalid two letter province code.');
        }

        return true;
    }
}
