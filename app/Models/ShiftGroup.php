<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftGroup extends Model
{
	use SoftDeletes;
	protected $table = 'shift_group';
	protected $dates = ['deleted_at'];

    public function shiftGroupDetail()
    {
        return $this->hasMany(ShiftGroupDetail::class, 'shift_group_id', 'id')->whereNull('deleted_at');
    }
}
