<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdTakebackShipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'takeback_id',
        'is_asn',
        'asn_id',
        'brand_id',
        'shipment_information_id',
        'shipping_origin_zipcode',
        'shipping_carrier',
        'shipping_career_id',
        'shipment_type',
        'pallet_qty',
        'total_weight',
        'shipment_tracking_code',
        'shipment_tracking_URL',
        'added_by',
        'updated_by',
        'status',
        'approved_status',
        'approved_by',
        'shipment_created_at',
        'shipment_updated_at',
    ];

    public $timestamps = false;
    
    // Define the relationship with the Brand model
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function takebackType()
    {
        return $this->belongsTo(RdTakebackType::class, 'takeback_id');
    }
}
