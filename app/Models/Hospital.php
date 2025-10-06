<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
	use SoftDeletes;
	protected $table = 'hospital';
	protected $dates = ['deleted_at'];  

}
