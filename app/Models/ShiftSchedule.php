<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftSchedule extends Model
{
	use SoftDeletes;
	protected $table = 'shift_schedule';
	protected $dates = ['deleted_at'];  

}
