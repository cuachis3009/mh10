<?php

namespace App\Http\Controllers\Y2022;

use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageReceived;
use App\Member;
use App\Project;
use App\ProjectItem;
use App\ProjectType;
use App\CatMunicipio;
use App\CatAsentamiento;
use App\CatEstandar;
use App\CatHorarios;
use App\CatModalidadLocal;
use App\CatConocimiento;
use App\Project_Conocimiento;
use Illuminate\Support\Str;
use App\Traits\ActivePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProjectStoreRequest;
use phpDocumentor\Reflection\Types\Array_;
use App\Utileria;
use JWTException;

class ProjectController extends Controller
{

    use ActivePeriod;

    public $year = 2022;

    public function index()
    {
        $period = $this->getPeriod($this->year);
        //valida la vigencia del periodo de apertura del proyecto
        $u = new Utileria;     
        if( $u->validaPeriodoProyecto('-')==false){return view("project.".$this->year.".app-disable");}
        //return view("project.".$this->year.".app-disable"); 
        return view("project." . $this->year . ".index", compact('period'));
    }

    public function create(Request $request, $type)
    {
         //valida la vigencia del periodo de apertura del proyecto
         $u = new Utileria;     
         if( $u->validaPeriodoProyecto('-')==false){return view("project.".$this->year.".app-disable");}
 
        $validatedData = $request->validate([
            'read-rop' => 'required', 'read-rob' => 'required',
        ], [
            "read-rop.required" => "Recuerda seleccionar la opción de \"He leido y comprendo las reglas de operación\" ",
            "read-rob.required" => "Recuerda seleccionar la opción de \"Conozco los alcances, beneficios y obligaciones del programa\" ",
           
        ]);


        $type = ProjectType::where("name", $type)->with(["periods" => function ($query) {
            $query->where("year", $this->year);
        }])->first();

        if ($type->name == 'nuevo') {
            $num_members = 1;
        } else {
            $num_members = (int)$request->input('num-members');
            if ($num_members < 2 || $num_members > 4) {
                return redirect()->route($type->periods[0]->year . ".home");
            }
        }

        $project = new Project;
        $project->period_id = $type->periods[0]->id;
        $project->project_type_id = $type->id;
        $project->slug = Str::uuid();
        $project->number_members = $num_members;
        $project->save();

        return redirect()->route($type->periods[0]->year . ".member.create", ["type_project" => $type->name, "slug" => $project->slug->toString()]);
    }

    public function completeProjectInfo($type_project, $slug)
    {
        $municipios = CatMunicipio::orderBy("clave_numero")->get();
        $asentamientos = CatAsentamiento::orderBy("id")->get();
        $ModalidadLocal = CatModalidadLocal::orderBy("id")->get();
        $Estandares = CatEstandar::orderBy("id")->get();
        $project = Project::where("slug", $slug)->with(["period", "type"])->first();
        if ($project->folio == null) {
            return view("project." . $project->period->year . ".complete_info", compact("project", "municipios", "asentamientos", "ModalidadLocal","Estandares"));
        } else {
            return redirect()->route($project->period->year . ".project.succesfully", ["type_project" => $project->type->name, "slug" => $project->slug]);
        }
    }

