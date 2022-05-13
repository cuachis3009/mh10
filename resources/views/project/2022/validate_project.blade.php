@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header" style="padding-bottom:0px">
                <h5 class="card-title">Información</h5>
            </div>
            <div class="card-body">
                @if(isset($project))
                    <h4>Validando el proyecto del municipio {{$project->municipio}} con el folio {{$project->folio}} tipo {{($project->project_type_id == 2) ? 'Fortalecimiento' : 'Nuevo'}}</h4>
                    <table border="1">
                        <thead>
                            <tr>
                                <th class="p-2">DOCUMENTACIÓN COMPLETA</th>
                                <th class="p-2">INTEGRANTE DUPLICADA</th>
                                <th class="p-2">INTEGRANTE REGISTRADA EN OTRO PROYECTO</th>
                                @if ($project->project_type_id == 2)
                                    <th class="p-2">MISMAS INTEGRANTES AÑO PASADO</th>
                                @else
                                    <th class="p-2">INTEGRANTE BENEFICIADA EN OTRO AÑO</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center p-2">
                                    @if($project['full_documentation'])
                                        <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                    @else
                                        <i style="color:red" class="fa fa-times" aria-hidden="true"></i>
                                    @endif
                                </td>
                                <td class="text-center p-2">
                                    @if($project['member_duplicate_same_project'])
                                        <i style="color:red" class="fa fa-times" aria-hidden="true"></i>
                                    @else
                                        <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                    @endif
                                </td>
                                <td class="text-center p-2">
                                    @if($project['member_duplicate_other_projects'])
                                        <i style="color:red" class="fa fa-times" aria-hidden="true"></i>
                                    @else
                                        <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                    @endif
                                </td>
                                @if ($project->project_type_id == 2)
                                    <td class="text-center p-2">
                                        @if($project['same_member_previous_project'])
                                            <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                        @else
                                            <i style="color:red" class="fa fa-times" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                @else
                                    <td class="text-center p-2">
                                        @if($project['member_benefited_other_year'])
                                            <i style="color:red" class="fa fa-times" aria-hidden="true"></i>
                                        @else
                                            <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <table border="1">
                        <thead>
                            <tr>
                                <th class="p-2">Nombre</th>
                                <th class="p-2">IFE/INE</th>
                                <th class="p-2">CURP</th>
                                <th class="p-2">COMPROBANTE DE DOMICILIO</th>
                                <th class="p-2">REGISTRADA EN EL MISMO PROYECTO</th>
                                <th class="p-2">REGISTRADA EN OTRO PROYECTO</th>
                                @if ($project->project_type_id == 1)
                                    <th class="p-2">BENEFICIADA EN OTRO AÑO</th>    
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($info_members as $member)
                                <tr>
                                    <td class="p-2">{{$member['name']}}</td>
                                    <td class="text-center p-2">
                                        @if($member['documents']['official_id'])
                                            <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                        @else
                                            <i style="color:red" class="fa fa-times" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                    <td class="text-center p-2">
                                        @if($member['documents']['domicilio'])
                                            <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                        @else
                                            <i style="color:red" class="fa fa-times" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                    <td class="text-center p-2">
                                        @if($member['documents']['domicilio'])
                                            <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                        @else
                                            <i style="color:#ff0000" class="fa fa-times" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                    <td class="text-center p-2">
                                        @if($member['is_duplicate_same_project']['status'])
                                            <i style="color:#ff0000" class="fa fa-times" aria-hidden="true"></i>
                                            <p>{{$member['is_duplicate_same_project']['txt']}}</p>
                                        @else
                                            <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                    <td class="text-center p-2">
                                        @if($member['is_duplicate_other_projects']['status'])
                                            <i style="color:#ff0000" class="fa fa-times" aria-hidden="true"></i>
                                            <p>{{$member['is_duplicate_other_projects']['txt']}}</p>
                                        @else
                                            <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                    @if ($project->project_type_id == 1)
                                        <td class="text-center p-2">
                                            @if($member['is_benefited_other_year']['status'])
                                                <i style="color:#ff0000" class="fa fa-times" aria-hidden="true"></i>
                                                <p>{{$member['is_benefited_other_year']['txt']}}</p>
                                            @else
                                                <i style="color:green" class="fa fa-check" aria-hidden="true"></i>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    {{$text}}
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            setTimeout(function(){
                window.location.href = "{{route('2022.project.validate-project',['period' => $period,'type' => $type,'folio' => $folio + 1])}}";
            },1000);
        });
    </script>
@endsection
