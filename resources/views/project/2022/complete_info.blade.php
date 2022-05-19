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
                            <option value="0">Selecciona una opción</option>
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
                        <label>Domicilio SEDE</label>
                        <textarea class="form-control"  name="sede_domicilio" id="sede_domicilio" cols="30"
                        rows="10" style="height:60px"  readonly=true></textarea>                        
                    </div>                                    
                </div>  
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="tipo_curso_s">Curso (Segunda opción)</label>
                        <select name="tipo_curso_s" id="tipo_curso_s" class="form-control" disabled>
                            <option value="0">Selecciona una opción</option>
                            @foreach ($cursos as $curso)
                            <option value="{{$curso->id}}">
                                {{$curso->curso}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 required">
                        <label class="control-label" for="municipio_sede_s">Selecciona el municipio</label>
                        <select name="municipio_sede_s" id="municipio_sede_s" class="form-control" disabled>
                            <option value="">Selecciona una opción</option>
                        </select>
                    </div>      
                    <div class="form-group col-md-6">
                        <label>Domicilio SEDE</label>
                        <textarea class="form-control"  name="sede_domicilio_s" id="sede_domicilio_s" cols="30"
                        rows="10" style="height:60px"  readonly=true></textarea>                        
                    </div>                                    
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="control-label" for="tipo_curso_t">Curso (Tercera opción)</label>
                        <select name="tipo_curso_t" id="tipo_curso_t" class="form-control" disabled>
                            <option value="0">Selecciona una opción</option>
                            @foreach ($cursos as $curso)
                            <option value="{{$curso->id}}" >
                                {{$curso->curso}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 required">
                        <label class="control-label" for="municipio_sede_t">Selecciona el municipio</label>
                        <select name="municipio_sede_t" id="municipio_sede_t" class="form-control" disabled>
                            <option value="">Selecciona una opción</option>
                        </select>
                    </div>      
                    <div class="form-group col-md-6">
                        <label>Domicilio SEDE</label>
                        <textarea class="form-control"  name="sede_domicilio_t" id="sede_domicilio_t" cols="30"
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
    const e_tipo_curso_s = document.getElementById("tipo_curso_s");
    const e_tipo_curso_t = document.getElementById("tipo_curso_t");
    const e_municipio_sede = document.getElementById("municipio_sede");
    const e_municipio_sede_s = document.getElementById("municipio_sede_s");
    const e_municipio_sede_t = document.getElementById("municipio_sede_t");
    const sede_domicilio = document.getElementById("sede_domicilio");
    const sede_domicilio_s = document.getElementById("sede_domicilio_s");
    const sede_domicilio_t = document.getElementById("sede_domicilio_t");
    var index =0;
    var index_s =0;
    //const estandar_domicilio = document.getElementById("estandar-domicilio");

    e_tipo_curso.addEventListener("change",function(event){      
        let has_value = event.target.value; 
        loadSedes(has_value,1);  
        sede_domicilio.innerHTML = '';    
        
        if(this.selectedIndex!="0"){
            e_tipo_curso_s.options[this.selectedIndex].disabled=true;
            e_tipo_curso_s.disabled=false;
            e_municipio_sede_s.disabled=false;
            
            e_tipo_curso_t.options[this.selectedIndex].disabled=true;
        }
        else{
            e_tipo_curso_s.disabled=true;
            e_municipio_sede_s.disabled=true;          
        }
        e_tipo_curso_s.options[index].disabled=false;
        e_tipo_curso_t.options[index].disabled=false;
        e_tipo_curso_s.selectedIndex=0;
        e_tipo_curso_t.selectedIndex=0;
        e_tipo_curso_t.disabled=true;
        e_municipio_sede_t.disabled=true;
        sede_domicilio_s.innerHTML = '';  
        sede_domicilio_t.innerHTML = '';  
        index =this.selectedIndex;
        });  

    e_tipo_curso_s.addEventListener("change",function(event){ 
        let has_value = event.target.value; 
        loadSedes(has_value,2);  
        sede_domicilio_s.innerHTML = '';    
        
        if(this.selectedIndex!="0"){            
            e_tipo_curso_t.options[this.selectedIndex].disabled=true;
            e_tipo_curso_t.disabled=false;
            e_municipio_sede_t.disabled=false;
        }    
        else{
            e_tipo_curso_t.disabled=true;
            e_municipio_sede_t.disabled=true;
        }
        e_tipo_curso_t.options[index_s].disabled=false;       
        e_tipo_curso_t.selectedIndex=0;
        e_municipio_sede_t.selectedIndex=0;
        sede_domicilio_t.innerHTML = '';  
        loadSedes(0,3)
        index_s =this.selectedIndex;
        });  
        
        e_tipo_curso_t.addEventListener("change",function(event){ 
        let has_value = event.target.value; 
        loadSedes(has_value,3);  
        sede_domicilio_t.innerHTML = '';    
        }); 


    e_municipio_sede.addEventListener("change",function(event){            
        //console.log(this.options[this.selectedIndex].getAttribute('domicilio'));
        sede_domicilio.innerHTML = this.options[this.selectedIndex].getAttribute('domicilio');        
        });
        e_municipio_sede_s.addEventListener("change",function(event){            
        sede_domicilio_s.innerHTML = this.options[this.selectedIndex].getAttribute('domicilio');        
        });
        e_municipio_sede_t.addEventListener("change",function(event){                    
        sede_domicilio_t.innerHTML = this.options[this.selectedIndex].getAttribute('domicilio');        
        });

    function loadSedes(idCurso,n_curso){
      
        /*var opt = document.createElement('option');
        opt.value = "";
        opt.innerHTML = "Selecciona una opción";
        municipio_sede.appendChild(opt);*/
        var items='<option value=""  domicilio="">Selecciona una opción</option>';
    /**Realizamos la llamada por axios */
    axios.post('/2022/project/nuevo/getSede', {
        idCurso: idCurso
    }).then(function (response) {     
        response.data.forEach(function(item, i){   
        items=items + '<option value="' + item["id"] + '" domicilio="'+ item["domicilio"] + '">' + item["municipio"] + '</option>';           
    });
    if(n_curso==1){
        municipio_sede.innerHTML = "";
        municipio_sede.innerHTML = items;
    }else if(n_curso==2){
        municipio_sede_s.innerHTML = "";
        municipio_sede_s.innerHTML = items;
    }else if(n_curso==3){
        municipio_sede_t.innerHTML = "";
        municipio_sede_t.innerHTML = items;
    }    
     //   console.log(response.data);       
    }).catch(function (error) {
        console.log(error);
    });
}


</script>
<script src="{{ asset('js/project/2022/create.js') }}"></script>

@endsection