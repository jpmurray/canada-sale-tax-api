<?php

namespace App\Http\Controllers;

use App\Jobs\IncrementStats;
use App\Rates;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class RatesAPIV2Controller extends Controller
{

    private $gstFields;
    private $pstFields;
    private $provinces_codes;

    public function __construct()
    {
        $this->provinces_codes = ['ab', 'bc', 'mb', 'nl', 'ns', 'nt', 'nu', 'on', 'pe', 'qc', 'sk', 'yt'];
        $this->gstFields = ['start', 'type', 'gst', 'applicable', 'source', 'updated_at'];
        $this->pstFields = ['start', 'type', 'pst', 'hst', 'gst', 'applicable', 'source', 'updated_at'];
        $this->allPstFields = ['province', 'start', 'type', 'pst', 'hst', 'gst', 'applicable', 'source', 'updated_at'];
    }

    /**
     * Retuns the currently applicable GST information
     */
    public function getCurrentGst()
    {
        $this->incrementStats();

        return Cache::remember('gst-current-rate', 86400, function () {
            $rates = Rates::where('province', 'all')
                    ->where('start', '<=', Carbon::now())
                    ->orderBy('start', 'DESC')
                    ->get($this->gstFields)
                    ->first();

            $future_rates = Rates::where('province', 'all')
                    ->where('start', '>', Carbon::now())
                    ->orderBy('start', 'DESC')
                    ->get($this->gstFields)
                    ->first();

            if (is_null($future_rates)) {
                $rates['incoming_changes'] = false;
            } else {
                $rates['incoming_changes'] = $future_rates->start;
            }

            return $rates;
        });
    }

    /**
     * Retuns the future applicable GST information
     */
    public function getFutureGst()
    {

        $this->incrementStats();
        return Cache::remember('gst-future-rate', 86400, function () {
            $rate = Rates::where('province', 'all')
                    ->where('start', '>', Carbon::now())
                    ->orderBy('start', 'DESC')->get($this->gstFields)
                    ->first();

            if (is_null($rate)) {
                abort(404, "There is no known future rate for GST.");
            }
            
            return $rate;
        });
    }

    /**
     * Return all of the known GST rates, applicable or not
     */
    public function getHistoricalGst()
    {
        $this->incrementStats();

        return Cache::remember('gst-all-rates', 86400, function () {
            return Rates::where('province', 'all')
                    ->orderBy('start', 'DESC')
                    ->get($this->gstFields);
        });
    }

    /**
     * Retuns PST information for all provinces
     */
    public function getAllPst()
    {
        $this->incrementStats();

        return Cache::remember('pst-all-current-rate', 86400, function () {
            $all = Rates::where('province', '!=', 'all')
                    ->where('start', '<=', Carbon::now())
                    ->orderBy('start', 'DESC')
                    ->get($this->allPstFields)
                    ->groupBy('province')
                    ->map(function ($rates) {
                        $rate = collect($rates->first()->toArray());
                        $rate->forget('province');

                        return $rate;
                    })
                    ->toArray();

            ksort($all);

            return $all;
        });
    }

    /**
     * Retuns the currently applicable PST information
     */
    public function getCurrentPst($province)
    {
        $this->checkProvinceCodeValidity($province);

        $this->incrementStats();
        
        return Cache::remember("pst-{$province}-current-rate", 86400, function () use ($province) {
            $rates = Rates::where('province', $province)
                    ->where('start', '<=', Carbon::now())
                    ->orderBy('start', 'DESC')
                    ->get($this->pstFields)
                    ->first()
                    ->toArray();
        
            $future_rates = Rates::where('province', $province)
                        ->where('start', '>', Carbon::now())
                        ->orderBy('start', 'DESC')
                        ->get($this->pstFields)
                        ->first();

            if (is_null($future_rates)) {
                $rates['incoming_changes'] = false;
            } else {
                $rates['incoming_changes'] = $future_rates->start;
            }

            return $rates;
        });
    }

    /**
     * Retuns the future applicable PST information
     */
    public function getFuturePst($province)
    {
        $this->checkProvinceCodeValidity($province);

        $this->incrementStats();

        return Cache::remember("pst-{$province}-future-rate", 86400, function () use ($province) {
            $rate = Rates::where('province', $province)
                    ->where('start', '>', Carbon::now())
                    ->orderBy('start', 'DESC')
                    ->get($this->pstFields)
                    ->first();

            if (is_null($rate)) {
                abort(404, "There is no known future rate for {$province}.");
            }
            
            return $rate;
        });
    }

    /**
     * Return all of the known PST rates, applicable or not
     */
    public function getHistoricalPst($province)
    {
        $this->checkProvinceCodeValidity($province);

        $this->incrementStats();
        
        return Cache::remember("{$province}-all-rates", 86400, function () use ($province) {
            return Rates::where('province', $province)
                    ->orderBy('start', 'DESC')
                    ->get($this->pstFields);
        });
    }

    private function incrementStats()
    {
        dispatch(new IncrementStats(request()->path()));
    }

    private function checkProvinceCodeValidity($code)
    {
        $province_code_is_valid = in_array($code, $this->provinces_codes) ? true : false;

        if (!$province_code_is_valid) {
            abort(404, 'Invalid two letter province code.');
        }

        return true;
    }
}
