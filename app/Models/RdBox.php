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
        'brand_id',
        'shipment_id',
        'pallet_id',
        'box_code',
        'box_weight',
        'product_category',
        'consumer',
        'status',
        'added_by',
        'updated_by',
        'approved_status',
        'approved_by'
    ];

    /**
     * Get the pallet that owns the box.
     */
    public function pallet()
    {
        return $this->belongsTo(RdPallet::class, 'pallet_id');
    }
}
