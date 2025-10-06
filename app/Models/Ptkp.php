<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ptkp extends Model
{
	use SoftDeletes;
	protected $table = 'ptkp';
	protected $dates = ['deleted_at'];  

}
