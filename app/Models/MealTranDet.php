<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealTranDet extends Model
{
	use SoftDeletes;
	protected $table = 'mealtrandet';
	protected $dates = ['deleted_at'];  

}
