<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeriodShift extends Model
{
	use SoftDeletes;
	protected $table = 'period_shift';
	protected $dates = ['deleted_at'];  

}
