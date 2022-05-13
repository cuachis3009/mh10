<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model{
    
    public function types(){
        return $this->belongsToMany(ProjectType::class);
    }

}
