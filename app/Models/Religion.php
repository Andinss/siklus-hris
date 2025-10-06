<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Religion extends Model
{
	use SoftDeletes;
	protected $table = 'religion';
	protected $dates = ['deleted_at'];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'religion_id', 'id');
    }
}
