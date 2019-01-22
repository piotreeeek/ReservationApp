<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accessory extends Model
{
    use SoftDeletes;

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function workplace()
    {
        return $this->belongsTo('App\Workplace');
    }
}
