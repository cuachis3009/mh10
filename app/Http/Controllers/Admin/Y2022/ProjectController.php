<?php

namespace App\Http\Controllers\Admin\Y2022;

use PDF;
use App\Member;
use App\Project;
use Illuminate\Http\Request;
use App\Exports\ProjectsExport;
use App\Exports\ReportConvenios;
use Illuminate\Support\Facades\DB;
use App\Exports\BeneficiariesPadron;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('admin.2022.project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug){
        $project = Project::where('slug',$slug)
        ->with(['members.documents','type','items','period','comprobation','giro' => function($query){
            $query->where('period_id',session('period_id'));
        }])
        ->get()->first();
        $wvcursos = DB::table('wvcursos')->where("proyecto_id", $project->id)->get();

        return view('admin.2022.project.show',compact('project',"wvcursos"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createPdf($type_project,$slug){
        $project = Project::where("slug",$slug)->with(["period","type","items"])->first();
        $members = Member::where("project_id",$project->id)->with(["info.water","dependents.relationship","materialWalls"])->get();
        $wvcursos = DB::table('wvcursos')->where("proyecto_id", $project->id)->get();
        if($project != null){

            //return view("project.2022.pdf",compact("project"));
            $pdf = PDF::loadView('project.2022.pdf', compact("project","members","wvcursos"));
            return $pdf->stream('PIPC-2022-'.strtoupper($project->type->name[0]).'-'.$project->zeroFolio.'.pdf');
        }else{
            return abort(404);
        }
    }

    public function search(Request $request){
        $project = Project::where([
            'period_id' => session('period_id'),
            'project_type_id' => $request->input('type-project'),
            'folio' => $request->input('folio-search')
        ])->get()->pluck('slug')->first();
       

        if($project === null){
            return redirect()->route('admin.2022.not-found');
        }else{
            return redirect()->route('admin.2022.show',['slug' => $project]);
        }
    }

    public function exportToExcel(){
        return Excel::download(new ProjectsExport, 'ProjectsExport-'.date('Y-m-d-h-i-s').'.xlsx');
    }

    public function convenio($slug){
        $project = Project::where('slug',$slug)
        ->with(['members.documents','type','items','period','giro' => function($query){
            $query->where('period_id',session('period_id'));
        }])
        ->get()->first();
        if($project != null){
            $test = 0;

            if($test){
                return view('admin.2022.project.convenio',compact('project'));
            }else{
                $pdf = PDF::loadView('admin.2022.project.convenio', compact("project"));
                return $pdf->stream('CONVENIO-MH10-2022-'.$project->zeroFolio.'.pdf');
            }
        }else{
            return redirect()->route('admin.2022.not-found');
        }
    }

    public function carta($slug){
        $project = Project::where('slug',$slug)
        ->with(['members.documents','type','items','period','giro' => function($query){
            $query->where('period_id',session('period_id'));
        }])
        ->get()->first();
        if($project != null){
            $test = 0;

            if($test){
                return view('admin.2022.project.carta',compact('project'));
            }else{
                $pdf = PDF::loadView('admin.2022.project.carta', compact("project"));
                return $pdf->stream('Carta-MH10-2022-'.$project->zeroFolio.'.pdf');
            }
        }else{
            return redirect()->route('admin.2022.not-found');
        }

    }

    public function tarjeta($slug){
        $project = Project::where('slug',$slug)
        ->with(['members.documents','type','items','period','giro' => function($query){
            $query->where('period_id',session('period_id'));
        }])
        ->get()->first();
        if($project != null){
            $test = 0;

            if($test){
                return view('admin.2022.project.tarjeta',compact('project'));
            }else{
                $pdf = PDF::loadView('admin.2022.project.tarjeta', compact("project"));
                return $pdf->stream('Tarjeta-MH10-2022-'.$project->zeroFolio.'.pdf');
            }
        }else{
            return redirect()->route('admin.2022.not-found');
        }
    }

    /**Download all documents from project */
    public function downloadAllDocs(Request $request){
        return response()->json($request->all());
    }

    public function bankDetails(Request $request, $slug){

        $validatedData = $request->validate([
            'card-bank-owner' => 'required|integer|gt:0',
            'card-number' => 'required|digits:16',
        ]);

        $project = Project::where("slug",$slug)->get()->first();
        $member = Member::find($request->input('card-bank-owner'));
        
        if($project != null & $member != null){
            
            $project->bank_card_number = $request->input('card-number');
            $member->card_bank_owner = true;

            DB::transaction(function () use($project,$member) {
                DB::table('members')->where('project_id',$project->id)->update(['card_bank_owner' => false]);
                $project->save();
                $member->save();
            });

            return response()->json(
                [
                    'res' => true,
                    'message' => 'Se ha actualizo los datos bancarios de forma correcta'
                ]
            );

        }else{
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }
    }

    public function exportReportConvenios(){
        return Excel::download(new ReportConvenios, 'reporte-convenios-'.date('Y-m-d-h-i-s').'.xlsx');
    }

    public function exportPadron(){
        return Excel::download(new BeneficiariesPadron,'padron-beneficiarios-'.date('Y-m-d-h-i-s').'.xlsx');
    }

}