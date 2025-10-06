<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationType extends Model
{
	use SoftDeletes;
	protected $table = 'education_type';
	protected $dates = ['deleted_at'];  

}
