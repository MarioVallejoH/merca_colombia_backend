<?php

namespace App\Http\Controllers;

use App\Models\Countries;

class CountriesController extends Controller
{
    //
    public function getCountries()
    {


        $countries = Countries::all();

        

        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $countries,
            // 'sql'      => $products->toSql()
        ], 200);
    }
}
