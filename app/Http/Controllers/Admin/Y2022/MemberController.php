<?php

namespace App\Http\Controllers\Admin\Y2022;

use App\Member;
use App\Project;
use App\CatColonia;
use App\CatLocalidad;
use App\CatLocCol;
use App\CatMunicipio;
use App\CatVialidad;
use App\CatAsentamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {

        $member = Member::where('slug', $slug)
            ->with('project.type')
            ->get()->first();

        $municipios = CatMunicipio::orderBy("clave_numero")->get();
        $zona_zap = $this->preloadZap($member->cat_municipio_id, $member->cat_localidad_id);

        return view('admin.2022.member.edit', compact('member', 'municipios', 'zona_zap'));
    }

    public function preloadZap($municipio_id, $localidad_id)
    {
        $zap = array(
            'localidad' => null,
            'colonia' => null
        );

        if ($municipio_id != null) {
            $municipio = CatMunicipio::find($municipio_id);
            /**Obtenemos todas las localidades o colonias */
            $loc_col_zap = CatLocCol::where('clave_municipio', $municipio->clave_numero)->get();
            $zap['loc_col_zap'] = $loc_col_zap;

            /**Obtenemos todas las vialidad */
            $vialidades = CatVialidad::orderBy("id")->get();
            $zap['vialidades'] = $vialidades;
           
           
            /**Obtenemos todas los asentamientos */
            $asentamientos = CatAsentamiento::orderBy("id")->get();
            $zap['asentamientos'] = $asentamientos;

            /**Obtenemos todas los municipiosIndigenas */
            $municipiosIndigenas = CatMunicipio::Where('indigena', '1')->orderBy("clave_numero")->get();       
            $zap['municipiosIndigenas'] = $municipiosIndigenas;

            /**Obtenemos todas las localidades */
            //$localidades = CatLocalidad::where('clave_municipio',$municipio->clave_numero)->get();
            //$zap['localidad'] = $localidades;
            /**Obtenemos las colonias */
            //$localidad_select = $localidades->where('id',$localidad_id)->first();
            // $colonias = CatColonia::where(['id_municipio' => $localidad_select->clave_municipio,'id_localidad' => $localidad_select->clave_localidad])->get();
            // $zap['colonia'] = $colonias;
        }

        return $zap;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'p_surname' => 'required',
            "elector-id" => 'required|size:18',
            "curp" => 'required|size:18',
            "street-name" => "required",
            "exterior-street-number" => "required",
            "postal-code" => "required|digits:5",
            "municipio-zap" => "required",
            "loc_col-zap" => "required",
            "tipo_vialidad" => "required",
            "tipo_asentamiento" => "required",
        ], [
            'name.required' => 'Ingresa el nombre.',
            'p_surname.required' => 'Ingresa el apellido paterno.',
            "elector-id.required" =>  "Ingresa la clave de elector de la INE/IFE.",
            "elector-id.size" => "La clave de elector debe tener al menos 18 caracteres",
            "curp.required" =>  "Ingresa la clave de elector del INE/IFE.",
            "curp.size" => "La clave de elector debe tener al menos 18 caracteres",
            "street-name.required" => "Ingresa el nombre de la calle.",
            "exterior-street-number.required" => "Ingresa el numero exterior.",
            "colony-name.required" => "Ingresa el nombre de la colonia.",
            "postal-code.required" => "Ingresa el código postal.",
            "postal-code.digits" => "El código postal debe estar compuesto por 5 digitos.",            
            "municipio-zap.required" => "Selecciona tu municipio",
            "loc_col-zap.required" => "Selecciona tu localidad o colonia",
            "tipo_vialidad.required" => "Selecciona el tipo vialidad",
            "tipo_asentamiento.required" => "Selecciona el tipo de asentamiento",
        ]);

        $member = Member::where('slug', $slug)
            ->with('project')
            ->get()->first();

        $member->name = $request->input('name');
        $member->father_surname = $request->input('p_surname');
        $member->mother_surname = $request->input('m_surname');
        $member->official_id_clave = $request->input('elector-id');
        $member->curp = $request->input('curp');
        $member->street = $request->input('street-name');
        $member->exterior_number = $request->input('exterior-street-number');
        $member->interior_number = $request->input('interior-street-number');
        $member->colonia = $request->input('colony-name');
        $member->postal_code = $request->input('postal-code');
        $member->municipio = $request->input('municipio-name');
        $member->estado = $request->input('estado-name');
        $member->domicilioINE = $request->input('domicilioINE');
        $member->cat_municipio_id = $request->input('municipio-zap');       
        $member->cat_municipio_id_indigena = $request->post("municipio-ind");
        $member->cat_loc_col_id = $request->post("loc_col-zap");
        $member->cat_tipo_vialidad_id = $request->post("tipo_vialidad");
        $member->cat_tipo_asentamiento_id = $request->post("tipo_asentamiento");   
        $member->save();

        return response()->json(
            array(
                'res' => true,
                'url' => route('admin.2022.show', ['slug' => $member->project->slug])
            )
        );
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

    /**
     * Mostratamos laz zonas zap por municipio de las integrantes
     */
    public function zapZones()
    {

        $municipios = CatMunicipio::all()->sortBy('clave_numero')->mapWithKeys(function ($item) {
            return [$item['clave_numero'] => array(
                'municipio' => $item['municipio'],
                'zap' => 0,
                'no_zap' => 0
            )];
        })->toArray();

        $projects = Project::where('status', 1)->with(['members' => function ($query) {
            $query->with(['municipio', 'localidad']);
        }])->get();

        $no_members_municipio = 0;

        foreach ($projects as $project) {
            foreach ($project->members as $member) {
                if ($member->cat_municipio_id != null && $member->cat_localidad_id != null) {
                    if ($member->localidad->zap == 1) {
                        $municipios[$member->localidad->clave_municipio]['zap'] = $municipios[$member->localidad->clave_municipio]['zap'] + 1;
                    } else {
                        $municipios[$member->localidad->clave_municipio]['no_zap'] = $municipios[$member->localidad->clave_municipio]['no_zap'] + 1;
                    }
                } else {
                    $no_members_municipio++;
                }
            }
        }

        return view('admin.2022.member.zap', \compact('no_members_municipio', 'municipios'));
    }
}
