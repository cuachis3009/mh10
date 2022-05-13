<?php

namespace App\Http\Controllers\Y2022;

use App\Member;
use App\Project;
use App\Drainage;
use App\CatColonia;
use App\WaterHouse;
use App\MateriaWall;
use App\CatLocalidad;
use App\CatMunicipio;
use App\CatVialidad;
use App\CatAsentamiento;
use App\CatLocCol;
use App\MaterialRoof;
use App\RelationShip;
use App\MaterialFloor;
use App\MemberDocument;
use App\MemberDependent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\MemberAdicionalInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberStoreRequest;
use Illuminate\Support\Facades\Validator;
use App\Utileria;

class MemberController extends Controller{

    public function create($type_project,$slug){

        $project = $this->getProject($slug);

        if($project->members->count() >= $project->number_members ){
            if($project->folio == null){
                $municipios = CatMunicipio::orderBy("clave_numero")->get(); 
                $asentamientos = CatAsentamiento::orderBy("id")->get();
                return redirect()->route($project->period->year.".project.complete",["type_project" => $project->type->name,"slug" => $project->slug]);
            }else{
                return redirect()->route($project->period->year.".project.succesfully",["type_project" => $project->type->name,"slug" => $project->slug]);
            }
        }else{
            $material_wall = MateriaWall::all();
            $material_roof = MaterialRoof::all();
            $material_floor = MaterialFloor::all();
            $water_house = WaterHouse::all();
            $drains = Drainage::all();
            $relationship = RelationShip::all();
            //$municipios = CatMunicipio::Where('indigena', '0')->orderBy("clave_numero")->get();          
            $municipios = CatMunicipio::orderBy("clave_numero")->get(); 
            //$municipiosIndigenas = CatMunicipio::Where('indigena', '1')->orderBy("clave_numero")->get();          
            $vialidades = CatVialidad::orderBy("id")->get();
            $asentamientos = CatAsentamiento::orderBy("id")->get();
            $yearsValidaty =range((date("Y")-3),(date("Y")+9));
            //return view("member.".$project->period->year.".create",compact("project","material_wall","material_roof","material_floor","water_house","drains","relationship","municipios","vialidades","asentamientos","municipiosIndigenas","yearsValidaty"));
            return view("member.".$project->period->year.".create",compact("project","material_wall","material_roof","material_floor","water_house","drains","relationship","municipios","vialidades","asentamientos","yearsValidaty"));
        }

    }

    public function store(MemberStoreRequest $request,$type_project,$slug){
    //valida la vigencia del periodo de apertura del proyecto
    $u = new Utileria;     
    if( $u->validaPeriodoProyecto($slug)==false){
        return response()->json(array(
            "res" => true,
            "msg" => "El periodo de apertura del proyecto no es valido",
            "url" => route("home.app")
        ));
    }
        /**Comenzamos a validar los dependientes economicos */
       /* $validate_dependents = $this->validateMemberDependents($request);
        
        if(!$validate_dependents["pass"]){ // Si falla la validacion
            return response()->json(array(
                "res" => false,
                "msg" => $validate_dependents["message_error"]
            ));
        }*/

        /**Ha pasado el proceso de validacion */
        $project = $this->getProject($slug);
        $member = $this->storeMember($request,$project);
        $member_aditional_info = $this->storeMemberAditionalInfo($request,$member);
        //$this->storeMemberDependents($request,$member);
        if($request->has("material-walls")){
            $this->storeMemberMaterialHouse($request->post("material-walls"),$member,"walls");
        }

        if($request->has("material-roofs")){
            $this->storeMemberMaterialHouse($request->post("material-roofs"),$member,"roofs");
        }

        if($request->has("material-floors")){
            $this->storeMemberMaterialHouse($request->post("material-floors"),$member,"floors");
        }
        
        $this->storeFileDocs($request,$member,$project);

        $project->refresh();

        $num_member_registered = $project->members->count();
        

        if($num_member_registered >= $project->number_members){

            /**Validamos si la integrante ha subido todos sus documentos */
            $documents = true;
            foreach ($project->members as $m) {
                if($m->documents != null){
                    if($m->documents->doc_official_id == 1 && $m->documents->doc_curp == 1){
                        $documents = true;
                    }else{
                        $documents = false;
                        break;
                    }
                }
            }

            if($documents){
                /** Enviamos al formulario del proyecto */
                return response()->json(array(
                    "res" => true,
                    "msg" => "La información se ha guardado correctamente <br> <strong>Redireccionando al formulario</strong>",
                    "url" => route($project->period->year.".project.complete",["type_project" => $project->type->name,"slug" => $project->slug])
                ));
            }else{
                /** Enviamos al formulario del proyecto */
                return response()->json(array(
                    "res" => true,
                    "msg" => "Validando información ",
                    "url" => route($project->period->year.".member.documents",["type_project" => $project->type->name,"slug" => $project->slug])
                ));
            }
        }else{
            /** Solicitamos la información de la siguiente integrante */
            return response()->json(array(
                "res" => true,
                "msg" => "Se ha guardado correctamente la información ".($num_member_registered)."<br><strong>Cargando formulario ".($num_member_registered + 1)."</strong>",
                "url" => route($project->period->year.".member.create",["type_project" => $project->type->name,"slug" => $project->slug])
            ));
        }

    }

