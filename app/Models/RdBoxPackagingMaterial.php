<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdBoxPackagingMaterial extends Model
{
    use HasFactory;
    protected $table = 'rd_box_packaging_material';

     protected $fillable = [
        'shipment_id',
        'pallet_id',
        'box_id',
        'material_type',
        'material_weight',
    ];

    public function box()
    {
        return $this->belongsTo(RdBox::class, 'box_id');
    }
}
