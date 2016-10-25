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
        $hst = $this->getHstRate($province);
        
        if(array_key_exists('error', $hst)){
            return response($hst, 404);
        }

        return response()->json(
            $this->getHstRate($province)
        );
    }

    public function getPst($province)
    {
        if(array_key_exists('error', $hst)){
            return response($hst, 404);
        }

        return response()->json(
            $this->getHstRate($province)
        );
    }

    public function getTotal($province)
    {
        return response()->json(
            $this->getTotalRate($province)
        );
    }

}