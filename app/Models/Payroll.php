<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
	use SoftDeletes;
	protected $table = 'payroll';
	protected $dates = ['deleted_at'];  

}
