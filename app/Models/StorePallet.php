<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePallet extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_pallets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pallet_unique_id', 
        'store_sub_brand', 
        'pallet_weight', 
        'shipment_id', 
        'created_store_shipment_date_time', 
        'status',
        'tackback_store_id',
        'pallet_packaging_material',
        'box_quantity',
    ];

    protected $casts = [                
        'pallet_unique_id' => 'array',
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_store_shipment_date_time',
        'created_at',
        'updated_at',
    ];

    
    /**
     * Get the store that owns the pallet.
     */
    public function store()
    {
        return $this->belongsTo(TackkbackStore::class, 'tackkback_store_id');
    }
}
