<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  Popup extends Model
{
	use SoftDeletes;
	protected $table = 'popup';
	protected $dates = ['deleted_at'];  

}
