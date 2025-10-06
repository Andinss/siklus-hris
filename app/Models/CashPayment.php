<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashPayment extends Model
{
	use SoftDeletes;
	protected $table = 'cash_payment';
	protected $dates = ['deleted_at'];  

}
