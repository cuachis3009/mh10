<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatRfcStatus extends Model
{
    //
    protected $table = 'cat_rfc_status';

    public function members(){
        return $this->belongsToMany(Member::class);
    }
}
