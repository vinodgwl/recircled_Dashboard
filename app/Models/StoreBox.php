<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreBox extends Model
{
    use HasFactory;
    protected $fillable = [
        'box_unique_id',
        'pallet_unique_id',
        'shipment_id',
        'box_weight',
        'product_category',
        'pre_consumer',
        'created_store_box_date_time',
        'status',
        'store_pallet_id'
    ];

    // Define the relationship with StorePallet model
    public function storePallet()
    {
        return $this->belongsTo(StorePallet::class);
    }
}
