<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollComponentDetail extends Model
{
	use SoftDeletes;
	protected $table = 'payroll_component_detail';
	protected $dates = ['deleted_at'];

    public function payrollComponent()
    {
        return $this->belongsTo(PayrollComponent::class, 'payroll_component_id', 'id');
    }
}
