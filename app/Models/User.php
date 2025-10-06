<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'user';
    protected $dates = ['deleted_at'];

    public function user_role()
    {
    	return $this->hasOne('App\Models\UserRole', 'user_id', 'id');
    }

    public function employee()
    {
    	return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }

    public function payroll()
    {
        return $this->hasMany('App\Models\Payroll', 'updated_by', 'id');
    }

    public function privilege()
    {
        return $this->hasMany('App\Models\Privilege', 'user_id', 'id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
