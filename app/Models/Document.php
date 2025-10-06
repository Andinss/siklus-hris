<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
	use SoftDeletes;
	protected $table = 'document';
	protected $dates = ['deleted_at'];  

}
