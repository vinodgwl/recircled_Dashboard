<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdShippingCareerType extends Model
{
    use HasFactory;
    protected $table = 'rd_shipping_career_types';
    protected $primaryKey = 'shipping_career_id';
    
    protected $fillable = [
        'brand_id',
        'shipping_name',
        'added_by',
        'updated_by',
    ];
}
