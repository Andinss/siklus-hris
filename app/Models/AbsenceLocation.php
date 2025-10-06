<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsenceLocation extends Model
{
	use SoftDeletes;
	protected $table = 'absence_location';
	protected $dates = ['deleted_at'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'absence_location_employee', 'absence_location_id', 'employee_id');
    }

    public function locationEmployees()
    {
        return $this->hasMany(AbsenceLocationEmployee::class);
    }

}
