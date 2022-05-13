<?php

namespace App\Exports;

use App\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportConvenios implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collection = collect();
        $collection->push(array('Consecutivo','Folio','Texto','Integrantes'));
        $text = 'CONVENIO PARA LA EJECUCIÓN DEL PROGRAMA DE APOYO A PROYECTOS PRODUCTIVOS PARA JEFAS DE FAMILIA EN EL ESTADO DE MORELOS "PROGRAMA DE IMPULSO PRODUCTIVO COMUNITARIO 2022", QUE CELEBRAN EL GOBIERNO DEL ESTADO LIBRE Y SOBERANO DE MORELOS A TRAVÉS DE LA SECRETARÍA DE DESARROLLO SOCIAL Y LAS BENEFICIARIAS: ';
        $projects = Project::whereIn('status',[1,3])->with('members')->orderBy('project_type_id')->orderBy('folio')->get();
        $cont = 1;
        foreach ($projects as $p) {
            $info = array(
                $cont,
                $this->getFolio($p->project_type_id,$p->getZeroFolioAttribute()),
                $text,
                $this->formatNames($p->members)
            );
            $collection->push($info);
            $cont++;
        }

        return $collection;
    }

    public function getFolio($type,$folio){
        return ($type === 1) ? 'PIPC'.'-2022-N-'.$folio : 'PIPC'.'-2022-F-'.$folio;
    }

    public function formatNames($members){
        $array_names = [];
        foreach ($members as $m) {
            array_push($array_names,Str::upper($m->fullName));
        }
        return implode(PHP_EOL,$array_names);
    }
}