    public function finishProject(ProjectStoreRequest $request, $type_project, $slug)
    {
        //valida la vigencia del periodo de apertura del proyecto
        $u = new Utileria;     
        if( $u->validaPeriodoProyecto($slug)==false){
            return response()->json(array(
                "res" => true,
                "msg" => "El periodo de apertura del proyecto no es valido",
                "url" => route("home.app")
            ));
        }  

        $project = Project::where("slug", $slug)->with(["period", "type", "members"])->first();
        //se valida que la curp no este dos veces con proyecto completo
        $curp_exist = $project->members->first();        
        if ($curp_exist->web_registration == true || $curp_exist->email == null) { // Si existe la curp y ya finalizo su registro, por lo cual se le debe negar el registro
             return response()->json(array(
                'error' => true,
                'msg' => 'La CURP que estas ingresando ya esta registrada o tu cuenta de correo electrónico ya ha sido utilizada, por favor intenta con una nueva'
            ));  
        } 
        /**Validamos que el proyecto este completo y no sobre pase la cantidad a otorgar */
        $validate_items = $this->validateItems($request, $project);        

        if (!$validate_items["pass"]) { // Si falla la validacion
            return response()->json(array(
                "res" => false,
                "msg" => $validate_items["message_error"]
            ));
        }
       

        /**Guardamos los articulos del proyecto */
        $validate_items = $this->storeItems($request, $project);
        /**Guardamos los conocimientos */
        $validate_Conocimiento = $this->storeConocimiento($request, $project);
        /*guardamos los <horarios></horarios>storeHorario*/
        //$validate_horarios = $this->storeHorario($request, $project);
        /**Comenzamos a actualizar a las integrantes marcando su web_registration como finalizado */
        foreach ($project->members as $member) {
            $member->web_registration = true;
            $member->save();
        }

        $folio = $this->getNextFolio($project->period->id, $project->type->id);
        $project->folio = $folio;
        $project->cat_estandar_id = $request->post("tipo_estandar");
        $project->experience_time = $request->post("project-experience-time");
        $project->objective = $request->post("project-objective");
        $project->activity_description = $request->post("project-activity-description");

        /**Actualizamos el proyecto */
        $project->save();
        
        return response()->json(array(
            "res" => true,
            "msg" => "Su solicitud se ha registrado correctamente<br> <strong>Redireccionando</strong>",
            "url" => route($project->period->year . ".project.succesfully", ["type_project" => $project->type->name, "slug" => $project->slug])
        ));
    }

    public function storeItems($request, $project)
    {
        foreach ($request->post("item-ids") as $id) {

            $item_name = trim($request->post("item-name-" . $id));
            $item_unit = trim($request->post("item-unit-" . $id));
            $item_price = trim($request->post("item-price-" . $id));
            $item_quantity = trim($request->post("item-quantity-" . $id));
            $item_total_cost = trim($request->post("item-total-cost-" . $id));

            $item = new ProjectItem;
            $item->project_id = $project->id;
            $item->item = $item_name;
            $item->unit = $item_unit;
            $item->quantity = $item_quantity;
            $item->price = $item_price;
            if ($item_total_cost == ($item_quantity * $item_price)) {
                $item->total_cost = $item_total_cost;
            } else {
                $item->total_cost = ($item_quantity * $item_price);
            }
            $item->save();
        }
    }

    public function storeConocimiento($request, $project)
    {
        foreach ($request->post("chkList") as $chk) {
            $projectConocimiento = new Project_Conocimiento();
            $projectConocimiento->proyect_id = $project->id;
            $projectConocimiento->cat_conocimiento_id = $chk;            
            $projectConocimiento->save();
        }
    }
    public function storeHorario($request, $project)
    {
        $timeA = trim($request->post("timeA"));
        $timeC = trim($request->post("timeC"));
        foreach ($request->post("chk-") as $id) {
            $horario = new CatHorarios();
            $horario->project_id = $project->id;
            $horario->dia = $id;
            $horario->apertura = $timeA;
            $horario->cierre = $timeC;
            $horario->save();
        }
    }
    public function validateItems($request, $project)
    {
        $pass = true;
        $message_error = '';
        $total_price_project = 0;
        foreach ($request->post("item-ids") as $id) {

            $item_name = trim($request->post("item-name-" . $id));
            $item_unit = $request->post("item-unit-" . $id);
            $item_price = $request->post("item-price-" . $id);
            $item_quantity = $request->post("item-quantity-" . $id);
            $item_total_cost = $request->post("item-total-cost-" . $id);

            if ($item_name == '') {
                $pass = false;
                $message_error = "Por valida que los datos de los artículos del proyecto esten completos";
                break;
            }

            if (strpos($item_price, ".") !== false) {
                $pass = false;
                $message_error = "Recuerda no agregar decimales al costo aproximado ó a la cantidad.";
                break;
            }

            if (strpos($item_quantity, ".") !== false) {
                $pass = false;
                $message_error = "Recuerda no agregar decimales al costo aproximado ó a la cantidad.";
                break;
            }

            /**Comenzamos a sacar el calculo para definir si se paga de la cantidad a otorgar o no */
            $total_item = $item_price * $item_quantity;
            $total_price_project = $total_price_project + $total_item;
        }

        if ($pass) {
            /*if ($project->type->name == "fortalecimiento") {
                $amount_project = 30000;
            } else {
                $giro_project = $request->post("project-giro");
                if (in_array($giro_project, array(1, 2))) {
                    $amount_project = 40000;
                } else {
                    $amount_project = 30000;
                }
            }*/
            $amount_project = 12000;
            if ($total_price_project > $amount_project) {
                $pass = false;
                $message_error = "De acuerdo a las Reglas de operación la suma total debe ser de $" . number_format($amount_project, 2, ".", ",") . "  <br> <strong>Verifica los componentes, herramientas, equipo básico, materia prima e insumos que va a adquirir.</strong>";
            }
        }

        return array(
            "pass" => $pass,
            "message_error" => $message_error
        );
    }

