<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'workplace_id', 'occupation_time'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function workplace()
    {
        return $this->belongsTo('App\Workplace');
    }
}
