<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OvertimeDetail extends Model
{
	use SoftDeletes;
	protected $table = 'overtimerequestdet';
	protected $dates = ['deleted_at'];  

}
