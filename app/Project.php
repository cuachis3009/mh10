<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable{

    use \OwenIt\Auditing\Auditable;
    use DatesTranslator;
    
    public function period(){
        return $this->hasOne(Period::class,"id","period_id");
    }

    public function type(){
        return $this->hasOne(ProjectType::class,"id","project_type_id");
    }

    public function members(){
        return $this->hasMany(Member::class);
    }

    public function items(){
        return $this->hasMany(ProjectItem::class);
    }

    public function giro(){
        return $this->hasOne(Giro::class,'id','giro_id');
    }

    public function getZeroFolioAttribute(){
        //return str_pad($this->folio,4,"0",STR_PAD_LEFT);
        return $this->folio;
    }

    public function comprobation(){
        return $this->hasMany(Comprobation::class);
    }
    public function municipioDb(){
        return $this->hasOne(CatMunicipio::class,'id','cat_municipio_id');
    }
    public function tipoAsentamiento(){
        return $this->hasOne(CatAsentamiento::class,'id','cat_tipo_asentamiento_id');
    } 
    public function horarios(){
        return $this->hasMany(CatHorarios::class,'project_id','id');
    } 

    public function estandar(){
        return $this->hasOne(CatEstandar::class,'id','cat_estandar_id');
    }

    public function Project_conocimientos()
    {
        return $this->hasMany(Project_Conocimiento::class,'proyect_id','id');
    }
    /*
    public function estandar(){
        return $this->hasOne(CatEstandar::class,"id","project_type_id");
    }
    */
  
}
