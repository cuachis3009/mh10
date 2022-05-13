<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriaWall extends Model{
    public function members(){
        return $this->belongsToMany(Member::class);
    }
}
