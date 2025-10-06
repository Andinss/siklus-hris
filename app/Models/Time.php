<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
	protected $table = 'absence';

    protected $fillable = [
        'employee_id', 'date_in', 'nik', 'date_in', 'actual_in',
        'date_out', 'actual_out', 'location_latitude_in', 'location_latitude_out', 'location_longitude_in',
        'location_longitude_out', 'photo_path_in', 'photo_path_out'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
