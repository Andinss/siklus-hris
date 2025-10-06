<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thrdet extends Model
{
	use SoftDeletes;
	protected $table = 'thrdet';
	protected $dates = ['deleted_at'];  

}
