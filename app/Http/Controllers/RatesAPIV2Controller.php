<?php

namespace App\Http\Controllers;

use App\Rates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RatesAPIV2Controller extends Controller
{
    public function getCurrentGst()
    {
        return Cache::remember('gst-rates', 1440, function () {
            return Rates::where('province', 'all')->orderBy('start', 'DESC')->first();
        });
    }

    public function getHistoricalGst()
    {
        return Cache::remember('gst-rates-all', 1440, function () {
            return Rates::where('province', 'all')->orderBy('start', 'DESC');
        });
    }
}
