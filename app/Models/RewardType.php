<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardType extends Model
{
	use SoftDeletes;
	protected $table = 'reward_type';
	protected $dates = ['deleted_at'];  

}
