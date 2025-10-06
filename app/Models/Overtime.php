<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Overtime extends Model
{
	use SoftDeletes;
	protected $table = 'overtime';
	protected $dates = ['deleted_at'];  

}
