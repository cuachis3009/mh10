@extends('admin.template.admin')

@section('content')
    <project-basic-info 
        :project-type="{{$project->project_type_id}}" 
        folio="{{$project->zeroFolio}}" 
        :project-status="{{$project->status}}"
        type-string="{{Str::ucfirst($project->type->name)}}"       
    ></project-basic-info>
    <div class="row">
        <div class="col-md-6">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <h6>Comprobación</h6>
                <hr>
                @if (in_array($project->status,[1,3]))
                    <div class="row">
                        <div class="col">Monto aprobado <br> <span class="font-weight-bold">$ {{number_format($project->amount_approved,2,'.',',')}}</span> </div>
                        <div class="col">
                            Monto comprobado <br>
                            @if (count($project->comprobation) > 0)
                                <span class="font-weight-bold">
                                    $ {{number_format($project->comprobation->sum('amount'),2,'.',',')}}
                                </span>
                            @else
                                <span class="font-weight-bold">$ 0.00</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <a class="btn btn-warning btn-block" href="{{route('admin.2022.comprobation.project',['slug' => $project->slug])}}">Ver comprobación</a>
                        </div>
                    </div>
                @else
                    <p>Comprobación no disponible</p>
                @endif
                
                <!--<h6>Datos bancarios</h6>
                <hr>
                <form id="form-bank-details" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="">Integrante designada</label>
                            <select name="card-bank-owner" id="card-bank-owner" class="form-control">
                                @if ($project->bank_card_number == null)
                                    <option value="">Selecciona una opción</option>
                                @endif
                                @foreach ($project->members as $member)
                                    <option value="{{$member->id}}">{{$member->fullName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="card-number">Número de tarjeta</label>
                            <input type="text" class="form-control" name="card-number" id="card-number" value="{{$project->bank_card_number}}" placeholder="0000 0000 0000 0000">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-info mt-2">Guardar datos bancarios</button>
                        </div>
                    </div>
                </form>-->
            </div>
        </div>
        <div class="col-md-6">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <h6>Impresión de documentos</h6>
                <hr>
                <a href="{{route('admin.2022.project.pdf',['type_project' => $project->type->name,'slug' => $project->slug])}}" target="_blank" class="btn btn-success btn-sm" href=""><i class="fa fa-file-text-o" aria-hidden="true"></i> Acuse de registro</a>
                @if (in_array($project->status,array(1,3)))
                    <a href="{{route('admin.2022.project.convenio',['slug' => $project->slug])}}" target="_blank" class="btn btn-dark btn-sm"><i class="fa fa-file-text-o" aria-hidden="true"></i> Convenio</a>
                @endif
                @if (in_array($project->status,array(1,3)))
                <a href="{{route('admin.2022.project.tarjeta',['slug' => $project->slug])}}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-file-text-o" aria-hidden="true"></i> Tarjeta</a>
                @endif
                @if (in_array($project->status,array(1,3)))
                <a href="{{route('admin.2022.project.carta',['slug' => $project->slug])}}" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-file-text-o" aria-hidden="true"></i> Carta</a>
                @endif
                <!--<button id="download-all-docs" data-project="{{$project->slug}}" type="btn" class="btn btn-info btn-sm"><i class="fa fa-file-text-o" aria-hidden="true"></i> Descargar toda la documentación</button>-->
            </div>
        </div>
    </div>
    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
        <h6>Información del estandar</h6>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Estandar</label>
                    <textarea class="form-control" style="height:100px" disabled>{{$project->estandar->estandar}}</textarea>                   
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Proceso</label>
                    <textarea class="form-control" style="height:100px" disabled>{{$project->estandar->proceso}}</textarea>                   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Sede</label>
                    <textarea class="form-control" style="height:100px" disabled>{{$project->estandar->sede}}</textarea>                   
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Domicilio</label>
                    <textarea class="form-control" style="height:100px" disabled>{{$project->estandar->domicilio}}</textarea>                   
                </div>
            </div>
        </div>
        <div class="row">  
            <div class="col-md-6">
                <div class="form-group">
                    <label>Objetivo de obtener la certificación del Estándar de Competencia</label>
                    <textarea class="form-control" style="height:100px" disabled>{{$project->objective}}</textarea>
                </div>
            </div>     
            <div class="col-md-6">
                <div class="form-group">
                    <label>Describa las actividades que usted realizará con la Certificación y entrega del apoyo económico</label>
                    <textarea class="form-control" style="height:100px" disabled>{{$project->project_description}}</textarea>
                </div>
            </div>           
        </div>
        <div class="row">

        </div>
    </div>
    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
        <h6>Integrantes</h6>
        <hr>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre completo</th>
                    <th>Clave INE/IFE</th>
                    <th>CURP</th>
                    <th>Documentos</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $owner = 0;
                @endphp
                @foreach ($project->members as $member)
                    @php
                        if($member->card_bank_owner == 1){
                            $owner = $member->id;
                        }
                    @endphp
                    <tr>
                        <td>{{$member->fullName}}</td>
                        <td>{{Str::upper($member->official_id_clave)}}</td>
                        <td>{{Str::upper($member->curp)}}</td>
                        <td>   
                            @php
                                $url_ine = "2022/members-doc/".$member->slug."/".$member->slug."-official-id.pdf";
                            @endphp    
                            
                            @if (Storage::disk("public")->exists("2022/members-doc/".$member->slug."/".$member->slug."-doc-carta.pdf"))
                                <a target="_blank" href="{{Storage::url("2022/members-doc/".$member->slug."/".$member->slug."-doc-carta.pdf")}}" class="btn btn-warning btn-sm mb-2" href="">CARTA</a><br>                                                   
                            @endif                     
                            @if (Storage::disk("public")->exists($url_ine))
                                <a target="_blank" href="{{Storage::url("2022/members-doc/".$member->slug."/".$member->slug."-official-id.pdf")}}" class="btn btn-primary btn-sm mb-2" href="">INE/IFE</a>
                            @endif
                            @if (Storage::disk("public")->exists("2022/members-doc/".$member->slug."/".$member->slug."-doc-curp.pdf"))
                                <a target="_blank" href="{{Storage::url("2022/members-doc/".$member->slug."/".$member->slug."-doc-curp.pdf")}}" class="btn btn-info btn-sm mb-2" href="">CURP</a><br>
                            @endif
                            @if (Storage::disk("public")->exists("2022/members-doc/".$member->slug."/".$member->slug."-doc-constancia.pdf"))
                                <a target="_blank" href="{{Storage::url("2022/members-doc/".$member->slug."/".$member->slug."-doc-constancia.pdf")}}" class="btn btn-secondary btn-sm mb-2" href="">CONSTANCIA</a><br>
                            @endif

                        </td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{route('admin.2022.member.edit',['slug' => $member->slug])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')

    <script>
        const e_projectType = document.getElementById("type-project");
        e_projectType.value = {{$project->type->id}};
        const e_folio = document.getElementById("folio-search");
        e_folio.value = {{$project->folio}};

        const form_bank_details = document.getElementById("form-bank-details");

        /*Preseleccionamos la integrante designada*/
        const member_owner_card = document.getElementById('card-bank-owner');
        const owner = {{$owner}};
        if(owner > 0){
            member_owner_card.value = owner;
        }

        /*form_bank_details.addEventListener("submit",function(e){
            e.preventDefault();
            saveBankDetails();
        });*/

        function saveBankDetails(){

            Swal.fire({
                title: 'Advertencia',
                text: "¿La información ingresada es correcta?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No, revisar'
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: "Espera",
                        html: "Se esta guardando la información de los datos bancarios",// add html attribute if you want or remove
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    let form = new FormData($("#form-bank-details")[0]);

                    axios({
                        method: "POST",
                        url: '{{route("admin.2022.project.bank-details",["slug" => $project->slug])}}',
                        data : form,
                        responseType: 'json'
                    })
                    .then(function (response) {
                        if(response.data.res){
                            Swal.fire({
                                title: "Bien",
                                html: "Se ha guardado los datos bancarios correctamente, espera...",
                                allowOutsideClick: false,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            });
                
                            setTimeout(function(){
                                location.reload();
                            },3000);
                        }
                    })
                    .catch(function (error) {
                        console.log(error.response);
                        if(error.response.status == 422){
                            /**Hay un error en la validacion de los datos */
                            Swal.fire({
                                icon : "warning",
                                title: "Atención",
                                html: "Por favor verifica que has seleccionado a la integrante designada y el numero de tarjeta se encuentra en el formato correcto",
                                allowOutsideClick: false,
                            });
                        }else{
                            Swal.fire({
                                icon : "error",
                                title: "Error",
                                html: "Ha ocurrido un error al guardar los datos bancarios, intentalo más tarde",
                            });
                        }
                    });
                }
            })

        }

    </script>
@endsection