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

    public function __construct()
    {
        $this->gstFields = ['start', 'type', 'gst', 'applicable', 'source', 'updated_at'];
        $this->pstFields = ['start', 'type', 'pst', 'hst', 'gst', 'applicable', 'source', 'updated_at'];
        $this->allPstFields = ['province', 'start', 'type', 'pst', 'hst', 'gst', 'applicable', 'source', 'updated_at'];

        dispatch(new IncrementStats(request()->path()));
    }

    /**
     * Retuns the currently applicable GST information
     */
    public function getCurrentGst()
    {
        return Cache::remember('gst-current-rate', 1440, function () {
            return Rates::where('province', 'all')
                    ->where('start', '<=', Carbon::now())
                    ->orderBy('start', 'DESC')
                    ->get($this->gstFields)
                    ->first();
        });
    }

    /**
     * Retuns the future applicable GST information
     */
    public function getFutureGst()
    {
        return Cache::remember('gst-future-rate', 1440, function () {
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
        return Cache::remember('pst-all-rates', 1440, function () {
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

        return Cache::remember('pst-all-current-rate', 1440, function () {
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
        return Cache::remember('pst-current-rate', 1440, function () use ($province) {
            return Rates::where('province', $province)
                    ->where('start', '<=', Carbon::now())
                    ->orderBy('start', 'DESC')
                    ->get($this->pstFields)
                    ->first();
        });
    }

    /**
     * Retuns the future applicable PST information
     */
    public function getFuturePst($province)
    {
        return Cache::remember('pst-future-rate', 1440, function () use ($province) {
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
        return Cache::remember("{$province}-all-rates", 1440, function () use ($province) {
            return Rates::where('province', $province)
                    ->orderBy('start', 'DESC')
                    ->get($this->pstFields);
        });
    }
}
