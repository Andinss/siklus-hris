<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruitment extends Model
{
	use SoftDeletes;
	protected $table = 'recruitment';
	protected $dates = ['deleted_at'];  

}
