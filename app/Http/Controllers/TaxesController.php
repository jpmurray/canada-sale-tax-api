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

        return response()->json($hst);
    }

    public function getPst($province)
    {
        $pst = $this->getPstRate($province);

        if(array_key_exists('error', $pst)){
            return response($pst, 404);
        }

        return response()->json($pst);
    }

    public function getTotal($province)
    {
        return response()->json(
            $this->getTotalRate($province)
        );
    }

}