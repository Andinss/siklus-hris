<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsenceLocationEmployee extends Model
{
    use SoftDeletes;

    protected $table = 'absence_location_employee';
	protected $dates = ['deleted_at'];
    protected $fillable = [
        'absence_location_id', 'employee_id'
    ];
}
