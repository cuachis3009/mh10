<?php 

namespace App\Exports\Sheets;

use App\Project;
use Illuminate\Support\Str;
use App\Traits\ProjectPriority;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ComprobationSheet implements FromCollection,WithTitle,WithStyles{

    use ProjectPriority;

    private $ids;
    private $title;
    private $column = 'A';
    private $last_column_project = null;
    private $max_member_number = null;
    private $merge_colums_values = array();
    private $last_num_row = null;

    public function __construct($ids,$title){
        $this->ids = $ids;
        $this->title = $title;
    }

    public function collection(){

        $projects = Project::with(['comprobation.document','members' => function($query){
            $query->with(['municipioDb','localidad']);
        }])->whereIn('id',$this->ids)->orderBy('folio')->get();

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

        $cell = $last_column.$this->last_num_row;

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
            /*'A1:'.$border_thin => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '000000'
                        ]
                    ]
                ]
            ]*/
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
            array_push($info,number_format($project->amount_approved,2,'.',','));
            $amount_checked = $project->comprobation->sum('amount');
            array_push($info,number_format($amount_checked,2,'.',','));
            /**Monto faltante */
            if($amount_checked >= $project->amount_approved){
                $amount_unchecked = 0;
            }else{
                $amount_unchecked = $project->amount_approved - $amount_checked;
            }
            array_push($info,number_format($amount_unchecked,2,'.',','));
            array_push($info,$this->getPriority($project->amount_approved,$project->comprobation));
            $info = $this->formatMemberInfo($info,$project->members);
            $projects_info->push($info);
        }

        $projects_info->prepend(
            $this->formatTitleProject()
        );
        $projects_info->prepend(array("Folio"));

        $this->last_num_row = $projects_info->count();

        return $projects_info;
    }

    public function formatMemberInfo($info,$members){
        foreach ($members as $m) {
            $info[] = Str::upper($m->name);
            $info[] = Str::upper($m->father_surname);
            $info[] = Str::upper($m->mother_surname);
            $info[] = Str::upper(str_replace(",","",$m->municipio));
            $info[] = trim(str_replace(['-'],'',Str::upper($m->colonia)));
            $info[] = trim(str_replace(['-'],'',Str::upper($m->street.' '.$m->exterior_number." ".$m->interior_number)));
            $info[] = $m->cellphone_number;
            $info[] = $m->house_phonenumber;
            $info[] = $m->adicional_phonenumber;
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
            'Apellido Paterno',
            'Apellido Materno',
            'Municipio',
            'Colonia',
            'Calle / Numero exterior - interior',
            'Teléfono celular',
            'Teléfono de casa',
            'Teléfono adicional'
        ];
    }

    public function formatTitleProject(){

        $title_project = [
            'Folio',
            'Monto aprobado',
            'Monto comprobado',
            'Monto no comprobado',
            'Prioridad',
        ];

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