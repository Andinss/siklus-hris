<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollSlip extends Model
{
	use SoftDeletes;
	protected $table = 'payroll_slip';
	protected $dates = ['deleted_at'];  
}