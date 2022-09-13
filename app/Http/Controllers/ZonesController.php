<?php

namespace App\Http\Controllers;

use App\Models\Zones;
use Illuminate\Http\Request;

use Validator;


class ZonesController extends Controller
{
    //

    public function getCityZones(Request $request){

        

        $validator = Validator::make($request->all(), [
            'city_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }
     
        
        $data = Zones::where("codigo_ciudad",$request->city_code);
        $response = [
            'success' => true,

            'message' => 'Exito',
            "data"=>$data->get()
        ];

         return response()->json($response,200);

        

    }
}
