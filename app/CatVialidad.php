<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatVialidad extends Model
{
    //
    protected $table = 'cat_tipo_vialidad';

    public function members(){
        return $this->belongsToMany(Member::class);
    }
}
