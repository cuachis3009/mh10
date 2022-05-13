<?php

namespace App\Exports;

use App\Project;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;

class BeneficiariesPadron implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        $padron = collect();
        $padron->push(array('Folio','Nuevo / Fortalecimiento','Número de folio','CURP','Apellido Paterno','Apellido Materno','Nombre (s)','Fecha de nacimiento','Clave del estado de nacimiento','Estado de nacimiento','Sexo','Fecha de registro','Discapacidad','Ocupación','Correo electrónico','Teléfono celular','Teléfono casa','Calle','Número exterior','Número interior','Localidad (colonia)','Clave de municipio','Municipio','Código postal','Giro del proyecto','Monto del proyecto'));

        $projects = Project::whereIn('status',[1,3])->with(['giro','members' => function($query){
            $query->orderBy('id')->with(['municipioDb','info']);
        }])->orderBy('project_type_id')->orderBy('folio')->get();

        foreach ($projects as $project) {
            $folio = $this->getFolio($project->project_type_id,$project->zerofolio);
            $project_type = $this->projectType($project->project_type_id);
            $monto = $this->cantidad($project->project_type_id,$project->giro_id);
            $giro = $project->giro->name;
            $band = 1;
            foreach ($project->members as $member) {
                $discapacidad = $this->checkDiscapacidad($member->info);
                $curp_info = json_decode($member->json_curp);
                $employment = $this->ocupacion($member->info);
                $padron->push(array(
                    $folio,
                    $project_type,
                    $project->folio,
                    Str::upper($member->curp),
                    Str::upper($member->father_surname),
                    Str::upper($member->mother_surname),
                    Str::upper($member->name),
                    $curp_info->fechaNacimiento,//Fecha de nacimiento
                    $curp_info->claveEntidadNacimiento,//Clave del estado nacimiento
                    $this->curpMunicios($curp_info->claveEntidadNacimiento),//Estado de nacimiento
                    $curp_info->sexo,//sexo
                    $member->created_at,//Fecha de registro
                    Str::upper($discapacidad),
                    $employment,
                    $member->email,
                    $member->cellphone_number,
                    $member->house_phonenumber,
                    Str::upper($member->street),
                    Str::upper($member->exterior_number),
                    Str::upper($member->interior_number),
                    Str::upper($member->colonia),
                    Str::upper($member->municipioDb->clave_numero),
                    Str::upper($member->municipioDb->municipio),
                    $member->postal_code,
                    $giro,
                    ($band === 1) ? $monto['cantidad'] : ''
                ));

                $band++;
            }
        }

        return $padron;

    }

    public function cantidad($type,$giro_id){
        if($type == 1){
            switch ($giro_id) {
                case 1:
                case 2:
                    $monto = array(
                            'cantidad' => '$40,000.00',
                            'letra' => '(Cuarenta mil  pesos  00/100  M.N.)'
                    );
                    break;
                case 3:
                case 4:
                    $monto = array(
                            'cantidad' => '$30,000.00',
                            'letra' => '(Treinta mil pesos   00/100M.N.)'
                    );
                    break;
                
                default:
                    $monto = array(
                        'cantidad' => '$0.00',
                        'letra' => '(Cero pesos 00/100 M.N.)'
                    );
                    break;
            }
        }else{
            $monto = array(
                'cantidad' => '$30,000.00',
                'letra' => '(Treinta  mil  pesos  00/100 M.N.)'
            );
        }
        return $monto;
    }

    public function ocupacion($info){
        return ($info->employment !== '') ? Str::upper($info->employment) : '';
    }

    public function checkDiscapacidad($info){
        return ($info->has_disability) ? $info->specify_disability : '';
    }

    public function projectType($type){
        return ($type === 1) ? 'Nuevo' : 'Fortalecimiento';
    }

    public function getFolio($type,$folio){
        return ($type === 1) ? 'PIPC'.'-2022-N-'.$folio : 'PIPC'.'-2022-F-'.$folio;
    }

    public function curpMunicios($clave){
        $municipios = array(
            'AS' => 'AGUASCALIENTES',
            'BC' => 'BAJA CALIFORNIA',
            'BS' => 'BAJA CALIFORNIA SUR',
            'CC' => 'CAMPECHE',
            'CL' => 'COAHUILA',
            'CM' => 'COLIMA',
            'CS' => 'CHIAPAS',
            'CH' => 'CHIHUAHUA',
            'DF' => 'DISTRITO FEDERAL',
            'DG' => 'DURANGO',
            'GT' => 'GUANAJUATO',
            'GR' => 'GUERRERO',
            'HG' => 'HIDALGO',
            'JC' => 'JALISCO',
            'MC' => 'MÉXICO',
            'MN' => 'MICHOACÁN',
            'MS' => 'MORELOS',
            'NT' => 'NAYARIT',
            'NL' => 'NUEVO LEÓN',
            'OC' => 'OAXACA',
            'PL' => 'PUEBLA',
            'QT' => 'QUERÉTARO',
            'QR' => 'QUINTANA ROO',
            'SP' => 'SAN LUIS POTOSÍ',
            'SL' => 'SINALOA',
            'SR' => 'SONORA',
            'TC' => 'TABASCO',
            'TS' => 'TAMAULIPAS',
            'TL' => 'TLAXCALA',
            'VZ' => 'VERACRUZ',
            'YN' => 'YUCATÁN',
            'ZS' => 'ZACATECAS',
            'NE' => 'NACIDO EN EL EXTRANJERO',
        );

        if(array_key_exists($clave,$municipios)){
            return $municipios[$clave];
        }else{
            return '';
        }
    }

}
