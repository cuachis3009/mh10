<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Comprobation extends Model implements Auditable{

    use \OwenIt\Auditing\Auditable;

    protected $table = 'comprobation';

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function document(){
        return $this->belongsTo(SupportDocument::class,'support_document_id','id');
    }
}
