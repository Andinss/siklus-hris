<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsenceType extends Model
{
	use SoftDeletes;
	protected $table = 'absence_type';
	protected $dates = ['deleted_at'];

}
