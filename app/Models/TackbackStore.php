<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TackbackStore extends Model
{
    use HasFactory;
    protected $fillable = [
        'trackback_product_store_type',
        'asn',
        'brand_id',
        'shipment_id',
        'shipping_origin_zipcode',
        'shipping_carrier',
        'shipping_carrier_name',
        'type',
        'quantity',
        'total_weight',
        'pallet_unique_id',
        'created_store_date_time',
        'store_sub_brand',
        'pallet_weight',
    ];
     protected $casts = [                
        'pallet_unique_id' => 'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
