<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveCategory extends Model
{
	use SoftDeletes;
	protected $table = 'leaveCategory';
	protected $dates = ['deleted_at'];  

}
