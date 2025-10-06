<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationLevel extends Model
{
	use SoftDeletes;
	protected $table = 'education_level';
	protected $dates = ['deleted_at'];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'education_level_id', 'id');
    }
}
