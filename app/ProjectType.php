<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model{
    
    public function periods(){
        return $this->belongsToMany(Period::class);
    }

}
