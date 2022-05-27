@extends('admin.template.admin')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-12">
            <div class="title">
                <h4>
                    {{Str::upper($member->fullName)}}
                    <br>Folio : MH10-2022-{{$member->project->zeroFolio}}
                </h4>
            </div>
        </div>
    </div>
</div>
<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
    <h6>Impresión de documentos</h6>
    <hr>
    <a href="{{route('admin.2022.project.pdf',['type_project' => $member->project->type->name,'slug' => $member->project->slug])}}"
        target="_blank" class="btn btn-success btn-sm" href=""><i class="fa fa-file-text-o" aria-hidden="true"></i>
        Acuse de registro</a>
    @if ($member->project->status === 1)
    <a href="{{route('admin.2022.project.convenio',['slug' => $member->project->slug])}}" target="_blank"
        class="btn btn-dark btn-sm"><i class="fa fa-file-text-o" aria-hidden="true"></i> Convenio</a>
    @endif
</div>
<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
    <h6>Editar información</h6>
    <hr>
    <form id="update-member" action="{{route('admin.2022.member.update',['slug' => $member->slug])}}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-3 required">
                <label class="control-label" for="name">Nombre(s)</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$member->name}}">
            </div>
            <div class="form-group col-md-3 required">
                <label class="control-label" for="p_surname">Apellido paterno</label>
                <input type="text" name="p_surname" id="p_surname" class="form-control"
                    value="{{$member->father_surname}}">
            </div>
            <div class="form-group col-md-3 required">
                <label class="control-label" for="m_surname">Apellido materno</label>
                <input type="text" name="m_surname" id="m_surname" class="form-control"
                    value="{{$member->mother_surname}}">
            </div>
            <div class="form-group col-md-3 required">
                <label class="control-label" for="elector-id">Clave de elector</label>
                <input type="text" name="elector-id" id="elector-id" class="form-control"
                    value="{{$member->official_id_clave}}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3 required">
                <label class="control-label" for="curp">CURP</label>
                <input type="text" name="curp" id="curp" class="form-control" value="{{$member->curp}}">
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-3 required">
                <label class="control-label" for="street-name">Calle</label>
                <input type="text" name="street-name" id="street-name" class="form-control" value="{{$member->street}}">
            </div>
            <div class="form-group col-md-3 required">
                <label class="control-label" for="exterior-street-number">Número exterior</label>
                <input type="text" name="exterior-street-number" id="exterior-street-number" class="form-control"
                    value="{{$member->exterior_number}}">
            </div>
            <div class="form-group col-md-3">
                <label class="control-label" for="interior-street-number">Número interior</label>
                <input type="text" name="interior-street-number" id="interior-street-number" class="form-control"
                    value="{{$member->interior_number}}">
            </div>
            <div class="form-group col-md-3 required">
                <label class="control-label" for="postal-code">Código postal</label>
                <input type="text" name="postal-code" id="postal-code" class="form-control"
                    value="{{$member->postal_code}}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3 required">
                <label class="control-label" for="municipio-name">Municipio</label>
                <select name="municipio-zap" id="municipio-zap" class="form-control">
                    <option value="">Selecciona una opción</option>
                    @foreach ($municipios as $municipio)
                    @if ($municipio->id==$member->cat_municipio_id)
                    <option zap-code="{{$municipio->clave_numero}}" value="{{$municipio->id}}" selected>
                        {{$municipio->municipio}}</option>
                    @else
                    <option zap-code="{{$municipio->clave_numero}}" value="{{$municipio->id}}">{{$municipio->municipio}}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3 required">            
                <label class="control-label" for="loc_col">Localidad o Colonia</label>
                <input type="text" name="loc_col" id="loc_col" class="form-control" value="{{$member->colonia}}">
            </div>
            <div class="form-group col-md-3 required">
                <label class="control-label" for="tipo_vialidad">Selecciona el tipo de vialidad</label>
                <select name="tipo_vialidad" id="tipo_vialidad" class="form-control">
                    <option value="">Selecciona una opción</option>
                    @foreach ($zona_zap['vialidades'] as $vialidad)                  
                    @if ($vialidad->id===$member->cat_tipo_vialidad_id)
                    <option value="{{$vialidad->id}}" selected>{{$vialidad->descripcion}}</option>
                    @else
                    <option value="{{$vialidad->id}}">{{$vialidad->descripcion}}</option>
                    @endif       
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3 required">
                <label class="control-label" for="tipo_asentamiento">Selecciona el tipo de asentamiento</label>
                <select name="tipo_asentamiento" id="tipo_asentamiento" class="form-control">
                    <option value="">Selecciona una opción</option>
                    @foreach ($zona_zap['asentamientos'] as $asentamiento)
                    @if ($asentamiento->id==$member->cat_tipo_asentamiento_id)
                    <option value="{{$asentamiento->id}}" selected>{{$asentamiento->descripcion}}</option> 
                    @else
                    <option value="{{$asentamiento->id}}">{{$asentamiento->descripcion}}</option> 
                    @endif                    
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="form-group col">
                <label for="project-description">Domicilio idéntico a como esta descrito en tu INE o IFE</label>
                <textarea class="form-control" name="domicilioINE" id="domicilioINE" cols="30"
                    rows="10" style="height:60px">{{$member->domicilioINE}}</textarea>
            </div>
        </div>  

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success">Guardar información</button>
                <a class="btn btn-danger"
                    href="{{route('admin.2022.show',['slug' => $member->project->slug])}}">Cancelar</a>
            </div>
        </div>
    </form>
</div>
<br>
@endsection

@section('script')

<script>
    const e_projectType = document.getElementById("type-project");
        e_projectType.value = {{$member->project->type->id}};
        const e_folio = document.getElementById("folio-search");
        e_folio.value = {{$member->project->folio}};


        //const e_municipio_is_ind = document.getElementById("municipio_is_ind");
        const e_municipio_ind = document.getElementById("municipio-ind");
        const c_specify_municipio = document.getElementById("c-specify-municipio");

        /*e_municipio_is_ind.addEventListener("change",function(event){
            c_specify_municipio.classList.remove("d-none");
            let has_value = event.target.value;
            if(has_value == 1){
                c_specify_municipio.style.display = ""
            }else{
                c_specify_municipio.style.display = "none";
                e_municipio_ind.value = "";
            }
        });*/
</script>

@if ($member->cat_municipio_id != null)
<script>
    const municipio_id = {{$member->cat_municipio_id}};
            //const localidad_id = {{$member->cat_localidad_id}};
            //const colonia_id = {{$member->cat_colonia_id}};
            const s_municipio = document.getElementById('municipio-zap');
            const s_localidad = document.getElementById('localidad-zap');
            const s_colonia = document.getElementById('colonia-zap');
            s_municipio.value = municipio_id;
            //s_localidad.value = localidad_id;
            //s_colonia.value = colonia_id;
</script>
@endif
<script src="{{asset('js/member/zap.js')}}"></script>
<script src="{{asset('admin/js/member/update.js')}}"></script>
@endsection