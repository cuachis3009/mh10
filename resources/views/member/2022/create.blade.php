@extends('layouts.app')

@section('content')
<div class="container">
    <form id="create-member"
        action="{{route($project->period->year.".member.store",["type_project" => $project->type->name,"slug" => $project->slug])}}"
        method="POST" enctype="multipart/form-data">
        <input type="hidden" name="p-slug" id="p-slug" value="{{$project->slug}}">
        @csrf
        <div class="card">
            <div class="card-header">
                <small><strong>Todos los campos marcados con un <span style="color:red">*</span> son
                        obligatorios y deberán corresponder a la persona titular </strong></small>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="txt-curp">Ingresa tu curp</label>
                        <input type="text" maxlength="18" name="txt-curp" id="txt-curp" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <button type="button" id="btn-validate-curp" class="btn btn-sedeso">Validar curp</button>
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="elector-id">Clave de elector</label>
                        <input type="text" maxlength="18" name="elector-id" id="elector-id" class="form-control">
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="year-id-validity">Año de vigencia INE ó IFE</label>
                        <select name="year-id-validity" id="year-id-validity" class="form-control">
                            <option value="">Selecciona una opción</option>
                            @foreach ($yearsValidaty as $yearValidaty)
                            <option value="{{$yearValidaty}}">{{$yearValidaty}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="name">Nombre(s)</label>
                        <input type="text" name="name" id="name" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="p_surname">Apellido paterno</label>
                        <input type="text" name="p_surname" id="p_surname" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="m_surname">Apellido materno</label>
                        <input type="text" name="m_surname" id="m_surname" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-3 required">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="read-CN" value="1" id="read-CN">
                            <label class="form-check-label" for="check-CN">
                                Confirmo que mi nombre completo esta correcto
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="cellphone-number">Teléfono celular</label>
                        <input type="text" maxlength="10" name="cellphone-number" id="cellphone-number"
                            class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="home-phone">Teléfono de casa</label>
                        <input type="text" maxlength="10" name="home-phone" id="home-phone" class="form-control">
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="email">Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="member-sex">Sexo</label>
                        <select name="member-sex" id="member-sex" class="form-control">
                            <option value="">Selecciona una opción</option>
                            <option value="1">Mujer</option>
                            <option value="2">Hombre</option>
                        </select>
                    </div>

                </div>
                <div class="form-row">

                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="member_age">Edad</label>
                        <input type="number" name="member_age" min="1" maxlength="2"  id="member_age" class="form-control">
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="study_member">Nivel máximo de estudios cursados</label>
                        <select name="study_member" id="study_member" class="form-control">
                            <option value="">Selecciona una opción</option>
                            <option value="1">Primaria</option>
                            <option value="2">Secundaria</option>
                            <option value="3">Preparatoria</option>
                            <option value="4">Carrera técnica</option>
                            <option value="5">Licenciatura</option>
                        </select>
                    </div>   
                    <!--div class="form-group col-md-3 required">
                        <label class="control-label" for="member-rfc">RFC con homoclave (13 dígitos)</label>
                        <input type="text" name="member-rfc" id="member-rfc" class="form-control">
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="member-status_rfc">Estado del RFC</label>
                        <select name="member-status_rfc" id="member-status_rfc" class="form-control">
                            <option value="">Selecciona una opción</option>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                            <option value="3">Reactivado</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="member-discharge_date_rfc">Fecha de alta en el SAT</label>
                        <input type="date" name="member-discharge_date_rfc" id="member-discharge_date_rfc"
                            class="form-control">
                    </div-->
                </div>
               
                <hr>
                <h3>Dirección</h3>
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">¡Importante!</h4>
                    <p>Es importate que los datos ingresados en esta sección sean identicos a los de tu INE ó IFE vigente</p>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="street-name">Calle</label>
                        <input type="text" name="street-name" id="street-name" class="form-control">
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="exterior-street-number">Número exterior</label>
                        <input type="text" name="exterior-street-number" id="exterior-street-number"
                            class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label" for="interior-street-number">Número interior</label>
                        <input type="text" name="interior-street-number" id="interior-street-number"
                            class="form-control">
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="postal-code">Código postal</label>
                        <input type="text" maxlength="5" name="postal-code" id="postal-code" class="form-control">
                    </div>
                    <!--div class="form-group col-md-3 required">
                        <label class="control-label" for="colony-name">Colonia</label>
                        <input type="text" name="colony-name" id="colony-name" class="form-control">
                    </div-->
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="municipio-zap">Selecciona el municipio</label>
                        <select name="municipio-zap" id="municipio-zap" class="form-control">
                            <option value="">Selecciona una opción</option>
                            @foreach ($municipios as $municipio)
                            <option zap-code="{{$municipio->clave_numero}}" value="{{$municipio->id}}">
                                {{$municipio->municipio}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="loc_col-zap">Selecciona la localidad o colonia</label>
                        <select name="loc_col-zap" id="loc_col-zap" class="form-control"></select>
                    </div>         
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="tipo_vialidad">Selecciona el tipo de vialidad</label>
                        <select name="tipo_vialidad" id="tipo_vialidad" class="form-control">
                            <option value="">Selecciona una opción</option>
                            @foreach ($vialidades as $vialidad)
                            <option value="{{$vialidad->id}}">{{$vialidad->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3 required">
                        <label class="control-label" for="tipo_asentamiento">Selecciona el tipo de asentamiento</label>
                        <select name="tipo_asentamiento" id="tipo_asentamiento" class="form-control">
                            <option value="">Selecciona una opción</option>
                            @foreach ($asentamientos as $asentamiento)
                            <option value="{{$asentamiento->id}}">{{$asentamiento->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div> 
                <div class="form-row">
                    <div class="form-group col">
                        <label for="project-description">Referencias del domicilio (Información que facilite identificar la vivienda y ubicación de ésta)</label>
                        <textarea class="form-control" name="referencia_domicilio" id="referencia_domicilio" cols="30"
                            rows="10" style="height:60px"></textarea>
                    </div>
                </div>
               
              
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <hr>
          
                <div class="member-documents">
                    <h3>Documentos (archivos electrónicos en formato PDF)</h3>
                    <div class="form-row">
                        <!--div class="form-group col-md-4">
                            <label class="control-label" for="">Carta Bajo Protesta de Decir Verdad</label>
                            <input type="file" class="form-control-file" name="doc-carta" id="doc-carta">
                        </div-->
                        <div class="form-group col-md-4">
                            <label for="">Identificación Oficial (INE/IFE)</label>
                            <input type="file" class="form-control-file" name="doc-official-id" id="doc-official-id">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Clave Única de Registro de Población (CURP)</label>
                            <input type="file" class="form-control-file" name="doc-curp" id="doc-curp">
                        </div>
                        <!--div class="form-group col-md-3">
                            <label for="">Constancia de situación fiscal</label>
                            <input type="file" class="form-control-file" name="doc-constancia" id="doc-constancia">
                        </div-->
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Guardar información</button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
<script>

        

        const e_municipio_is_ind = document.getElementById("municipio_is_ind");
        const e_municipio_ind = document.getElementById("municipio-ind");
        const c_specify_municipio = document.getElementById("c-specify-municipio");

        e_municipio_is_ind.addEventListener("change",function(event){
            c_specify_municipio.classList.remove("d-none");
            let has_value = event.target.value;
            if(has_value == 1){
                c_specify_municipio.style.display = ""
            }else{
                c_specify_municipio.style.display = "none";
                e_municipio_ind.value = "";
            }
        });
          var relationship = JSON.parse('{!! $relationship->toJson() !!}');

</script>

<script src="{{ asset('js/member/validate-curp.js') }}"></script>
<script src="{{ asset('js/member/zap.js')}}"></script>
<script src="{{ asset('js/member/create.js') }}"></script>
@endsection