<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    protected $table = 'module';
    protected $dates = ['deleted_at'];

    public function privilege()
    {
    	return $this->hasMany('App\Models\Privilege', 'module_id', 'id');
    }
}
