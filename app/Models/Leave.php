<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
	use SoftDeletes;
	protected $table = 'leave';
	protected $dates = ['deleted_at'];  

}