    public function storeMemberMaterialHouse($material_house,$member,$type){
        if($type == "walls"){
            $member->materialWalls()->sync($material_house);
        }

        if($type == "roofs"){
            $member->materialRoofs()->sync($material_house);
        }

        if($type == "floors"){
            $member->materialFloors()->sync($material_house);
        }
    }

    public function storeMemberDependents($request,$member){
        foreach ($request->post("dependent-ids") as $id) {
            $dependent = new MemberDependent;
            $fullname = trim($request->post("name-dependent-".$id));
            $old_age = trim($request->post("age-old-dependent-".$id));
            /*$beneficiary = trim($request->post("beneficiary-program-dependent-".$id));*/

            $dependent->member_id = $member->id;
            $dependent->fullname = $fullname;
            $dependent->relation_ship_id = $request->post("relationship-dependent-".$id);      
            $dependent->age_old = $old_age;
            $dependent->has_disability = $request->post("disability-dependent-".$id);
            if($request->has("specify-disability-".$id)){
                $dependent->specify_disability = $request->post("specify-disability-".$id);
            }
            $dependent->student = $request->post("student-dependent-".$id);
            /*$dependent->beneficiary_social_program = $beneficiary;*/
            $dependent->save();
        }
    }

    /*
    public function validateMemberDependents($request){
        $pass = true;
        $message_error = '';
        foreach ($request->post("dependent-ids") as $id) {
            $fullname = trim($request->post("name-dependent-".$id));
            $old_age = trim($request->post("age-old-dependent-".$id));
            $beneficiary = trim($request->post("beneficiary-program-dependent-".$id));

            if($request->has("specify-disability-".$id)){
                $disability = trim($request->post("specify-disability-".$id));
            }else{
                $disability = 'not-included';
            }

            if($fullname == '' || $old_age == '' || $disability == ''){
                $pass = false;
                $message_error = "Por favor valida que has ingresado todos los datos de tus dependientes economicos";
                break;
            }

            if($old_age < 0){
                $pass = false;
                $message_error = "Por favor valida que la edad de tus dependientes sea valida";
                break;
            }
        }

        return array(
            "pass" => $pass,
            "message_error" => $message_error
        );
    }
*/

    public function storeFileDocs($request,$member,$project){
        /**Procedemos a guardar los archivos  */

        $docs = new MemberDocument;
        $docs->member_id = $member->id;

/*        if($request->hasFile("doc-carta")){
            $path_official_id = $request->file('doc-carta')->storeAs(
                $project->period->year.'/members-doc/'.$member->slug->toString(),
                $member->slug->toString()."-doc-carta.pdf",
                "public"
            );
            $docs->doc_carta= true;
        } else $docs->doc_carta= 0;*/

        if($request->hasFile("doc-official-id")){
            $path_official_id = $request->file('doc-official-id')->storeAs(
                $project->period->year.'/members-doc/'.$member->slug->toString(),
                $member->slug->toString()."-official-id.pdf",
                "public"
            );
            $docs->doc_official_id = true;
        } else $docs->doc_official_id= 0;

        if($request->hasFile("doc-curp")){
            $path_official_id = $request->file('doc-curp')->storeAs(
                $project->period->year.'/members-doc/'.$member->slug->toString(),
                $member->slug->toString()."-doc-curp.pdf",
                "public"
            );
            $docs->doc_curp = true;
        } else $docs->doc_curp= 0;  

       /* if($request->hasFile("doc-constancia")){
            $path_official_id = $request->file('doc-constancia')->storeAs(
                $project->period->year.'/members-doc/'.$member->slug->toString(),
                $member->slug->toString()."-doc-constancia.pdf",
                "public"
            );   
            $docs->doc_constancia = true;
        } else $docs->doc_constancia= 0;
*/
        $docs->save();
        
    }

