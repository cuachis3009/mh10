<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatMunicipio extends Model{

    protected $table = 'cat_municipio';

    public function members(){
        return $this->belongsToMany(Member::class);
    }

}
