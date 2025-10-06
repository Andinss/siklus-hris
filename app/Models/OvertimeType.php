<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OvertimeType extends Model
{
	use SoftDeletes;
	protected $table = 'overtime_type';
	protected $dates = ['deleted_at'];  

}
