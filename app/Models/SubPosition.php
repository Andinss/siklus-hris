<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubPosition extends Model
{
	use SoftDeletes;
	protected $table = 'subposition';
	protected $dates = ['deleted_at'];  

}
