<?php

namespace App\Http\Controllers;

use App\Models\BillerData;
use Illuminate\Http\Request;

use Validator;


class BillerDataController extends Controller
{   

    /**
     * Fucnction to get biller data
     *
     * Given biller data in request info, return its related data on billerData table
     *
     * @param Request $request Request data
     * @return \Illuminate\Http\JsonResponse
     **/
    public function billerData(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'biller_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }
        $billerData = BillerData::where("biller_id",$request->biller_id);

        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $billerData->first(),
            // 'sql'      => $products->toSql()
        ], 200);
    }

    /**
     * Get BillerData bi BillerId.
     *
     * Given biller_id param, return its data in sma_biller_data table.
     *
     * @param int $biller_id biller id from biller_data
     * @return array
     **/
    static public function getBillerData(int $biller_id)
    {
        $biller_data = BillerData::where("biller_id",$biller_id)
                                ->first();
        return $biller_data;
    }
}
