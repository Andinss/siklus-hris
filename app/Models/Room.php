<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    protected $table = 'user';
    protected $dates = ['deleted_at'];

    public function user_role()
    {
    	return $this->hasOne('App\Models\UserRole', 'user_id', 'id');
    }

    public function employee()
    {
    	return $this->hasMany('App\Models\Employee', 'employee_id', 'id');
    }

    public function payroll()
    {
        return $this->hasMany('App\Models\Payroll', 'updated_by', 'id');
    }
}
