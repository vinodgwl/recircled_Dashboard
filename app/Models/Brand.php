<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_image',
        'name',
        'contact_person',
        'email',
        'phone_number',
        'address',
        'city',
        'state',
        'takeback_type',
        'preferred_shipping',
        'have_sub_brands',
        'parent_categories',
    ];

    protected $casts = [                        
        'have_sub_brands' => 'boolean',
        'parent_categories' => 'array',
    ];
}
