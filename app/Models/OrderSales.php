<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSales extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sma_order_sales';

    /**
     * Default values of order_sales
     *
     * @var array
     */
    protected $attributes = [ 
        
    ];
}
