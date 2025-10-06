<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  ReimburseDetail extends Model
{
	// use SoftDeletes;
	protected $table = 'reimburse_detail';
	protected $dates = ['deleted_at'];  

}