    public function storeMember($request,$project){
        $member = new Member;
        $member->project_id = $project->id;
        $member->slug = Str::uuid();
        $member->web_registration = 0;
        $member->name = $request->post("name");
        $member->father_surname = $request->post("p_surname");
        $mother_surname = $request->post("m_surname");
        $member->mother_surname = ($mother_surname == null || $mother_surname == '') ? "--" : $mother_surname;
        $member->curp = $request->post("txt-curp");
        $member->official_id_clave = trim($request->post("elector-id"));
        $member->officlal_id_year_expiration = $request->post("year-id-validity");
        $member->cellphone_number = $request->post("cellphone-number");
        $member->house_phonenumber = $request->post("home-phone");
        $member->adicional_phonenumber = $request->post("adicional-phone");
        $member->email = $request->post("email");
        $member->sex = $request->post("member-sex");
        $member->rfc = ''; //$request->post("member-rfc");
        //$member->marital_status = $request->post("member-marital_status");
        $member->age = $request->post("member_age");
        $member->status_rfc = ''; //$request->post("member-status_rfc");
        $member->discharge_date_rfc = ''; //$request->post("member-discharge_date_rfc");
        $member->street = $request->post("street-name");
        $member->exterior_number = $request->post("exterior-street-number");
        $member->interior_number = $request->post("interior-street-number");
        //$member->colonia = $request->post("colony-name");
        $member->postal_code = $request->post("postal-code");
        //$member->municipio = $request->post("municipio-name");
        //$member->estado = $request->post("estado-name");
        $member->cat_municipio_id = $request->post("municipio-zap");
        $member->cat_municipio_id_indigena = $request->post("municipio-ind");
        //$member->cat_localidad_id = $request->post("localidad-zap");
        //$member->cat_colonia_id = $request->post("colonia-zap");
        $member->cat_loc_col_id = $request->post("loc_col-zap");
        $member->cat_tipo_vialidad_id = $request->post("tipo_vialidad");
        $member->cat_tipo_asentamiento_id = $request->post("tipo_asentamiento");   
        $member->referencia_domicilio = $request->post("referencia_domicilio");           
        $member->cat_estudios_id = $request->post("study_member");    
        $member->save();
        return $member;
    }

    public function storeMemberAditionalInfo($request,$member){
        $aditional_info = new MemberAdicionalInformation;
        $aditional_info->member_id = $member->id;
        $aditional_info->has_disability = $request->post("has-disability");
        $aditional_info->specify_disability = $request->post("specify-disability");
        $aditional_info->water_type = $request->post("water");
        $aditional_info->has_kitchen = $request->post("has-kitchen");
        $aditional_info->number_rooms_as_bedroom = $request->post("number-rooms-as-bedroom");
        $aditional_info->number_of_bathrooms = $request->post("number-of-bathrooms");
        $aditional_info->drainage_id = $request->post("home-has-drainage");
        $aditional_info->home_light_id = $request->post("home-has-light");
        //specify-house$aditional_info->house_adquisition_id = $request->post("house-is");       
        //$aditional_info->specify_house = $request->post("specify-house");               
        $aditional_info->people_live_in_house = $request->post("people-live-in-house");
        $aditional_info->pregnant_person_in_house = $request->post("pregnant-person-in-house");
        //$aditional_info->monthly_income = $request->post("monthly-income");
        $aditional_info->health_care_service_id = $request->post("health-care-service");
        $aditional_info->returned_migrant = $request->post("returned-migrant");
        $aditional_info->can_read_write = $request->post("can-read-write");
        //$aditional_info->employment = $request->post("employment");
        $aditional_info->group_indigena = $request->post("group-indigena");
        $aditional_info->years_experience_project = $request->post("years-experience-project");
        $aditional_info->save();
        return $aditional_info;

    }

