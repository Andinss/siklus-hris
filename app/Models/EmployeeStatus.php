<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeStatus extends Model
{
	use SoftDeletes;
	protected $table = 'employee_status';
	protected $dates = ['deleted_at'];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'employee_status_id', 'id');
    }
}
