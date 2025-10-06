<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashTransfer extends Model
{
	use SoftDeletes;
	protected $table = 'cashtransfer';
	protected $dates = ['deleted_at'];  

}
