<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdPallet extends Model
{
    // Define the primary key column
    protected $primaryKey = 'pallet_id';
    
    use HasFactory;
    protected $fillable = [
        'shipment_id',
        'pallet_gen_code',
        'brand_id',
        'sub_brand',
        'pallet_weight',
        'box_quantity',
        'pallet_created_at',
        'status',
        'reviewd_by',
        'reviewe_by_manager',
    ];

     protected $dates = [
        'pallet_created_at',
        'created_at',
        'updated_at',
    ];

    public function shipment()
    {
        return $this->belongsTo(RdTakebackShipment::class, 'shipment_id');
    }

    /**
     * Get the store that owns the pallet.
     */
    public function store()
    {
        return $this->belongsTo(RdTakebackShipment::class, 'shipment_id');
    }

    //  /**
    //  * Accessor method to get the count of opened boxes.
    //  */
    // public function getOpenCountAttribute()
    // {
    //     return $this->storeBoxes()->where('status', 1)->count();
    // }

    // /**
    //  * Accessor method to get the count of unopened boxes.
    //  */
    // public function getUnopenedCountAttribute()
    // {
    //     return $this->storeBoxes()->where('status', 0)->count();
    // }

    // /**
    //  * Accessor method to get the total count of boxes.
    //  */
    // public function getTotalCountAttribute()
    // {
    //     return $this->storeBoxes()->count();
    // }

    // /**
    //  * Relationship to fetch related store boxes.
    //  */
    // public function storeBoxes()
    // {
    //     return $this->hasMany(StoreBox::class, 'store_pallet_id');
    // }
    /**
     * Accessor method to get the count of opened boxes.
     */
     public function boxes()
    {
        // Assuming 'pallet_id' is the foreign key in the 'rd_boxes' table that references the pallet
        return $this->hasMany(RdBox::class, 'pallet_id');
    }
    public function getOpenCountAttribute()
    {
        return $this->boxes()->where('status', 1)->count();
    }

    /**
     * Accessor method to get the count of unopened boxes.
     */
    public function getUnopenedCountAttribute()
    {
        return $this->boxes()->where('status', 0)->count();
    }

    /**
     * Accessor method to get the total count of boxes.
     */
    public function getTotalCountAttribute()
    {
        return $this->boxes()->count();
    }

    /**
     * Relationship to fetch related boxes.
     */
   

    public function palletPackagingMaterial()
    {
        return $this->hasMany(RdPalletPackagingMaterial::class, 'pallet_id');
    }

}
