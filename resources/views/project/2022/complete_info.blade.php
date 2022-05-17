@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <form id="complete-project" method="POST" action="{{route($project->period->year.".project.finish",["type_project"=> $project->type->name,"slug" => $project->slug])}}">
            @csrf
            <div class="card-header">
                <h4>Ingresa la información del curso</h4>
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
                    <div class="form-group col-md-4">
                        <label class="control-label" for="tipo_curso">Curso (Principal)</label>
                        <select name="tipo_curso" id="tipo_curso" class="form-control">
                            <option value="">Selecciona una opción</option>
                            @foreach ($cursos as $curso)
                            <option value="{{$curso->id}}" >
                                {{$curso->curso}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 required">
                        <label class="control-label" for="municipio_sede">Selecciona el municipio</label>
                        <select name="municipio_sede" id="municipio_sede" class="form-control">
                            <option value="">Selecciona una opción</option>
                        </select>
                    </div>      
                    <div class="form-group col-md-6">
                        <label>Domicilio</label>
                        <textarea class="form-control"  name="estandar-domicilio" id="estandar-domicilio" cols="30"
                        rows="10" style="height:60px"  readonly=true></textarea>                        
                    </div>                                    
                </div>
    
                <hr>


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
    const e_tipo_curso = document.getElementById("tipo_curso");
    const e_municipio_sede = document.getElementById("municipio_sede");
    //const estandar_sede = document.getElementById("estandar-sede");
    //const estandar_domicilio = document.getElementById("estandar-domicilio");

    e_tipo_curso.addEventListener("change",function(event){            
        let has_value = event.target.value; 
        loadSedes(has_value);        
    });  
    e_municipio_sede.addEventListener("change",function(event){            
        console.log(event.target.domicilio);
        let has_value = event.target.value; 
          
    });

    function loadSedes(idCurso){
        municipio_sede.innerHTML = "";
        /*var opt = document.createElement('option');
        opt.value = "";
        opt.innerHTML = "Selecciona una opción";
        municipio_sede.appendChild(opt);*/
        var items='<option value=" "  domicilio=" ">Selecciona una opción</option>';
    /**Realizamos la llamada por axios */
    axios.post('/2022/project/nuevo/getSede', {
        idCurso: idCurso
    }).then(function (response) {     
        response.data.forEach(function(item, i){          
        var opt = document.createElement('option');
        /*opt.value = item["id"];        
        opt.innerHTML = item["municipio"];
        municipio_sede.appendChild(opt);*/

        items=items + '<option value="' + item["id"] + '" domicilio="'+ item["domicilio"] + '">' + item["municipio"] + '</option>';

            //var description = document.createTextNode(item["conocimiento"]);
            /*var description = document.createElement("label");
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
            */    
    });
    municipio_sede.innerHTML = items;
        console.log(response.data);       
    }).catch(function (error) {
        console.log(error);
    });
}


</script>
<script src="{{ asset('js/project/2022/create.js') }}"></script>

@endsection