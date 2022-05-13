<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatAsentamiento extends Model
{
    //
        //
        protected $table = 'cat_tipo_asentamiento';

        public function members(){
            return $this->belongsToMany(Member::class);
        }
}
