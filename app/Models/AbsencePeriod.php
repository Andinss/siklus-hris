<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsencePeriod extends Model
{
	use SoftDeletes;
	protected $table = 'absence_period';
	protected $dates = ['deleted_at'];

    protected $fillable = [
        'absence_group_name', 'begin_date', 'end_date', 'day_in', 'status'
    ];
}
