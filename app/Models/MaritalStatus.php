<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaritalStatus extends Model
{
	use SoftDeletes;
	protected $table = 'marital_status';
	protected $dates = ['deleted_at'];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'marital_status_id', 'id');
    }
}
