<?php 

    namespace App\Exports\Sheets;

    use App\Project;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithTitle;
    use Maatwebsite\Excel\Concerns\WithStyles;
    use Illuminate\Support\Str;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
    use PhpOffice\PhpSpreadsheet\Style\Border;

    class ProjectTypeSheet implements FromCollection,WithTitle,WithStyles{

        private $period_id;
        private $project_type_id;
        private $title;
        private $column = 'A';
        private $last_column_project = null;
        private $max_member_number = null;
        private $merge_colums_values = array();
        private $last_num_row = null;

        public function __construct($period_id,$project_type_id,$title){
            $this->period_id = $period_id;
            $this->project_type_id = $project_type_id;
            $this->title = $title;
        }

        public function collection(){

            $projects = Project::with(['members' => function($query){
                $query->with(['dependents','info.water','materialWalls','materialRoofs','materialFloors']);
            },'items'])->where(['period_id' => $this->period_id,'project_type_id' => $this->project_type_id])->whereNotNull('folio')->orderBy('folio')->get();

            //dd($projects[500]->members[0]);

            $format_project = $this->formatProjectInfo($projects);

            return $format_project;
        }

        public function title() : string{
            return $this->title;
        }

        public function styles(Worksheet $sheet){

            $sheet->mergeCells('A1:'.$this->last_column_project.'1');
            $sheet->setCellValue("A1",Str::upper('Información del Proyecto'));

            $last_column = null;
            $count_range_column = (count($this->merge_colums_values) - 1);

            for ($i=0; $i < count($this->merge_colums_values) ; $i++) { 
                $sheet->mergeCells($this->merge_colums_values[$i]);
                $first_range = explode(":",$this->merge_colums_values[$i]);
                $sheet->setCellValue($first_range[0],Str::upper('Integrante '.($i + 1)));
                if($count_range_column == $i){
                    $last_column = $this->getLastColumn($this->merge_colums_values[$i]);
                }
            }

            $sheet->getRowDimension(1)->setRowHeight(28);
            $sheet->getRowDimension(2)->setRowHeight(28);

            if($this->last_num_row > 5000){
                $this->last_num_row = 4000;
            }

            return [
                1 => [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => "EAE8E8"]
                    ]
                ],
                2 => [
                    'font' => [
                        'bold' => true
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => "F3F3F3"]
                    ]
                ],
                'A1:'.$last_column.$this->last_num_row => [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'rgb' => '000000'
                            ]
                        ]
                    ]
                ]
            ];

        }

        public function getLastColumn($range){
            $last_column = explode(":",$range);
            return $last_column = preg_replace('/[0-9]+/', '', $last_column[1]);
        }

        public function formatProjectInfo($projects){

            $projects_info = collect();

            foreach ($projects as $project) {
                $info = array();
                array_push($info,$project->folio);
                array_push($info,$project->municipio);
                array_push($info,Str::upper($project->name_group));
                switch ($project->giro_id) {
                    case 1:
                        $giro = "Agropecuario";
                        break;
                    case 2:
                        $giro = "Transformación";
                        break;
                    case 3:
                        $giro = "Comercio";
                        break;
                    case 4:
                        $giro = "Servicio";
                        break;
                    
                    default:
                        $giro = "Not found";
                        break;
                }
                array_push($info,Str::upper($giro));
                array_push($info,$this->getTotalItemsProject($project->items));
                array_push($info,Str::upper($project->productive_activity));
                array_push($info,Str::upper($project->project_description));
                array_push($info,Str::upper($project->comunity_service_description));
                array_push($info,($project->full_documentation) ? "SI" : "NO");
                array_push($info,($project->member_duplicate_same_project) ? "SI" : "NO");
                array_push($info,($project->member_duplicate_other_projects) ? "SI" : "NO");
                if($project->project_type_id == 2){
                    array_push($info,Str::upper($project->deny));
                    array_push($info,($project->same_member_previous_project) ? "SI" : "NO");
                }else{
                    array_push($info,($project->member_benefited_other_year) ? "SI" : "NO");
                }
                
                switch($project->resource_id){
                    case 1:
                        $resource = "Equipo";
                        break;
                    case 2:
                        $resource = "Herramientas";
                        break;
                    case 3:
                        $resource = "Local";
                        break;
                    case 4:
                        $resource = "Materia prima";
                        break;
                    case 5:
                        $resource = "Ninguno";
                        break;
                    default :
                        $resource = "Not found";
                }
                        
                array_push($info,Str::upper($resource));
                array_push($info,($project->hire_more_people) ? "SI" : "NO");
                array_push($info,($project->project_exist) ? "SI" : "NO");
                $info = $this->formatMemberInfo($info,$project->members);
                $projects_info->push($info);
            }

            $projects_info->prepend($this->formatTitleProject($project->project_type_id));
            $projects_info->prepend(array("Folio"));

            $this->last_num_row = $projects_info->count();

            return $projects_info;
        }

        public function formatMemberInfo($info,$members){
            foreach ($members as $m) {
                $info[] = Str::upper($m->name);
                $info[] = Str::upper($m->father_surname);
                $info[] = Str::upper($m->mother_surname);
                $info[] = Str::upper($m->curp);
                $info[] = Str::upper($m->official_id_clave);
                $info[] = ($m->full_documentation) ? "SI": "NO";
                $info[] = ($m->member_duplicate_same_project) ? "SI" : "NO";
                $info[] = ($m->member_duplicate_other_projects) ? "SI" : "NO";
                $info[] = ($m->member_benefited_other_year) ? "SI" : "NO";
                $info[] = Str::upper($m->deny);
                $info[] = $m->dependents->count();
                $info[] = $m->officlal_id_year_expiration;
                $info[] = $m->cellphone_number;
                $info[] = $m->house_phonenumber;
                $info[] = $m->adicional_phonenumber;
                $info[] = $m->email;
                $info[] = Str::upper($m->street);
                $info[] = Str::upper($m->exterior_number);
                $info[] = Str::upper($m->interior_number);
                $info[] = Str::upper($m->colonia);
                $info[] = $m->postal_code;
                $info[] = Str::upper($m->municipio);
                $info[] = Str::upper($m->estado);
                if($m->info->has_disability){
                    $info[] = Str::upper($m->info->specify_disability);
                }else{
                    $info[] = "NINGUNA";
                }
                if($m->materialWalls->count() > 0){
                    $info[] = $m->materialWalls->implode("name",", ");
                }else{
                    $info[] = "SIN SELECCIÓN";
                }
                if($m->materialRoofs->count() > 0){
                    $info[] = $m->materialRoofs->implode("name",", ");
                }else{
                    $info[] = "SIN SELECCIÓN";
                }
                if($m->materialFloors->count() > 0){
                    $info[] = $m->materialFloors->implode("name",", ");
                }else{
                    $info[] = "SIN SELECCIÓN";
                }
                $info[] = $m->info->water->name;
                $info[] = ($m->info->has_kitchen == 1) ? "SI" : "NO";
                $info[] = $m->info->number_rooms_as_bedroom;
                $info[] = $m->info->number_of_bathrooms;

                switch ($m->info->drainage_id) {
                    case 1:
                        $drainage = "Red publica";
                        break;
                    case 2:
                        $drainage = "Fosa";
                        break;
                    case 3:
                        $drainage = "Tuberia";
                        break;
                    
                    default:
                        $drainage = "Unknow";
                        break;
                }
                $info[] = Str::upper($drainage);

                switch ($m->info->home_light_id) {
                    case 1:
                        $ligh = "Servicio publico";
                        break;
                    case 2:
                        $ligh = "Se cuelga de la red";
                        break;
                    case 3:
                        $ligh = "No tiene luz";
                        break;
                    
                    default:
                        $ligh = "Unknow";
                        break;
                }
                $info[] = Str::upper($ligh);

                switch ($m->info->house_adquisition_id) {
                    case 1:
                        $house = "Crédito Hipotecario";
                        break;
                    case 2:
                        $house = "Propia";
                        break;
                    case 3:
                        $house = "Rentada";
                        break;
                    case 4:
                        $house = "Prestada";
                        break;
                    
                    default:
                        $house = "Unknow";
                        break;
                }
                $info[] = Str::upper($house);
                $info[] = $m->info->people_live_in_house;
                $info[] = ($m->info->pregnant_person_in_house == 1) ? "SI" : "NO";
                $info[] = "$ ".number_format($m->info->monthly_income,2,".",",");

                switch ($m->info->health_care_service_id) {
                    case 1:
                        $health = "Imss";
                        break;
                    case 2:
                        $health = "Issste";
                        break;
                    case 3:
                        $health = "Particular";
                        break;
                    case 4:
                        $health = "Gratuito";
                        break;
                    
                    default:
                        $health = "Unknow";
                        break;
                }
                $info[] = Str::upper($health);
                $info[] = ($m->info->returned_migrant == 1) ? "SI" : "NO";
                $info[] = ($m->info->can_read_write == 1) ? "SI" : "NO";
                $info[] = Str::upper($m->info->employment);
                $info[] = ($m->info->group_indigena == 1) ? "SI" : "NO";
                $info[] = $m->info->years_experience_project." año(s)";

            }

            if($members->count() > $this->max_member_number ){
                $this->max_member_number = $members->count();
            }

            return $info;
        }

        public function getTotalItemsProject($items){
            $total = 0;
            foreach ($items as $item) {
                $total += ($item->price *  $item->quantity);
            }
            
            return $total;
        }

        public function formatTitleMember(){
            return [
                'Nombre',
                'Ape. Paterno',
                'Ape. Materno',
                'CURP',
                'Clave de elector',
                '¿Tiene documentación completa?',
                '¿La integrante esta registrada en el mismo proyecto?',
                '¿La integrante esta registrada en otro proyecto?',
                '¿La integrante fue beneficiada en años anteriores?',
                'Comentario del filtro aplicado',
                'Número de dependientes economicos',
                'Fecha de expiración INE/IFE',
                'Teléfono celular',
                'Teléfono de casa',
                'Teléfono adicional',
                'Correo electronico',
                'Calle',
                'Número exterior',
                'Número interior',
                'Colonia',
                'Codigo postal',
                'Municipio',
                'Estado',
                '¿Tiene alguna discapacidad?',
                '¿De que material es la mayor parte de la paredes o muros de su vivienda?',
                '¿De que material es la mayor parte del techo de la vivienda?',
                '¿De que material es la mayor parte del piso de su vivienda?',
                '¿En la vivienda tienen?',
                '¿La vivienda tiene cuarto para cocinar?',
                '¿Cuantos cuartos usa como dormitorio?',
                '¿Cuantos excusados/retretes/sanitarios y/o letrina tiene en su vivienda?',
                '¿La vivienda tiene drenaje?',
                '¿La vivienda cuenta con luz electrica?',
                '¿La vivienda es?',
                '¿Cuantas personas habitan en la vivienda?',
                '¿En la vivienda hay algun persona embarazada?',
                '¿Cual es el ingreso aproximado de la familia, juntado todos los ingresos?',
                '¿Cuentas con servicios de atención medica?',
                '¿Eres migrante retornada?',
                '¿Sabes leer y escribir?',
                'Ocupación',
                '¿Formas parte de una comunidad indigena?',
                '¿Cuanto tiempo tiene de experiencia en el proyecto que desea desarrollar?'
            ];
        }

        public function formatTitleProject($project_type_id){

            $title_project = [
                'Folio',
                'Municipio',
                'Nombre del grupo',
                'Giro',
                'Total componentes',
                'Actividad productiva',
                'Describa que ofrece con su producto o servicio',
                'Servicio comunitario',
                '¿Tiene documentación completa?',
                '¿Tiene alguna integrante repetida en el mismo proyecto?',
                '¿Tiene alguna integrante repetida en otro proyecto?',
                '¿Cuentan con algun recurso?',
                '¿Planean contratra mas personas?',
                '¿El proyecto ya existe?'
            ];

            if($project_type_id == 2){
                array_splice($title_project,11,0,array('Comentarios filtros aplicados','¿Las integrantes son las mismas del 2019?'));
            }else{
                array_splice($title_project,11,0,'¿Tiene integrantes beneficiadas en otro años?');
            }

            $last_letter_index = count($title_project) - 1;

            for($i = 0; $i < count($title_project); $i++){
                if($i == $last_letter_index){
                    $this->last_column_project = $this->column;
                }
                $this->column++;
            }

            for($m = 0; $m < $this->max_member_number; $m++){
                $iterate = $this->formatTitleMember();
                $column_merge = $this->column."1";
                $last_column_member_letter = count($iterate) - 1;
                for ($t=0; $t < count($iterate); $t++) { 
                    array_push($title_project,$iterate[$t]);
                    if($t == $last_column_member_letter){
                        $column_merge .= ":".$this->column."1";
                    }
                    $this->column++;
                }
                array_push($this->merge_colums_values,$column_merge);
            }

            return $title_project;
        }

    }
    

?>