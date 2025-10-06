<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    //
	protected $table = 'users_roles';
    protected $dates = ['deleted_at'];

    public $timestamps = false; // Nonaktifkan timestamps otomatis

    public function user()
    {
    	return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function role()
    {
    	return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }
}
