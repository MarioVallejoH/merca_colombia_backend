<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sma_companies';

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
        "group_id",
        "group_name",
        "customer_group_id",
        "customer_group_name",
        "type_person",
        "name",
        "first_name",
        "second_name",
        "first_lastname",
        "second_lastname",
        "company",
        "commercial_register",
        "tipo_documento",
        "document_code",
        "vat_no",
        "digito_verificacion",
        "address",
        "location",
        "subzone",
        "city",
        "state",
        "postal_code",
        "country",
        "phone",
        "email",
        "cf1",
        "cf2",
        "cf3",
        "cf4",
        "cf5",
        "cf6",
        "invoice_footer",
        "payment_term",
        "logo",
        "award_points",
        "deposit_amount",
        "price_group_id",
        "price_group_name",
        "id_partner",
        "tipo_regimen",
        "city_code",
        "status",
        "birth_month",
        "birth_day",
        "customer_only_for_pos",
        "customer_seller_id_assigned",
        "customer_special_discount",
        "fuente_retainer",
        "iva_retainer",
        "ica_retainer",
        "default_rete_fuente_id",
        "default_rete_iva_id",
        "default_rete_ica_id",
        "default_rete_other_id",
        "customer_payment_type",
        "customer_credit_limit",
        "customer_payment_term",
        "customer_validate_min_base_retention",
        "gender",
        "logo_square",
        "tax_exempt_customer",
        "initial_accounting_balance_transferred",
        "customer_profile_photo",
        "supplier_type",
        "note",
        "last_update",
    ];
}
