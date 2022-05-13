@extends('layouts.app')

@section('content')
    <div class="container">
        <form id="complete-documents" action="{{route($project->period->year.".member.complete-documents",["type_project" => $project->type->name,"slug" => $project->slug])}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    Hemos detectado que no has subido tus documentos por completo, favor de agregarlos
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            @foreach ($project->members as $member)
                                <tr>
                                    <td class="text-center bg-sedeso text-white" colspan="4">{{$member->fullName}}</td>
                                </tr>
                                <tr>                                   
                                    <td class="text-center">Identificación Oficial (INE/IFE)</td>
                                    <td class="text-center">Clave Única de Registro de Población (CURP)</td>                                   
                                </tr>
                                <tr>                       
                                    <td class="text-center">
                                        @if ($member->documents != null && $member->documents->doc_official_id == 1)
                                            <i class="fa fa-check doc-ok" aria-hidden="true"></i>
                                        @else
                                            <input type="file" class="form-control-file" name="doc-official-id-{{$member->slug}}" id="doc-official-id-{{$member->slug}}">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($member->documents != null && $member->documents->doc_curp == 1)
                                            <i class="fa fa-check doc-ok" aria-hidden="true"></i>
                                        @else
                                            <input type="file" class="form-control-file" name="doc-curp-{{$member->slug}}" id="doc-curp-{{$member->slug}}">
                                        @endif
                                    </td>                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Guardar documentación</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/member/complete-documents.js') }}"></script>
@endsection