<?php

namespace App\Http\Controllers;

use App\Models\States;
use Illuminate\Http\Request;

use Validator;

class StatesController extends Controller
{
    //
    public function getCountryStates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $states = States::where("PAIS",$request->country_code);

        

        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $states->get(),
            // 'sql'      => $products->toSql()
        ], 200);
    }
}
