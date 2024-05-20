<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdTakebackType extends Model
{
    use HasFactory;
    protected $table = 'rd_takeback_type';
    protected $primaryKey = 'takeback_id';

    protected $fillable = [
        'brand_id',
        'takeback_name',
        'added_by',
        'updated_by',
        // 'created_at', // You can omit these fields as they are automatically managed by Laravel
        // 'updated_at',
    ];
}
