<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class RdMasterUser extends Model implements Authenticatable
{
    use AuthenticableTrait;

    use HasFactory;
    protected $table = 'rd_master_users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_name',
        'user_email',
        'user_password',
        'user_role_id',
        'details_send_email_status',
        'active_status',
        'added_by',
        'updated_by',
        // 'recent_login_time', // Exclude from fillable if it should be handled automatically
    ];

    protected $hidden = [
        'password',
        'details_send_email_status',
    ];

    public function username()
    {
        return 'user_email';
    }
    
}