    public function getNextFolio($period_id, $project_type_id)
    {
        $next_folio = Project::where(["period_id" => $period_id, "project_type_id" => $project_type_id])->max("folio");
        if ($next_folio == null) {
            $next_folio = 1;
        } else {
            $next_folio = $next_folio + 1;
        }

        return $next_folio;
    }

    public function succesfully($type_project, $slug)
    {
        //$project = Project::where("slug", $slug)->with(["period", "type"])->first();

        $project = Project::where("slug", $slug)->with(["period", "type", "items"])->first();        
        $members = Member::where("project_id", $project->id)->with(["info.water", "dependents.relationship", "materialWalls"])->get();
        //$horarios = CatHorarios::where("project_id", $project->id);
        $pdf = PDF::loadView('project.2022.pdf', compact("project", "members"));
        $data["email"]=$members->first()->email;
        $data["client_name"]=$members->first()->fullName;
        $data["subject"]="Proyectos de Desarrollo Social para la Competitividad en el Estado 2022";
        Mail::send('mails.mail', $data, function ($message) use ($data, $pdf) {
            $message->to($data["email"], $data["client_name"])
                ->subject($data["subject"])
                ->attachData($pdf->output(), "registro.pdf");
        });

        return view("project." . $project->period->year . ".succesfully-registration", compact("project"));
    }

    public function downloadPdf($type_project, $slug)
    {
        $project = Project::where("slug", $slug)->with(["period", "type", "items"])->first();
        $members = Member::where("project_id", $project->id)->with(["info.water", "dependents.relationship", "materialWalls"])->get();
        
        if ($project != null) {

            //return view("project.2022.pdf",compact("project", "members"));
            //$this->sendMail('Probando correo');

            $pdf = PDF::loadView('project.2022.pdf', compact("project", "members"));

            /*$data["email"]=$members->first()->email;
            $data["client_name"]=$members->first()->fullName;
            $data["subject"]="Proyectos de Desarrollo Social para la Competitividad en el Estado 2022";
            Mail::send('mails.mail', $data, function ($message) use ($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "registro.pdf");
            });*/



            //$this->sendMail($project,$members,$pdf);           
            //Mail::to('dursi.sedeso@morelos.gob.mx')->send(new MessageReceived($project));


            return $pdf->stream('PIPC-2022-' . strtoupper($project->type->name[0]) . '-' . $project->zeroFolio . '.pdf');
        } else {
            return abort(404);
        }
    }

    //Iterate over all documents projects

