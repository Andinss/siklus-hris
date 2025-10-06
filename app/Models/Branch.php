<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
	use SoftDeletes;
	protected $table = 'branch';
	protected $dates = ['deleted_at']; 

	public function cashbond()
	{
		return $this->hasMany('App\Models\Cashbond', 'branch_id', 'id');
	}

	public function invoice()
	{
		return $this->hasMany('App\Models\Invoice', 'branch_id', 'id');
	}

	public function item_central()
	{
		return $this->hasMany('App\Models\ItemCentral', 'branch_id', 'id');
	}

	public function revenue()
	{
		return $this->hasMany('App\Models\ItemCentral', 'branch_id', 'id');
	}

}
