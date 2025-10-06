<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    use SoftDeletes;

    protected $table = 'action';
    protected $dates = ['deleted_at'];

    public function privilege()
    {
    	return $this->hasMany('App\Models\Privilege', 'action_id', 'id');
    }
}
