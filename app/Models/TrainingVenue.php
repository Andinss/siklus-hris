<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingVenue extends Model
{
	use SoftDeletes;
	protected $table = 'training_venue';
	protected $dates = ['deleted_at'];  

}
