<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Privilege extends Model
{
    use SoftDeletes;

    protected $table = 'privilege';
    protected $dates = ['deleted_at'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function module()
    {
    	return $this->belongsTo('App\Models\Module', 'module_id', 'id');
    }

    public function action()
    {
    	return $this->belongsTo('App\Models\Action', 'action_id', 'id');
    }
}