    public function validateProject($period, $type, $folio = null)
    {

        /**Commenzamos a crear la variables iniciales */
        $max_folio = ($type == 2) ? 573 : 5250;
        $init_folio = ($folio === null) ? 1 : (int)$folio;
        $municipio = null;
        /**Validamos que el folio no supere el ultimo registrado */
        if ($folio >= $max_folio) {
            return "Se ha acabado de iterar sobre el proyecto de mayor folio";
        } else {
            /**Obtenemos el proyecto */
            $project = Project::where(["folio" => $init_folio, "period_id" => (int)$period, 'project_type_id' => (int)$type])->with("period", "members.documents", "type")->first();

            if ($project != null) {
                /**Comenzamos a validar que el numero de integrante sea el correcto */
                $member_count_same_project = $this->validateNumMembers($project->id, $project->number_members, $project->members->count());
                $validate_members = $this->validateMembers($project->members, $project);
                $project_member_validation = $validate_members['project'];
                $project->full_documentation = $project_member_validation['p_is_documentation_complete'];
                $project->member_duplicate_same_project = $project_member_validation['p_is_duplicate_same_project'];
                $project->member_duplicate_other_projects = $project_member_validation['p_is_duplicate_other_projects'];
                $project->member_benefited_other_year = $project_member_validation['p_is_benefited_other_year'];
                if ($project_member_validation["txt_project_validation"] != null) {
                    $project->same_member_previous_project = false;
                } else {
                    if ($project->project_type_id == 2) {
                        $project->same_member_previous_project = true;
                    }
                }
                $project->deny = $project_member_validation['txt_project_validation'];
                $project->member_count_same_project = $member_count_same_project;
                $project->municipio = $validate_members['municipio'];
                $project->save();
                $project->refresh();
                $info_members = $validate_members["members"];
                return view('project.2022.validate_project', compact(['project', 'info_members', 'period', 'type', 'folio']));
            } else {
                $text = "No se ha podido obtener el proyecto con el folio " . $folio;
                Log::channel('docsmemberlog')->info($text);
                return view('project.2022.validate_project', compact(['text', 'period', 'type', 'folio']));
            }
        }
    }

