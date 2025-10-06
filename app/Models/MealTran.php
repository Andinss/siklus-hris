<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealTran extends Model
{
	use SoftDeletes;
	protected $table = 'mealtran';
	protected $dates = ['deleted_at'];  

}
