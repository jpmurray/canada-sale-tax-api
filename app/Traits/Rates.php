<?php

namespace App\Traits;

use Carbon\Carbon;

trait Rates {

    /**
     * Return the GST amount
     * @return array           Array containing the requested information
     */
    public function getGstRate() {
        $last_modified = Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto');
        $rate = 0.05;

        return [
            'rate' => $rate,
            'last_modified' => $last_modified->toDateString(),
        ];
    }

    /**
     * Return the HST amount for a province
     * @param  str $province A two letter representation of the province, or "all"
     * @return array           Array containing the requested information
     */
    public function getHstRate($province) {
        $hst = collect([
            'ab' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'bc' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'mb' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nb' => ['rate' => 0.15, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nl' => ['rate' => 0.15, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nt' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'ns' => ['rate' => 0.15, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nu' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'on' => ['rate' => 0.13, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'pe' => ['rate' => 0.15, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'qc' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'sk' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'yt' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
        ]);

        return ($province == "all" ? $hst : $hst->get($province));
    }

    /**
     * Get the PST amount for a province
     * @param  str $province A two letter representation of the province, or "all"
     * @return array           Array containing the requested information
     */
    public function getPstRate($province) {

        $pst = collect([
            'ab' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'bc' => ['rate' => 0.07, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'mb' => ['rate' => 0.08, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nb' => ['rate' => 0.10, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nl' => ['rate' => 0.10, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nt' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'ns' => ['rate' => 0.10, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nu' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'on' => ['rate' => 0.08, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'pe' => ['rate' => 0.09, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'qc' => ['rate' => 0.9975, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'sk' => ['rate' => 0.05, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'yt' => ['rate' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
        ]);

        return ($province == "all" ? $pst : $pst->get($province));
    }

    /**
     * Get the total applicable tax amount for a province and it's type
     * @param  str $province A two letter representation of the province, or "all"
     * @return array           Array containing the requested information
     */
    public function getTotalRate($province) {

        $total = collect([
            'ab' => ['rate' => 0.05, 'type' => 'GST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'bc' => ['rate' => 0.12, 'type' => 'GST+PST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'mb' => ['rate' => 0.13, 'type' => 'GST+PST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nb' => ['rate' => 0.15, 'type' => 'HST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nl' => ['rate' => 0.15, 'type' => 'HST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nt' => ['rate' => 0.05, 'type' => 'GST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'ns' => ['rate' => 0.15, 'type' => 'HST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'nu' => ['rate' => 0.05, 'type' => null, 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'on' => ['rate' => 0.13, 'type' => 'HST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'pe' => ['rate' => 0.14, 'type' => 'HST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'qc' => ['rate' => 0.14975, 'type' => 'GST+PST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'sk' => ['rate' => 0.10, 'type' => 'GST+PST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
            'yt' => ['rate' => 0.05, 'type' => 'GST', 'last_modified' => Carbon::create(2016, 10, 1, 0, 0, 0, 'America/Toronto')->toDateString()],
        ]);

        return ($province == "all" ? $total : $total->get($province));
    }
}