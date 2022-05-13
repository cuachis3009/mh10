<?php 

    namespace App\Exports;

    use Maatwebsite\Excel\Concerns\WithMultipleSheets;
    use Maatwebsite\Excel\Concerns\Exportable;
    use App\Exports\Sheets\ProjectTypeSheet;

    class ProjectsExport implements WithMultipleSheets{

        use Exportable;

        public function sheets(): array{
            $sheets = [];

            $sheets[] = new ProjectTypeSheet(1,1,'Proyectos Nuevos');
            $sheets[] = new ProjectTypeSheet(1,2,'Proyectos de fortalecimiento');

            return $sheets;
        }

    }

?>