<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdBoxPackagingMaterial extends Model
{
    use HasFactory;
    protected $primaryKey = 'box_packaging_id';
    protected $table = 'rd_box_packaging_material';

     protected $fillable = [
        'brand_id',
        'shipment_id',
        'pallet_id',
        'box_id',
        'material_type',
        'material_weight',
        'added_by',
        'updated_by',
        'approved_status',
        'approved_by'
    ];

    public function box()
    {
        return $this->belongsTo(RdBox::class, 'box_id');
    }
}
