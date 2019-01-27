<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function accessories() {
        return $this->hasMany('App\Accessory');
    }
}
