<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use Illuminate\Http\Request;
use Validator;

class CitiesController extends Controller
{
    //
    public function getStateCities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $cities = Cities::where("CODDEPARTAMENTO",$request->state_code);

        

        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $cities->get(),
            // 'sql'      => $products->toSql()
        ], 200);
    }
}
