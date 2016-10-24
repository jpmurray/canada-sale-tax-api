<?php

namespace App\Http\Controllers;

use App\Traits\Rates;

class TaxesController extends Controller {
    use Rates;

    public function getGst() {
        return response()->json(
            $this->getGstRate()
        );
    }

    public function getHst($province) {
        return response()->json(
            $this->getHstRate($province)
        );
    }

    public function getPst($province)
    {
        return response()->json(
            $this->getPstRate($province)
        );
    }

    public function getTotal($province)
    {
        return response()->json(
            $this->getTotalRate($province)
        );
    }

}