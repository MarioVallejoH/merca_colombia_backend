<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use Illuminate\Http\Request;

use Validator;


class AddressesController extends Controller
{

    //
    /**
     * Create address, return its id
     *
     * @return integer
     */
    static public function createaddress(array $address_data)
    {

        $address = Addresses::create($address_data);
        return $address->id ?? 0;
    }

    /**
     * Get selected company addresses.
     *
     * Given a company id on request, return all addresses related to it.
     *
     * @param $request  Request   
     *
     * @return \Illuminate\Http\JsonResponse 
     */
    public function getCompanyAddresses(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'company_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }


        $data = Addresses::where("company_id", $request->company_id);
        $response = [
            'success' => true,
            'message' => 'Exito',
            "data" => $data->get()
        ];

        return response()->json($response, 200);
    }

    /**
     * Get address data.
     *
     * Given an address_id on request, return its data.
     * @param $request  Request   
     *
     * @return \Illuminate\Http\JsonResponse 
     */
    public function getAddressData(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'address_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }


        $data = Addresses::where("id", $request->address_id);

        $response = [
            'success' => true,
            'message' => 'Exito',
            "data" => $data->first()
        ];

        return response()->json($response, 200);
    }


    /**
     * Get default company address data.
     *
     * Given a company_id on request, return first address found on ASC order.
     * 
     * @param $request  Request   
     *
     * @return \Illuminate\Http\JsonResponse 
     */
    public function getDefaultAddressData(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'company_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }


        $data = Addresses::where("company_id", $request->company_id)
            ->orderBy('id', "DESC");

        $response = [
            'success' => true,
            'message' => 'Exito',
            "data" => $data->first()
        ];

        return response()->json($response, 200);
    }
}
