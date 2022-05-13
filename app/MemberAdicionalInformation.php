<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberAdicionalInformation extends Model{
    
    public function water(){
        return $this->hasOne(WaterHouse::class,"id","water_type");
    }

    public function house(){
        return $this->hasOne(CatHouse::class,'id','house_adquisition_id');
    } 
    

}
