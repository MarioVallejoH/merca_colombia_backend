<?php

namespace App\Http\Controllers;

use App\Models\Units;
use Illuminate\Http\Request;
use Validator;



class UnitsController extends Controller
{
    public function getUnits(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_group' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }
        $units = Units::select('*');
        $exempt_units = CustomerGroupsController::getExemptUnits($request->customer_group);
        if (!empty($exempt_units ?? [])) {
            $units->whereNotIn('id', $exempt_units);
        }
        return response()->json([
            'success'   => true,
            'message'   => 'Success!',
            'data'      => $units->get(),
            'sql'      => $units->toSql()
        ], 200);
    }
}
