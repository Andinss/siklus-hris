<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    //
    protected $dates = ['deleted_at'];
    
    public function user_role()
    {
    	return $this->hasMany('App\Models\UserRole', 'role_id', 'id');
    }
}