    public function validateMembers($members, $project)
    {
        $curps = $this->countCurps($members);
        $project_past_year = null;
        $not_member = null;
        $txt_project_validation = null;
        $p_is_duplicate_same_project = false;
        $p_is_duplicate_other_projects = false;
        $p_is_documentation_complete = true;
        $p_is_benefited_other_year = false;
        /**Nuevo array de integrantes */
        $members_views = array();
        $municipio = collect();
        $special_characters = array('á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U');

        foreach ($members as $key => $member) {
            $txt_deny = array();
            $members_views[$member->id] = array();
            $members_views[$member->id]['slug'] = $member->slug;
            $members_views[$member->id]['curp'] = $member->curp;
            $members_views[$member->id]['name'] = $member->fullName;
            $municipio->push(Str::upper(trim(strtr($member->municipio, $special_characters))));
            /**--------------------------------------- M E M B E R  D U P L I C A T E  I N  S A M E  P R O J E C T ---------------------- */
            //Verificamos si la integrate no esta duplicada en el mismo proyecto
            $is_duplicate_same_project = $this->isMemberDuplicateInSameProject($member->curp, $curps);
            if ($is_duplicate_same_project['status']) {
                $p_is_duplicate_same_project = true;
            }
            $members_views[$member->id]['is_duplicate_same_project'] = $is_duplicate_same_project;
            if ($is_duplicate_same_project["txt"] != false) {
                array_push($txt_deny, $is_duplicate_same_project['txt']);
            }
            $member->member_duplicate_same_project = $is_duplicate_same_project['status'];

            /**--------------------------------------- M E M B E R  D U P L I C A T E  I N  O T H E R  P R O J E C T ---------------------- */
            //Verificamos si la integrante no esta registrada en otros proyectos
            $is_duplicate_other_projects = $this->isMemberDuplicateInOtherProjects($member->curp, $member->project_id);
            if ($is_duplicate_other_projects['status']) {
                $p_is_duplicate_other_projects = true;
            }
            $members_views[$member->id]['is_duplicate_other_projects'] = $is_duplicate_other_projects;
            if ($is_duplicate_other_projects["txt"] != false) {
                array_push($txt_deny, $is_duplicate_other_projects['txt']);
            }
            $member->member_duplicate_other_projects = $is_duplicate_other_projects['status'];

            /**--------------------------------------- M E M B E R  D O C U M E N T A T I O N  C O M P L E T E  ---------------------- */
            //Comenzamos a validar la documentacion 
            $is_documentation_complete = $this->isMemberDocumentationComplete($member);
            if ($is_documentation_complete['complete'] == false) {
                $p_is_documentation_complete = false;
            }

            $members_views[$member->id]['documents'] = $is_documentation_complete;
            $member->full_documentation = $is_documentation_complete['complete'];

            //Si el proyecto es nuevo
            if ($project->project_type_id == 1) {
                /**--------------------------------------- M E M B E R  B E N E F I T E D  O T H E R  Y E A R  ---------------------- */
                //Validamos si la integrante no fue beneficiada en años anteriores
                $is_benefited_other_year = $this->isMemberBenefitedInOtherYear($member->curp, $member->official_id_clave);
                if ($is_benefited_other_year['status']) {
                    $p_is_benefited_other_year = true;
                }

                $members_views[$member->id]['is_benefited_other_year'] = $is_benefited_other_year;
                if ($is_benefited_other_year["txt"] != false) {
                    array_push($txt_deny, $is_benefited_other_year['txt']);
                }
                $member->member_benefited_other_year = $is_benefited_other_year['status'];
            } else {
                //Buscamos si al menos una de las integrantes esta en el periodo 2019 en la convocatoria de nuevos
                if ($project_past_year == null) {
                    $exist_member_on_past_year = DB::table('info_crossing_members')->where(['periodo' => 2019, 'convocatoria' => 1, 'curp' => $member->curp])->first();
                    if ($exist_member_on_past_year != null) {
                        //Obtenemos a todas la integrantes del proyecto del año pasado
                        $exist_member_on_past_year = DB::table('info_crossing_members')->select(['curp'])->where(['periodo' => 2019, 'convocatoria' => 1, 'folio' => $exist_member_on_past_year->folio])->get();
                        $project_past_year = $exist_member_on_past_year->map(function ($row) {
                            return Str::upper($row->curp);
                        });
                    }
                }
            }

            $member->deny = implode(";", $txt_deny);

            $member->save();
        }

        /**Comenzamos a validar si todas la integrantes del proyecto pertenecen al mismo grupo del año anterior */
        if ($project->project_type_id == 2) {
            $curps = $this->formatCurps($curps);
            if ($project_past_year != null) {
                if ($project_past_year->count() == 4 && $curps->count() == 3) {
                    //Se tiene que validar que al menos 3 de las integrantes esten el proyecto
                    $validate_min_members = $project_past_year->diff($curps);
                    if ($validate_min_members->count() > 1) {
                        $txt_project_validation = "El numero de integrantes del proyecto del 2022 con curp " . $curps->implode(',') . ", no cumplen con un minimo del 3 integrantes originales del proyecto 2019 con curp " . $project_past_year->implode(',');
                    }
                } else {
                    if ($members->count() > 3) {
                        if ($members->count() == 4) { //El numero de integrantes del proyecto 2022 es 4, se valida que todas sean las misma que el año anterior
                            if ($members->count() == $project_past_year->count()) {
                                $not_member = $curps->diff($project_past_year);
                                if ($not_member->count() > 0) {
                                    $txt_project_validation = "La o las integrantes registradas con curp " . $not_member->implode(',') . " no pertenecen al proyecto original del 2019 con curp " . $project_past_year->implode(',');
                                }
                            } else {
                                if ($curps->count() > $project_past_year->count()) { //El numero de integrantes 2022 es mayor al 2019
                                    $txt_project_validation = "El número de integrantes con curp " . $curps->implode(',') . " supera al proyecto registrado en el 2019 con las curp " . $project_past_year->implode(',');
                                } else { //El numero de integrantes 2019 es mayor al 2022
                                    $txt_project_validation = "El número de integrantes con curp " . $project_past_year->implode(",") . " supera al proyecto registrado en 2022 con las curp " . $curps->implode(',');
                                }
                            }
                        } else {
                            $txt_project_validation = "5x00002";
                        }
                    } else {
                        if ($curps->count() == $project_past_year->count()) {
                            //Son el mismo numero de integrantes, se valida que todas sean las mismas
                            $not_member = $curps->diff($project_past_year);
                            if ($not_member->count() > 0) {
                                $txt_project_validation = "La o las integrantes registradas con curp " . $not_member->implode(',') . " no pertenecen al proyecto original del 2019 con curp " . $project_past_year->implode(',');
                            }
                        } else {
                            if ($curps->count() > $project_past_year->count()) { //El numero de integrantes 2022 es mayor al 2019
                                $txt_project_validation = "El número de integrantes con curp " . $curps->implode(',') . " supera al proyecto registrado en el 2019 con las curp " . $project_past_year->implode(',');
                            } else { //El numero de integrantes 2019 es mayor al 2022
                                $txt_project_validation = "El número de integrantes con curp " . $project_past_year->implode(",") . " supera al proyecto registrado en 2022 con las curp " . $curps->implode(',');
                            }
                        }
                    }
                }
            } else {
                //Si llega aqui es porque ninguna de las integrantes del proyecto de fortecimiento del 2022 fue beneficiada en el 2019
                $txt_project_validation = "Ninguna de la integrantes salio beneficiada en el año 2020 en la modalidad de proyectos nuevos";
            }
        } else {
            if ($members->count() > 3) {
                $txt_project_validation = $members->count() . "x0001";
            }
        }

        return array(
            'project' => array(
                'txt_project_validation' => $txt_project_validation,
                'p_is_duplicate_same_project' => $p_is_duplicate_same_project,
                'p_is_duplicate_other_projects' => $p_is_duplicate_other_projects,
                'p_is_documentation_complete' => $p_is_documentation_complete,
                'p_is_benefited_other_year' => $p_is_benefited_other_year
            ),
            'members' => $members_views,
            'municipio' => $municipio->mode()[0]
        );
    }

