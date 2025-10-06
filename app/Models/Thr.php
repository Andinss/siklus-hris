<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thr extends Model
{
	use SoftDeletes;
	protected $table = 'thr';
	protected $dates = ['deleted_at'];  

}
