<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdTakebackShipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'trackback_type_store_customer_warehouse',
        'asn',
        'brand_id',
        'shipment_information_id',
        'shipping_origin_zipcode',
        'shipping_carrier',
        'shipping_carrier_name',
        'box_type',
        'quantity',
        'total_weight',
        'reviewd_by',
        'reviewe_by_manager',
        'shipment_created_at',
    ];

    public $timestamps = false;
    
    // Define the relationship with the Brand model
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