    public function documents($type_project,$slug){
        $project = Project::where("slug",$slug)->with(["period","type","members.documents"])->first();

        return view("member.".$project->period->year.".complete-documents",compact("project"));        
    }

    public function completeDocuments(Request $request,$type_project,$slug){
            //valida la vigencia del periodo de apertura del proyecto
    $u = new Utileria;     
    if( $u->validaPeriodoProyecto($slug)==false){
        return response()->json(array(
            "res" => true,
            "msg" => "El periodo de apertura del proyecto no es valido",
            "url" => route("home.app")
        ));
    }
        $project = Project::where("slug",$slug)->with(["period","type","members.documents"])->first();

        $pass = true;
        $message_error = '';

        foreach ($project->members as $member) {
            /**Solo validamos */
            //\Log::info($member->documents->doc_carta);
            /*
            if($member->documents->doc_carta == 0){
                if($request->hasFile("doc-carta".$member->slug)){
                    $validat_carta = $this->validateFile($request->file("doc-carta".$member->slug));
                    if(!$validat_carta){
                        $pass = false;
                        $message_error = "Verifica que el archivo que estas seleccionando sea de tipo PDF y pese menos a 2MB";
                        break;
                    }
                }
            }*/
            if($member->documents->doc_official_id == 0){
                if($request->hasFile("doc-official-id-".$member->slug)){
                    $validat_official_id = $this->validateFile($request->file("doc-official-id-".$member->slug));
                    if(!$validat_official_id){
                        $pass = false;
                        $message_error = "Verifica que el archivo que estas seleccionando sea de tipo PDF y pese menos a 2MB";
                        break;
                    }
                }
            }

            if($member->documents->doc_curp == 0){
                if($request->hasFile("doc-curp-".$member->slug)){
                    $validat_curp = $this->validateFile($request->file("doc-curp-".$member->slug));
                    if(!$validat_curp){
                        $pass = false;
                        $message_error = "Verifica que el archivo que estas seleccionando sea de tipo PDF y pese menos a 2MB";
                        break;
                    }
                }
            }

            /*if($member->documents->doc_constancia == 0){
                if($request->hasFile("doc-constancia".$member->slug)){
                    $validat_constancia = $this->validateFile($request->file("doc-constancia".$member->slug));
                    if(!$validat_constancia){
                        $pass = false;
                        $message_error = "Verifica que el archivo que estas seleccionando sea de tipo PDF y pese menos a 2MB";
                        break;
                    }
                }
            }
            */
           // \Log::info($pass);
            if($pass){
                /**Guardamo si solo sale bien */
                /*if($member->documents->doc_carta == 0){
                    if($request->hasFile("doc-carta".$member->slug)){
                        $this->storeUniqueFile($request->file("doc-carta".$member->slug),$member,$project,"doc-carta");
                        $member->documents->doc_carta = true;
                    }else $pass = false;
                }*/

                if($member->documents->doc_official_id == 0){
                    if($request->hasFile("doc-official-id-".$member->slug)){
                        $this->storeUniqueFile($request->file("doc-official-id-".$member->slug),$member,$project,"official-id");
                        $member->documents->doc_official_id = true;
                    }else $pass = false;
                }
    
                if($member->documents->doc_curp == 0){
                    if($request->hasFile("doc-curp-".$member->slug)){
                        $this->storeUniqueFile($request->file("doc-curp-".$member->slug),$member,$project,"doc-curp");
                        $member->documents->doc_curp = true;
                    }else $pass = false;
                }                              
               // \Log::info($request->hasFile("doc-constancia"));
             /*   if($member->documents->doc_constancia == 0){
                    if($request->hasFile("doc-constancia-".$member->slug)){
                        $this->storeUniqueFile($request->file("doc-constancia-".$member->slug),$member,$project,"doc-constancia");
                        $member->documents->doc_constancia = true;
                    }else $pass = false;
                }*/
            }

            $member->documents->save();
            
        }

        if($pass){
            return response()->json(array(
                "res" => true,
                "msg" => "La información se ha guardado correctamente <br> <strong>Redireccionando al formulario</strong>",
                "url" => route($project->period->year.".project.complete",["type_project" => $project->type->name,"slug" => $project->slug])
            ));
        }else{
            /*return response()->json(array(
                "res" => $pass,
                "msg" => $message_error,
            ));*/
            return response()->json(array(
                "res" => true,
                "msg" => "Validando información ",
                "url" => route($project->period->year.".member.documents",["type_project" => $project->type->name,"slug" => $project->slug])
            ));
        }

    }

