<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sex extends Model
{
	use SoftDeletes;
	protected $table = 'sex';
	protected $dates = ['deleted_at'];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'sex', 'id');
    }
}
