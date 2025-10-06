<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftGroupDetail extends Model
{
	use SoftDeletes;
	protected $table = 'shift_group_detail';
	protected $dates = ['deleted_at'];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }
}
