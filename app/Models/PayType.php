<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayType extends Model
{
	use SoftDeletes;
	protected $table = 'pay_type';
	protected $dates = ['deleted_at'];  

}
