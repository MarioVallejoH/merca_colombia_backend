<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSaleItems extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sma_order_sale_items';

    /**
     * Default values of order_sale_items
     *
     * @var array
     */
    protected $attributes = [ 
        
    ];

     /**
     * To disable timestamp operations
     *
     * @var boolean
     */
    
    public $timestamps = false;
}
