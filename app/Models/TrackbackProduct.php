<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackbackProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'trackback_product_type',
        'asn',
        'brand_id',
        'shipment_id',
        'quantity',
        'total_weight',
        'products'
    ];

    protected $casts = [
        'asn' => 'boolean',
        'products' => 'json',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
