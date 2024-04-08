<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdPalletPackagingMaterial extends Model
{
    use HasFactory;
    protected $table = 'rd_pallet_packaging_material';

     protected $fillable = [
        'shipment_id',
        'pallet_id',
        'material_type',
        'material_weight',
    ];
    
    // Define relationships
    public function pallet()
    {
        return $this->belongsTo(RdPallet::class, 'pallet_id');
    }
}
