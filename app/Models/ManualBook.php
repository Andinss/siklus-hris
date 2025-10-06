<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManualBook extends Model
{
	use SoftDeletes;
	protected $table = 'manual_book';
	protected $dates = ['deleted_at'];  

}
