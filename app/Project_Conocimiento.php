<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_Conocimiento extends Model
{
    //
    protected $table = 'project_conocimiento';

    public function conocimientos()
    {
        return $this->hasMany(CatConocimiento::class,'id','cat_conocimiento_id');
    }
}
