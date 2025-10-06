<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollPeriod extends Model
{
	use SoftDeletes;
	protected $table = 'payroll_period';
	protected $dates = ['deleted_at'];  

}
