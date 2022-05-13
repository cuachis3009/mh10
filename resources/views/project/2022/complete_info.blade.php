@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <form id="complete-project" method="POST" action="{{route($project->period->year.".project.finish",["type_project"=> $project->type->name,"slug" => $project->slug])}}">
            @csrf
            <div class="card-header">
                <h4>Ingresa la información del estándar de competencia</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label class="control-label" for="tipo_estandar">Estándar de competencia</label>
                        <select name="tipo_estandar" id="tipo_estandar" class="form-control">
                            <option value="">Selecciona una opción</option>
                            @foreach ($Estandares as $estandar)
                            <option value="{{$estandar->id}}" process="{{$estandar->proceso}}" 
                                sede="{{$estandar->sede}}" domicilio="{{$estandar->domicilio}}" >
                                {{$estandar->estandar}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tipo de proceso</label>                
                            <textarea class="form-control"  name="estandar-process" id="estandar-process" cols="30"
                            rows="10" style="height:75px"  readonly=true></textarea>

                    </div>
                </div>
                <div class="form-row">
                   
                    <div class="form-group col-md-8">
                        <br><label>Domicilio</label>
                        <textarea class="form-control"  name="estandar-domicilio" id="estandar-domicilio" cols="30"
                        rows="10" style="height:60px"  readonly=true></textarea>
                        
                    </div>
                    <div class="form-group col-md-4">
                        <br><label>Sede</label>
                        <input type="text" name="estandar-sede" id="estandar-sede" class="form-control" readonly=true>
                    </div>
                   
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label>Conocimientos de competencias laborales</label>
                        <div id="chkList" class="form-check" ></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="project-experience-time">Tiempo de experiencia básica en el Estándar que
                            solicita</label>
                        <input type="text" name="project-experience-time" id="project-experience-time"
                            class="form-control" placeholder="Ejem. 1 año">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col">
                        <label for="project-objective">Objetivo de obtener la certificación del Estándar de
                            Competencia</label>
                        <textarea class="form-control" name="project-objective" id="project-objective" cols="30"
                            rows="10" style="height:60px"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="project-activity-description">Describa las actividades que usted realizará con la
                            Certificación y entrega del apoyo económico </label>
                        <textarea class="form-control" name="project-activity-description"
                            id="project-activity-description" cols="30" style="height:60px"></textarea>
                    </div>                  
                </div>
                <div class="form-row">
                    <div class="form-group col required">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="read-CDE" value="1" id="read-CDE">
                            <label class="form-check-label" for="read-CDE">
                                Confirmo que me encuentro desempleada o desempleado.
                            </label>
                        </div>
                    </div>
                 
                </div>
                <div class="form-row">
                    <div class="form-group col required">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="read-CCB" value="1" id="read-CCB">
                            <label class="form-check-label" for="read-CCB">
                                Confirmo que cuento con los conocimientos básicos, habilidades y destrezas del Estándar de Competencia
                            </label>
                        </div>
                    </div>
                    
                </div>
    
                <hr>
                <h4>Programación del apoyo económico</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div id="item-ids"></div>
                            <table class="table table-striped table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th>Descripción del componente</th>
                                        <th>Unidad de medida</th>
                                        <th>Cantidad requerida</th>
                                        <th>Costo unitario</th>
                                        <th>Costo total</th>
                                    </tr>
                                </thead>
                                <tbody class="items-project-container"></tbody>
                                <tfoot class="thead-light">
                                    <tr>
                                        <th colspan="4"></th>
                                        <th style="text-align: right;">Total</th>
                                        <th style="text-align: left;">$ <label id="totalGeneral">0</label></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <caption><button type="button" id="add-item-project" class="btn btn-sedeso">Agregar
                                componente</button></caption>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    const e_tipo_estandar = document.getElementById("tipo_estandar");
    const estandar_process = document.getElementById("estandar-process");
    const estandar_sede = document.getElementById("estandar-sede");
    const estandar_domicilio = document.getElementById("estandar-domicilio");

    e_tipo_estandar.addEventListener("change",function(event){            
        let has_value = event.target.value;
        let has_process = this.options[this.selectedIndex].getAttribute('process');
        let has_sede = this.options[this.selectedIndex].getAttribute('sede');
        let has_domicilio = this.options[this.selectedIndex].getAttribute('domicilio');
        estandar_process.value=has_process;
        estandar_sede.value=has_sede;
        estandar_domicilio.value=has_domicilio;        
        loadConocimientos(has_value);
        
    });  
    
    function loadConocimientos(idEstandar){
        var div_chkList= document.getElementById("chkList");
            div_chkList.innerHTML = '';
        //console.log(idEstandar);
    /**Realizamos la llamada por axios */
    axios.post('/2022/project/nuevo/getConocimiento', {
        idEstandar: idEstandar
    }).then(function (response) {
     
        response.data.forEach(function(item, i){
          
            //var description = document.createTextNode(item["conocimiento"]);
            var description = document.createElement("label");
            description.innerHTML=item["conocimiento"];
            description.classList.add("form-check-label");            
            var checkbox = document.createElement("input");
            checkbox.classList.add("form-check-input");          
            var linebreak = document.createElement("br");

            checkbox.type = "checkbox";    // make the element a checkbox
            checkbox.name = "chkList[]";      // give it a name we can check on the server side
            checkbox.value = item["id"];         // make its value "pair"
            div_chkList.appendChild(checkbox);   // add the box to the element
            div_chkList.appendChild(description);
            div_chkList.appendChild(linebreak);
        /*
        let opt = document.createElement("option");
        opt.appendChild( document.createTextNode(item["loc_col"]));      
        opt.value = item["id"];
        element.appendChild(opt);*/
        //console.log(item["conocimiento"]);
    });


        //console.log(response.data);
       
    }).catch(function (error) {
        console.log(error);
    });
}


</script>
<script src="{{ asset('js/project/2022/create.js') }}"></script>
<script src="{{ asset('js/project/2022/add-item-project.js') }}"></script>

@endsection