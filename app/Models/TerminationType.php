<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TerminationType extends Model
{
	use SoftDeletes;
	protected $table = 'terminationtype';
	protected $dates = ['deleted_at'];  

}
