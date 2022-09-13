<?php

namespace App\Http\Controllers;

use App\Models\OrderSales;
use Illuminate\Http\Request;

use Validator;

use function PHPUnit\Framework\isEmpty;

class OrderSalesController extends Controller
{
    /**
     * Creates a new order sale given order sale data sended by a http post.
     *
     * @return HttpResponse
     */
    public function create(Request $request)
    {

        $order_data = $request->order;

        $order_items = $request->order_items;

        $response = [];
        $response_code = 400;
        // validate order data

        //TODO: Function to validate order_items data

        // $order_items_val = Validator::make($order_data, OrdersValidationRules::getOrderRules());

        if (empty($order_data ?? []) || empty($order_items ?? [])) {
            $response = [
                'success' => false,
                'error' => true,
                'message' => (isEmpty($order_data) ? 'order required, ' : '') . (isEmpty($order_items) ? 'order_items required' : ''),
                'data' => [],
            ];
        } else {
            $order_data_val = Validator::make($order_data, OrdersValidationRules::getOrderValRules());
            if (!$order_data_val->passes() || !is_array($order_items)) {

                // if validation fails

                $response = [
                    'success' => false,
                    'message' => $order_data_val->errors()->all(),
                    'data' => [],
                ];
            } else {
                // validate if order_sales info is in request

                if ($order_data != null) {
                    // get order items data

                    //insert order data into order_sales mode


                    $refNo = "";

                    try {
                        // $refNo=0;
                        if (isset($refNo)) {
                            $order_data['reference_no'] = $refNo;
                        }
                        // print_r($order_data);

                        // // print_r($order_items);

                        $orderSaleId = OrderSales::insertGetId($order_data);

                        if ($orderSaleId ?? false) {
                            // switch to OrderSaleItemModel

                            $result = OrderSaleItemsController::insertOrderItems($order_items, $orderSaleId);
                            // check everythings goes nice
                            if ($result != false && $result == count($order_items)) {
                                // send email to notify new order
                                // helper('email');
                                // sendOrderEmail($order_data, $order_items);
                                $response = [
                                    'success' => true,
                                    'error' => false,
                                    'message' => "Pedido registrado",
                                    'data' => [
                                        'order_sale_id' => $orderSaleId,
                                        'reference_no' => $refNo,
                                    ],
                                ];
                                $response_code = 200;
                            } else {
                                //if neeeded we can undo document consecutive
                                // if(isset($refNo)){
                                //     SmaDocumentsTypes::undoReferenceNo($order_data['document_type_id']);
                                // }
                                //TODO: Create method to disable order sale
                                // set orderSale status to error
                                // $this->disableOrderSale($orderSaleId);

                                $response = [
                                    'success' => false,
                                    'error' => true,
                                    'message' => "Eror al registrar items de pedido",
                                    'data' => [],
                                ];
                                $response_code = 400;
                            }
                        }
                    } catch (\Throwable $th) {
                        //if neeeded we can undo document consecutive
                        // if(isset($refNo)){
                        //     SmaDocumentsTypes::undoReferenceNo($order_data['document_type_id']);
                        // }

                        // if orderSales was inserted to db, then set status to error
                        if ($orderSaleId ?? false) {
                            // $this->disableOrderSale($orderSaleId);
                        }

                        $response = [
                            'success' => false,
                            'error' => true,
                            'message' => "Eror al registrar el pedido",
                            'error_message' => "$th",
                            'data' => [],
                        ];
                        $response_code = 400;
                    }
                } else {
                    $response = [
                        'success' => false,
                        'error' => true,
                        'message' => "El campo order_sales es necesario",
                        'data' => [],
                    ];
                    $response_code = 400;
                }
            }
        }

        return response()->json($response, $response_code);
    }

    /**
     * Gets all customer orders
     *
     * @return HttpResponse
     */
    public function customerOrders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $orders = OrderSales::where("customer_id", $request->customer_id)->orderBy('registration_date', "DESC");

        $response = [
            'success' => true,
            'error' => false,
            'message' => "Success!",
            'data' => $orders->get(),
        ];

        return response()->json($response, 200);
    }

    /**
     * Gets amount of customer orders.
     *
     * @return HttpResponse
     */
    public function customerOrdersCount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $orders = OrderSales::where("customer_id", $request->customer_id);

        $response = [
            'success' => true,
            'error' => false,
            'message' => "Success!",
            'data' => $orders->get()->count(),
        ];

        return response()->json($response, 200);
    }
}


/**
 * 
 * This class contains all order validation rules used on orderSales controller
 * 
 */
class OrdersValidationRules
{
    static public function getOrderValRules()
    {
        return [
            'customer_id' => 'integer', //Must be a number and length of value is 8
            'customer' => 'required',
            'note' => 'nullable',
            'total' => 'numeric',
            'product_discount' => 'numeric',
            'total_discount' => 'numeric',
            'order_discount' => 'numeric',
            'product_tax' => 'numeric',
            'order_tax_id' => 'nullable|integer',
            'order_tax' => 'nullable|numeric',
            'total_tax' => 'numeric',
            'grand_total' => 'numeric',
            'sale_status' => 'required',
            // 'payment_status' => 'required',
            'payment_term' => 'nullable',
            'created_by' => 'nullable|integer',
            'total_items' => 'nullable|integer',
            'paid' => 'nullable|numeric',
            'address_id' => 'nullable|integer',
            'payment_method' => 'nullable',
        ];
    }
    // static public function getSyncMessages(){
    //     return [
    //         'last_sync' => [
    //             'required' => 'Tipo de dato no valido',
    //         ],
    //         // 'first_time' => [
    //         //     'required' => '',
    //         // ],

    //     ];
    // }
}
