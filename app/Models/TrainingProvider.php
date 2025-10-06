<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingProvider extends Model
{
	use SoftDeletes;
	protected $table = 'training_provider';
	protected $dates = ['deleted_at'];  

}
