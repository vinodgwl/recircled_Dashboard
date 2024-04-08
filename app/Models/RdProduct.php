<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdProduct extends Model
{
    use HasFactory;
    // Define the primary key column
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'pallet_id',
        'shipment_id',
        'box_id',
        'brand_id',
        'box_packaging_weight',
        'product_name',
        'product_weight',
        'product_quantity',
        'product_category',
        'product_tier',
        'good_resale_condition',
        'product_created_at',
        'status',
        'reviewd_by',
        'reviewe_by_manager',
    ];

    // Define relationships
    public function box()
    {
        return $this->belongsTo(RdBox::class, 'box_id');
    }
}
