<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingType extends Model
{
	use SoftDeletes;
	protected $table = 'training_type';
	protected $dates = ['deleted_at'];  

}
