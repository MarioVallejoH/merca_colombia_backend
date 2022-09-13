<?php

namespace App\Http\Controllers;

use App\Models\OrderSaleItems;
use Illuminate\Http\Request;

use Validator;


class OrderSaleItemsController extends Controller
{
    /**
     * Insert order items inside order_sale_items, $items param shoul be an array of arrays, where keys are
     * table names for each value
     *
     * @param array $items
     * @param integer $orderSaleId
     * 
     * @return int|null
     */
    static public function insertOrderItems($items,$orderSaleId){
   

        // save order id inside all order items
        for ($i=0; $i < count($items); $i++) { 
            $items[$i]['sale_id'] = $orderSaleId;
        }
        $result = OrderSaleItems::insert($items);

        return $result;
    } 
    /**
     * Given an order sale id, returns it's items
     *
     * @param integer $orderId
     * @return array|null
     */
    static public function getOrderItems($orderId){
        $items = OrderSaleItems::where('sale_id',$orderId)
                                ->get();
        return $items;
    }

    /**
     * Gets order details
     *
     * @return HttpResponse
     */
    public function orderDetails (Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $order_details = OrderSaleItems::where('sale_id',$request->order_id);

        $response = [
            'success' => true,
            'error' => false,
            'message' => "Success!",
            'data' => $order_details->get(),
        ];

        return response()->json($response, 200);
    }

}
