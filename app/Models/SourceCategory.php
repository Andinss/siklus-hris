<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourceCategory extends Model
{
	use SoftDeletes;
	protected $table = 'sourcecategory';
	protected $dates = ['deleted_at'];  

}
