<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatMaritalStatus extends Model
{
    //
    protected $table = 'cat_marital_status';

    public function members(){
        return $this->belongsToMany(Member::class);
    }
}
