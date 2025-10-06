<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documenttype extends Model
{
	use SoftDeletes;
	protected $table = 'documenttype';
	protected $dates = ['deleted_at'];  

}
