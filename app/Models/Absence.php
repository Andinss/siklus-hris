<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absence extends Model
{
	use SoftDeletes;
	protected $table = 'absence';
	protected $dates = ['deleted_at']; 

}
