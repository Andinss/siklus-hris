<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RenewContract extends Model
{
	use SoftDeletes;
	protected $table = 'renewcontract';
	protected $dates = ['deleted_at'];  

}
