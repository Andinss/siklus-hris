<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  CashPaymentDetail extends Model
{
	use SoftDeletes;
	protected $table = 'cash_payment_detail';
	protected $dates = ['deleted_at'];  

}
