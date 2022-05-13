<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Member extends Model implements Auditable{
    
    use \OwenIt\Auditing\Auditable;

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function getFullNameAttribute(){
        return Str::upper($this->name." ".$this->father_surname." ".$this->mother_surname);
    }

    public function info(){
        return $this->hasOne(MemberAdicionalInformation::class);
    }

    public function dependents(){
        return $this->hasMany(MemberDependent::class);
    }

    public function documents(){
        return $this->hasOne(MemberDocument::class);
    }

    public function materialWalls(){
        return $this->belongsToMany(MateriaWall::class);
    }

    public function materialRoofs(){
        return $this->belongsToMany(MaterialRoof::class);
    }

    public function materialFloors(){
        return $this->belongsToMany(MaterialFloor::class);
    }

    public function municipio(){
        return $this->hasOne(CatMunicipio::class,'id','cat_municipio_id');
    }

    public function municipioDb(){
        return $this->hasOne(CatMunicipio::class,'id','cat_municipio_id');
    }
    public function municipioIndigena(){
        return $this->hasOne(CatMunicipio::class,'id','cat_municipio_id_indigena');
    }

    public function localidad(){
        return $this->hasOne(CatLocalidad::class,'id','cat_localidad_id');
    }
    
    public function marital(){
        return $this->hasOne(CatMaritalStatus::class,'id','marital_status');
    }
    public function rfcStatus(){
        return $this->hasOne(CatRfcStatus::class,'id','status_rfc');
    }   
    public function estudios(){
        return $this->hasOne(CatEstudios::class,'id','cat_estudios_id');
    }  
    public function locCol(){
        return $this->hasOne(CatLocCol::class,'id','cat_loc_col_id');
    } 
    public function tipoVialidad(){
        return $this->hasOne(CatVialidad::class,'id','cat_tipo_vialidad_id');
    } 
    public function tipoAsentamiento(){
        return $this->hasOne(CatAsentamiento::class,'id','cat_tipo_asentamiento_id');
    } 
   
}
