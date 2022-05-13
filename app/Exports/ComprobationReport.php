<?php

namespace App\Exports;

use App\Exports\Sheets\ComprobationSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ComprobationReport implements WithMultipleSheets{

    use Exportable;
    public $nuevos = [];
    public $fortalecimiento = [];

    public function __construct($nuevos,$fortalecimiento){
        $this->nuevos = $nuevos;
        $this->fortalecimiento = $fortalecimiento;
    }

    public function sheets(): array{

        $sheets = [];

        $sheets[] = new ComprobationSheet($this->nuevos,'Proyectos Nuevos');
        //$sheets[] = new ComprobationSheet($this->fortalecimiento,'Proyectos de fortalecimiento');
        //$sheets[] = new ProjectTypeSheet(1,2,'Proyectos de fortalecimiento');

        return $sheets;
    }
}
