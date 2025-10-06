<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxStatus extends Model
{
	use SoftDeletes;
	protected $table = 'ptkp';
	protected $dates = ['deleted_at'];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'tax_status', 'id');
    }
}