    public function formatCurps($curps)
    {
        $curps = $curps->keys();
        return $curps->map(function ($row) {
            return Str::upper($row);
        });
    }

    public function isMemberDocumentationComplete($member)
    {
        $documents = $member->documents;
        $slug = $member->slug;
        $is_documetation_complete = true;
        $official_id = true;
        $curp = true;
        $carta = true;
        $constancia = true;

        if ($documents->doc_official_id == 1) {
            if (!Storage::disk("public")->exists("2022/members-doc/" . $slug . "/" . $slug . "-official-id.pdf")) {
                $official_id = false;
            }
        } else {
            $official_id = false;
        }

        if ($documents->doc_curp == 1) {
            if (!Storage::disk("public")->exists("2022/members-doc/" . $slug . "/" . $slug . "-doc-curp.pdf")) {
                $curp = false;
            }
        } else {
            $curp = false;
        }
/*
        if ($documents->doc_carta == 1) {
            if (!Storage::disk("public")->exists("2022/members-doc/" . $slug . "/" . $slug . "-doc-carta.pdf")) {
                $carta = false;
            }
        } else {
            $carta = false;
        }
        if ($documents->doc_constancia == 1) {
            if (!Storage::disk("public")->exists("2022/members-doc/" . $slug . "/" . $slug . "-doc-constancia.pdf")) {
                $constancia = false;
            }
        } else {
            $constancia = false;
        }*/

        if ($official_id == false || $curp == false || $carta == false || $constancia == false) {
            $is_documetation_complete = false;
        }

        //Update documents
        $documents->doc_official_id = $official_id;
        $documents->doc_curp = $curp;
        $documents->doc_carta = $carta;
        $documents->save();

        return array(
            'official_id' => $official_id,
            'curp' => $curp,
            'domicilio' => $carta,
            'complete' => $is_documetation_complete
        );
    }

