<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourceMedia extends Model
{
	use SoftDeletes;
	protected $table = 'sourcemedia';
	protected $dates = ['deleted_at'];  

}
