<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  CashReceiveDetail extends Model
{
	use SoftDeletes;
	protected $table = 'cash_receive_detail';
	protected $dates = ['deleted_at'];  

}