    public function storeUniqueFile($file,$member,$project,$name){
        return $file->storeAs(
            $project->period->year.'/members-doc/'.$member->slug,
            $member->slug."-".$name.".pdf",
            "public"
        );
    }

    public function validateFile($file){
        if($file->getMimeType() == "application/pdf" && $file->getSize() < 2100000){
            return true;
        }else{
            return false;
        }
    }

    public function validateCurp(Request $request){
        /**Probamos el curp */
       
        if($request->curp){
            $curp = trim(str_replace(" ","",$request->curp));

            /**Validamos si el curp existe */
            $curp_exist = Member::where("curp",$curp)->latest()->first();

            if($curp_exist != null && $curp_exist->web_registration == true){ // Si existe la curp y ya finalizo su registro, por lo cual se le debe negar el registro
                $response = array(
                    'error' => true,
                    'msg' => 'La CURP que estas ingresando ya esta registrada, por favor intenta con una nueva'
                );
            }else{

                $project = Project::where("slug",$request->slug)->first();
                $curp_exist_on_project = Member::where(["curp" => $curp,"project_id" => $project->id])->first();

                if($curp_exist_on_project == null){

                    /**A flta de una mejor idea volvemos a tomar todos aquellos registros donde la curp es igual a la enviada por post */
                    $curps = Member::where("curp",$curp)->get();
                    if($curps != null){//Si existen registros pasamos el emial a nulo, para evitar errores en el nuevo registro
                        foreach ($curps as $m) {
                            $m->email = null;
                            $m->save();
                        }
                    }
                    $curp_response = Curl::to(config('curp.endpoint'))
                        ->withData(['curp' => $curp,'token' => config('curp.token')])
                        ->asJson()
                        ->get();                      

                    if($curp_response->estatusOperacion == 'EXITOSO'){
                        $response = array(
                            'error' => false,
                            'curp' => $curp_response
                        );
                    }else{
                        $response = array(
                            'error' => true,
                            'msg' => 'La CURP que has ingresado es incorrecta, por favor verifica que se encuentre igual que tu INE ó IFE'
                        );
                    }
                }else{
                    $response = array(
                        'error' => true,
                        'msg' => 'La CURP que estas ingresando ya esta registrada para este proyecto, por favor intenta con otra'
                    );
                }

            }

            return response()->json($response);
        }else{
            return response()->json(null,401);
        }
    }

    public function getProject($slug){
        return Project::where("slug",$slug)->with(["period","type","members"])->first();
    }

    public function getZap(Request $request,$type){

        if($type == "localidad"){
            $options = $this->getZapLocalidad($request->clave);
        }elseif($type == "municipio"){
            $options = $this->getZapMunicipios($request->clave);
        }elseif($type == "loc_col"){
            $options = $this->getZapLocCol($request->clave);
        }else{
            $zap_code = explode("-",$request->clave);
            $options = $this->getZapColonia($zap_code[0],$zap_code[1]);
        }

        return response()->json($options);

    }

    public function getZapMunicipios($tipo){
        return CatMunicipio::where("indigena",$tipo)->orderBy("clave_numero")->get(["id","clave_numero","municipio"]);
    }
    public function getZapLocalidad($clave_municipio){
        return CatLocalidad::where("clave_municipio",$clave_municipio)->orderBy("localidad")->get(["id","clave_municipio","clave_localidad","localidad"]);
    }

    public function getZapColonia($clave_municipio,$clave_localidad){
        return CatColonia::where(["id_municipio" => $clave_municipio,"id_localidad" => $clave_localidad])->orderBy("colonia")->get(["id","colonia"]);
    }
    public function getZapLocCol($clave_municipio){
        return CatLocCol::where(["clave_municipio" => $clave_municipio])->orderBy("clave_loc_col")->get(["id","loc_col"]);
    }

}
