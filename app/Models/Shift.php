<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
	use SoftDeletes;
	protected $table = 'shift';
	protected $dates = ['deleted_at'];


    public function absence_type()
    {
        return $this->hasOne(AbsenceType::class, 'absence_type_id', 'id');
    }
}
