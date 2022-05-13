<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberDependent extends Model{
    
    public function member(){
        return $this->belongTo(Member::class);
    }

    public function relationship(){
        return $this->hasOne(RelationShip::class,"id","relation_ship_id");
    }

}
