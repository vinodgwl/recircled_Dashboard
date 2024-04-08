<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdBox extends Model
{
    use HasFactory;

    // Define the primary key column
    protected $primaryKey = 'box_id';

    protected $fillable = [
        'pallet_id',
        'shipment_id',
        'box_gen_code',
        'pallet_gen_code',
        'brand_id',
        'box_weight',
        'product_category',
        'pre_consumer',
        'box_created_at',
        'status',
        'reviewd_by',
        'reviewe_by_manager',
    ];

    /**
     * Get the pallet that owns the box.
     */
    public function pallet()
    {
        return $this->belongsTo(RdPallet::class, 'pallet_id');
    }
}