    public function isMemberBenefitedInOtherYear($curp, $official_id_clave)
    {
        //JUYY811115MDFRMS01
        //CAVO740616MMSRRL08
        $status = false;
        $txt = null;
        $curp_exist = DB::table('info_crossing_members')->where('curp', $curp)->first();
        if ($curp_exist != null) {
            $status = true;
            switch ($curp_exist->convocatoria) {
                case 1:
                    $type = "Nuevo";
                    break;
                case 2:
                    $type = "Fortalecimiento";
                    break;
                case 3:
                    $type = "Taller de costura";
                    break;

                default:
                    $type = "Not found";
                    break;
            }
            $txt = "La integrante ya fue beneficiada en el año " . $curp_exist->periodo . " con el folio " . $curp_exist->folio . " en la modalidad de proyecto " . $type;
        } else {
            /**En caso de que no se encuentre la curp podemos buscar por la clave de elector */
            $rfc_exist = DB::table('info_crossing_members')->where('clave_elector', $official_id_clave)->first();
            if ($rfc_exist != null) {
                $status = true;
                switch ($rfc_exist->convocatoria) {
                    case 1:
                        $type = "Nuevo";
                        break;
                    case 2:
                        $type = "Fortalecimiento";
                    case 3:
                        $type = "Taller de costura";

                    default:
                        $type = "Not found";
                        break;
                }
                $txt = "La integrante ya fue beneficiada en el año " . $rfc_exist->periodo . " con el folio " . $rfc_exist->folio . " en la modalidad de proyecto " . $type;
            }
        }

        return array(
            'status' => $status,
            'txt' => $txt
        );
    }

    public function isMemberDuplicateInOtherProjects($curp, $project_id)
    {
        $status = false;
        $txt = null;
        $member = Member::where(['curp' => $curp, 'web_registration' => true])->whereNotIn('project_id', [$project_id])->with(['project'])->first();
        if ($member != null) {
            $status = true;
            $txt = "La integrante esta registrada en otro proyecto con el folio " . $member->project->folio . " en la modalidad de proyecto " . (($member->project->project_type_id == 1) ? "nuevo" : "fortalecimiento");
        }

        return array(
            'status' => $status,
            'txt' => $txt
        );
    }

    public function isMemberDuplicateInSameProject($curp, $array_curps)
    {
        $status = false;
        $txt = null;

        if ($array_curps->get($curp) > 1) {
            $status = true;
            $txt = "La integrante esta repetida en el mismo proyecto";
        }

        return array(
            'status' => $status,
            'txt' => $txt
        );
    }

    public function countCurps($curps)
    {
        return $curps->groupBy('curp')->map(function ($row, $key) {
            return $row->count();
        });
    }

    public function validateNumMembers(int $id_project, int $num_member_original, int $num_real_members)
    {
        if ($num_real_members != $num_member_original) {
            Log::channel('docsmemberlog')->info('El proyecto con el id ' . $id_project . ' tiene ' . $num_real_members . ' integrantes y deberian ser ' . $num_member_original);
            return false;
        } else {
            return true;
        }
    }

    public function sendMail($project, $members, $pdf)
    {

        $data = array(
            'name' => 'Emma',
            'email' => 'dursi.sedeso@morelos.gob.mx',
            'bodyMessage' => 'saludos'
        );

        Mail::to('dursi.sedeso@morelos.gob.mx')->send(new MessageReceived($project, $members));

        /*
    $data["email"]="dursi.sedeso@morelos.gob.mx";
    $data["client_name"]="client_name";
    $data["subject"]="subject";
    
    try{
        Mail::send('mails.mail', $data, function($message)use($data,$pdf) {
        $message->to($data["email"], $data["client_name"])
        ->subject($data["subject"])
        ->attachData($pdf->output(), "invoice.pdf");
        });
    }catch(JWTException $exception){
        $this->serverstatuscode = "0";
        $this->serverstatusdes = $exception->getMessage();
    }
    if (Mail::failures()) {
         $this->statusdesc  =   "Error sending mail";
         $this->statuscode  =   "0";

    }else{

       $this->statusdesc  =   "Message sent Succesfully";
       $this->statuscode  =   "1";
    }
    return response()->json(compact('this'));
*/
        /*
        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('dursi.sedeso@morelos.gob.mx');
        });

*/
        return 'mensaje enviado';
    }

    public function getConocimiento(Request $request)
    {
        $idEstandar=$request->idEstandar;       
        return CatConocimiento::where("cat_estandar_id", $idEstandar)->orderBy("id")->get(["id", "conocimiento"]);
    }


}
