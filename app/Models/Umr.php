<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Umr extends Model
{
	use SoftDeletes;
	protected $table = 'umr';
	protected $dates = ['deleted_at'];  

}
