<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reimburse extends Model
{
	// use SoftDeletes;
	protected $table = 'reimburse';
	protected $dates = ['deleted_at'];  

}
