<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accessory extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function workplace()
    {
        return $this->belongsTo('App\Workplace');
    }
}
