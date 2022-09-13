<?php

namespace App\Http\Controllers;


use App\Models\UnitsPrices;
use Illuminate\Http\Request;
use Validator;

class UnitsPricesController extends Controller
{
    /**
     *     Given a product Id, returns all unit prices related o him.

     *    @return \Illuminate\Http\Response
     */
    public function getProductUnitsPrice(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'customer_group' => 'nullable|integer',
            "unit" => 'required_without:customer_group|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $product_id = ($request->product_id) ?? "";
        $unit_prices = UnitsPrices::where('id_product', $product_id);
        if (!empty($request->customer_group ?? '')) {
            $exempt_units = CustomerGroupsController::getExemptUnits($request->customer_group);
            // print_r($exempt_units);
            
            if (!empty($exempt_units ?? [])) {
                $unit_prices->whereNotIn('unit_id', $exempt_units);
            }
        }
        if (!empty($request->unit ?? '')) {
            $unit_prices->where('unit_id', '=', $request->unit,);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $unit_prices->get(),
            'sql'      => $unit_prices->toSql(),
            // 'bindings' => $products->getBindings()
        ], 200);
    }
}
