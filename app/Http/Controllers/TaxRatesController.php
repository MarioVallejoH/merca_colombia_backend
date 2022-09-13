<?php

namespace App\Http\Controllers;

use App\Models\TaxRates;
use Illuminate\Http\Request;

class TaxRatesController extends Controller
{
    /**
     * Return all preferences categories in DB
     *
     *  @return \Illuminate\Http\Response
     */
    public function getTaxRates()
    {


        $units = TaxRates::all();

        

        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $units,
            // 'sql'      => $products->toSql()
        ], 200);
    }
}
