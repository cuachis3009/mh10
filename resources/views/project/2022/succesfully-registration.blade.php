@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card text-center">
            <div class="card-body">
                <div class="successful-registration">
                    <h1>Se ha realizado tu registro de forma exitosa</h1>
                    <!--div style="font-size:20px" class="name">
                        <strong>Estandar</strong> : {{$project->name_group}}
                    </div-->
                    <div style="font-size:20px" class="folio">
                        <strong>Folio</strong> : CRECE-2022-{{$project->zeroFolio}}
                    </div>
                    <p style="font-size:20px">
                        <strong>Fecha de registro</strong>: {{$project->created_at->format("d-m-Y H:i:s")}}
                    </p>
                    <div class="qr-code">
                        {!! QrCode::size(200)->generate($project->slug."/".$project->zeroFolio) !!}
                    </div>
                    <br>
                    <a class="btn btn-success" target="_blank" href="{{route($project->period->year.".project.pdf",["type_project" => $project->type->name,"slug" => $project->slug])}}">Descargar mi acuse de registro</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    
@endsection