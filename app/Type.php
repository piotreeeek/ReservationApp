<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function accessories() {
        return $this->hasMany('App\Accessory');
    }
}
