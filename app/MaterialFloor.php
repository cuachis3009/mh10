<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialFloor extends Model{

    public function members(){
        return $this->belongsToMany(Member::class);
    }
    
}
