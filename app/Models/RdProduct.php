<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdProduct extends Model
{
    use HasFactory;
    // Define the primary key column
    protected $primaryKey = 'box_product_id';

    protected $fillable = [
        'brand_id',
        'shipment_id',
        'pallet_id',
        'box_id',
        'product_category',
        'product_type',
        'product_weight',
        'product_quantity',
        'product_tier',
        'good_resale_condition',
        'added_by',
        'updated_by',
        'approved_status',
        'approved_by',
    ];

    // Define relationships
    public function box()
    {
        return $this->belongsTo(RdBox::class, 'box_id');
    }
}
