<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatModalidadLocal extends Model
{
    //
    protected $table = 'cat_modalidad_local';

    public function members(){
        return $this->belongsToMany(Member::class);
    }
}
