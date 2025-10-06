<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  EmployeeResign extends Model
{
	use SoftDeletes;
	protected $table = 'employee_resign';
	protected $dates = ['deleted_at'];  

}
