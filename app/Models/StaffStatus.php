<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffStatus extends Model
{
	use SoftDeletes;
	protected $table = 'staff_status';
	protected $dates = ['deleted_at'];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'staff_status_id', 'id');
    }
}
