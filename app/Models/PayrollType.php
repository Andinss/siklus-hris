<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollType extends Model
{
	use SoftDeletes;
	protected $table = 'payroll_type';
	protected $dates = ['deleted_at'];  

}
