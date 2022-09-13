<?php

namespace App\Http\Controllers;

use App\Models\SubZones;
use Illuminate\Http\Request;

use Validator;

class SubZonesController extends Controller
{
    //
    public function getSubzones(Request $request){

        

        $validator = Validator::make($request->all(), [
            'zone_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }
     
        
        $data = SubZones::where("zone_code",$request->zone_code);
        $response = [
            'success' => true,
            'message' => 'Exito',
            "data"=>$data->get()
        ];

        return response()->json($response,200);

        

    }
}
