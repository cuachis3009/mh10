@extends('admin.template.admin')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container{
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('content')
    
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Listado de proyectos con comprobación
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="alert alert-warning" role="alert">
                            Cuando se selecciona un municipio(s), el filtro devolverá los proyectos donde la primer integrante del grupo pertenece al municipio(s) seleccionado.
                        </div>
                        <form id="filter-municipios" action="{{route('admin.2022.comprobation.index')}}">
                            <select disabled name="municipios[]" id="municipios" class="form-control mb-2" multiple>
                                <option value="all">Todos los municipios</option>
                                @foreach ($municipios as $m)
                                    <option value="{{$m->id}}">{{$m->municipio}}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-info mb-2" type="submit" disabled>Aplicar filtro</button>
                            <button id="download-report" class="btn btn-dark float-right" type="button">Descargar reporte</button>
                        </form>
                        <form id="form-export" action="{{route('admin.2022.comprobation.export')}}" method="POST">
                            @csrf
                            <input type="hidden" name="nuevo" id="ids-nuevos">
                            <input type="hidden" name="fortalecimiento" id="ids-fortalecimiento">
                        </form>
                    </div>
                </div>
                <table class="table table-striped table-bordered" style="width: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Folio</th>
                            <th>Convocatoria</th>
                            <!--th>Giro</th-->
                            <th>Monto aprobado</th>
                            <th>Monto comprobado</th>
                            <th>Municipio</th>
                            <th>Prioridad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nuevos = array();
                            $fortalecimiento = array();
                        @endphp
                        @foreach ($projects as $project)
                            @php 
                                ($project->project_type_id === 1) ? array_push($nuevos,$project->id) : array_push($fortalecimiento,$project->id)
                            @endphp
                            <tr>
                                <td>{{ ($loop->index + 1)}}</td>
                                <td>PIPC-2022-{{($project->project_type_id === 1) ? 'N' : 'F'}}-{{$project->zeroFolio}}</td>
                                <td>{{ucfirst($project->type->name)}}</td>
                                
                                <td>$ {{ number_format($project->amount_approved,2,'.',',') }}</td>
                                <td>$ {{ number_format($project->comprobation->sum('amount'),2,'.',',') }}</td>
                                <td>{{$project->municipio->municipio}}</td>
                                <td>{{$project->priority}}</td>
                                <td><a class="btn btn-outline-info btn-sm" href="{{route('admin.2022.comprobation.project',['slug' => $project->slug])}}">Ver comprobación</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br><br><br>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        const preselect_municipios = @json($request_municipios);
        const btn_download_report = document.getElementById('download-report');
        const form_export = document.getElementById('form-export');
        const ids_nuevos = document.getElementById('ids-nuevos');
        const ids_fortalecimiento = document.getElementById('ids-fortalecimiento');
        ids_nuevos.value = @json($nuevos);
        ids_fortalecimiento.value = @json($fortalecimiento);

        $(document).ready(function() {

            $('#filter-municipios').submit(function(e){
                e.preventDefault();
                const action = $(this).attr('action');
                const municipios = $("#municipios").val().join(',');
                if(municipios != ''){
                    const url = action + '?municipios=' + municipios;
                    window.location.href = url;
                }else{
                    alert("Selecciona al menos un municipio");
                }
            });

            $('#municipios').select2({
                dropdownCssClass : 'mb-2',
                multiple : true,
                placeholder : 'Selecciona un municipio para continuar'
            });

            if(preselect_municipios.length > 0){
                $("#municipios").val(preselect_municipios);
                $('#municipios').trigger('change');
            }

            $('#municipios').on('select2:select', function (e) {
                const options_selected = $("#municipios").val();
                if(options_selected.length > 0){
                    for (let index = 0; index < options_selected.length; index++) {
                        const element = options_selected[index];
                        if(element === 'all'){
                            $("#municipios").val(['all']);
                            $('#municipios').trigger('change');
                        }
                    }
                }
            });

            btn_download_report.addEventListener('click',function(){
                form_export.submit();
            })

        });
    </script>
@endsection