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

     /**
     * Accessor method to get the count of opened boxes.
     */
    public function getOpenCountAttribute()
    {
        return $this->storeBoxes()->where('status', 1)->count();
    }

    /**
     * Accessor method to get the count of unopened boxes.
     */
    public function getUnopenedCountAttribute()
    {
        return $this->storeBoxes()->where('status', 0)->count();
    }

    /**
     * Accessor method to get the total count of boxes.
     */
    public function getTotalCountAttribute()
    {
        return $this->storeBoxes()->count();
    }

    /**
     * Relationship to fetch related store boxes.
     */
    public function storeBoxes()
    {
        return $this->hasMany(StoreBox::class);
    }
}
