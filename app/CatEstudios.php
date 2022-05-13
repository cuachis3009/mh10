<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatEstudios extends Model
{
    //
    protected $table = 'cat_estudios';

    public function members(){
        return $this->belongsToMany(Member::class);
    }
}
