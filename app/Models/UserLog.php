<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'user_log';
    protected $guarded = [];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
