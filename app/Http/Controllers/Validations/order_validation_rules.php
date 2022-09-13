<?php
namespace App\Http\Controllers;

/**
 * 
 * This class contains all order validation rules used on orderSales controller
 * 
 */
class OrdersValidationRules{
    static public function getOrderRules(){
        return [
            'customer_id' => 'integer', //Must be a number and length of value is 8
            'customer' => 'required',
            'biller_id' => 'integer',
            'biller' => 'nullable',
            'warehouse_id' => 'integer',
            'note' => 'nullable',
            'staff_note' => 'nullable',
            'total' => 'numeric',
            'product_discount' => 'numeric',
            'order_discount_id' => 'nullable|integer',
            'total_discount' => 'numeric',
            'order_discount' => 'numeric',
            'product_tax' => 'numeric',
            'order_tax_id' => 'nullable|integer',
            'order_tax' => 'nullable|numeric',
            'total_tax' => 'numeric',
            'shipping' => 'nullable|numeric',
            'grand_total' => 'numeric',
            'sale_status' => 'required',
            // 'payment_status' => 'required',
            'payment_term' => 'nullable',
            'due_date' => 'nullable|date',
            'created_by' => 'nullable|integer',
            'total_items' => 'nullable|integer',
            'pos' => 'nullable|integer',
            'paid' => 'nullable|numeric',
            'surcharge' => 'nullable|numeric',
            'attachment' => 'nullable',
            'return_sale_ref' => 'nullable',
            'sale_id' => 'nullable|integer',
            'rounding' => 'nullable|numeric',
            'api' => 'nullable|integer',
            'shop' => 'nullable|integer',
            'seller_id' => 'integer',
            'address_id' => 'nullable|integer',
            'reserve_id' => 'nullable|integer',
            'payment_method' => 'nullable',
            // 'resolucion' => 'required',
            'document_type_id' => 'nullable|integer',
            'delivery_time_id' => 'nullable|integer',
            'delivery_day' => 'nullable|date',
            'order_sale_origin' => 'nullable|integer',
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