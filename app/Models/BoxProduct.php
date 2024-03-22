<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_pallet_id',
        'store_box_id',
        'shipment_id',
        'product_name',
        'product_weight',
        'product_quantity',
        'product_tier',
        'good_resale_condition',
    ];
}
