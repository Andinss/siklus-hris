<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingInstructor extends Model
{
	use SoftDeletes;
	protected $table = 'training_instructor';
	protected $dates = ['deleted_at'];  

}
