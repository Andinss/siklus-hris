<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollComponent extends Model
{
	use SoftDeletes;
	protected $table = 'payroll_component';
	protected $dates = ['deleted_at'];

    public function payrollComponentDetail()
    {
        return $this->hasMany(PayrollComponentDetail::class, 'payroll_component_id', 'id');
    }
}
