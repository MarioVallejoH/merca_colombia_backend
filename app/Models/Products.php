<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sma_products';

    public function saleItems()
    {
        $this->belongTo('App\SaleItems');
    }
}
