<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeRelationship extends Model
{
	use SoftDeletes;
	protected $table = 'employee_relationship';
	protected $dates = ['deleted_at'];  

}
