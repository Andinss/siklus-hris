<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationMajor extends Model
{
	use SoftDeletes;
	protected $table = 'education_major';
	protected $dates = ['deleted_at'];  

}
