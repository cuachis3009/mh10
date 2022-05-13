<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatHouse extends Model
{
    //
    protected $table = 'house_adquisition';

    public function members(){
        return $this->belongsToMany(Member::class);
    }
}
