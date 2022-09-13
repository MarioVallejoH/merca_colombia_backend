<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sma_addresses';
    /**
     * To disable timestamp operations
     *
     * @var boolean
     */
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "company_id",
        "direccion",
        "sucursal",
        "city",
        "postal_code",
        "latitude",
        "longitude",
        "state",
        "country",
        "phone",
        "updated_at",
        "city_code",
        "customer_address_seller_id_assigned",
        "customer_group_id",
        "customer_group_name",
        "price_group_id",
        "price_group_name",
        "seller_sale_comision",
        "seller_collection_comision",
        "code",
        "line1",
        "line2",
        "email",
        "vat_no",
        "location",
        "subzone",
        "last_update",
    ];
}
