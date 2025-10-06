<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsenceLog extends Model
{
	use SoftDeletes;
	protected $table = 'absence_log';
	protected $dates = ['deleted_at'];  

}
