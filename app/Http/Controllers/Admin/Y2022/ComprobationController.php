<?php

namespace App\Http\Controllers\Admin\Y2022;

use App\Project;
use Carbon\Carbon;
use App\CatMunicipio;
use App\Comprobation;
use App\SupportDocument;
use Illuminate\Http\Request;
use App\Traits\ProjectPriority;
use Illuminate\Support\Facades\DB;
use App\Exports\ComprobationReport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ComprobationController extends Controller
{

    use ProjectPriority;

    public $approved_percentage = 95;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $municipios = CatMunicipio::orderBy("municipio")->get();
        $projects_ids = null;
        $filter = false;
        $request_municipios = [];
        if($request->has('municipios')){
            $request_municipios = $this->validateMunicipiosRequest($request->get('municipios'));
            if(count($request_municipios) > 0){
                $filter = true;
                $projects_ids = $this->filterFirstMemberByMunicipio($request_municipios);
            }
        }

        $projects = Project::with(['type','giro','comprobation','members' => function($query){
            $query->with('municipioDb');
            $query->orderBy('id','ASC');
        }])
        ->whereIn('status',[1,3])->orderBy('project_type_id')->orderby('folio')
        ->when($filter,function($query) use($projects_ids){
            $query->whereIn('id',$projects_ids);
        })
        ->get();

        foreach ($projects as $project) {
            $project->priority = $this->getPriority($project->amount_approved,$project->comprobation);
            $project->municipio = $this->getFirstMemberMunicipio($project->members,$request_municipios);
        }

        foreach($projects as $p){
            if($p->municipio == null){
                dd($p);
            }
        }
    
        return view('admin.2022.comprobation.index',compact('projects','municipios','request_municipios'));
    }

    public function filterFirstMemberByMunicipio($ids_municipios){
        $projects_ids = [];
        $members = DB::table('members')
            ->select('members.id','members.project_id','projects.folio')
            ->join('projects','members.project_id','=','projects.id')
            ->where('web_registration',1)
            ->whereIn('cat_municipio_id',$ids_municipios)
            ->whereIn('projects.status',[1,3])
            ->orderBy('projects.id')
            ->orderBy('members.id')
            ->get();

        foreach ($members as $m) {
            if(!in_array($m->project_id,$projects_ids)){
                array_push($projects_ids,$m->project_id);
            }
        }

        return $projects_ids;

        /*$bindingsString = trim( str_repeat('?,', count($request_municipios)), ','); // '?,?,?'
        $projects_ids = DB::select("SELECT members.project_id,MIN(members.id) AS 'member_id' FROM members
        INNER JOIN projects ON members.project_id = projects.id
        WHERE web_registration = 1 AND cat_municipio_id IN (".$bindingsString.") AND projects.`status` IN (1,3)
        GROUP BY projects.id",$request_municipios);

        $projects_ids = collect($projects_ids)->pluck('project_id');*/
    }

    public function getFirstMemberMunicipio($members,$municipios){
        if(count($municipios) > 0){
            if(in_array($members[0]->municipioDb->id,$municipios)){
                return $members[0]->municipioDb;    
            }else{
                return null;
            }
        }else{
            return $members[0]->municipioDb;
        }
    }

    public function validateMunicipiosRequest($municipios){
        $municipios = explode(",",$municipios);
        if(count($municipios)){
            $new_municipios = array_filter($municipios,function($item){
                $id = (int) $item;
                if($id > 0 && $id < 34){
                    return $id;
                }
            });

            return $new_municipios;

        }else{
            return false;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $project = Project::where('slug',$slug)->with(['type','giro','comprobation' => function($query){
            $query->with('user');
            $query->with('document');
        }])->get()->first();

        $suppport_document = SupportDocument::all('id','name');
        return view('admin.2022.comprobation.comprobation',compact('project','suppport_document'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($slug, Request $request)
    {
        /**Validamos que la información enviada sea correcta */
        $request->validate([
            '*.support_document_id' => 'required|numeric',
            '*.folio_number' => 'required',
            '*.amount' => 'required|numeric|min:1',
            '*.support_document_txt' => 'required_if:*.support_document_id,5'
        ],[
            '*.support_document_id.required' => 'El tipo de documento aprobatorio es obligatorio',
            '*.support_document_id.numeric' => 'Por favor selecciona un tipo de docuento valido',
            '*.folio_number.required' => 'El número de folio es campo obligatorio',
            '*.amount.required' => "El monto es un campo obligatorio",
            '*.amount.numeric' => 'El monto solo debe contener números',
            '*.amount.min' => 'El monto debe ser mayor a un $ 1.00',
            '*.support_document_txt.required_if' => 'Es necesario especificar el documento aprobatorio antes de continuar'
        ]);
        /**Obtenemos la info del proyecto */
        $project = Project::where('slug',$slug)->get()->first();

        /**Comenzamos a guardar en la base de datos */
        $insert_data = [];
        foreach ($request->post() as $invoice) {

            $support_document_txt = ($invoice['support_document_id'] === 5) ? $invoice['support_document_txt'] : null;

            $insert_data[] = array(
                'project_id' => $project->id,
                'user_id' => auth()->user()->id,
                'support_document_id' => $invoice['support_document_id'],
                'support_document_txt' => $support_document_txt,
                'folio_number' => $invoice['folio_number'],
                'amount' => $invoice['amount'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            );
        }

        try {

            DB::beginTransaction();
            foreach ($insert_data as $data) {
                $new_comprobation = Comprobation::create($data);
            }
            //$inserts = Comprobation::insert($insert_data);
            DB::commit();
            return response()->json(true,200);
        } catch (\Throwable $th) {
            \Log::info($th);
            DB::rollBack();
            return response()->json("Ha existido un error al guardar la comprobación",500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Comprobation::destroy($request->id);
        return response()->json(true,200);
    }

    public function export(Request $request){
        $ids_nuevos = explode(',',$request->nuevo);
        $ids_fortalecimiento = explode(',',$request->fortalecimiento);
        return (new ComprobationReport($ids_nuevos,$ids_fortalecimiento))->download('Comprobation-report-'.date('Y-m-d-h-i-s').'.xlsx');
    }
}
