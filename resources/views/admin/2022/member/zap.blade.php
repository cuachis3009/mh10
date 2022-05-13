@extends('admin.template.admin')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h4>Zonas ZAP</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Municipio</th>
                    <th>Zona Zap</th>
                    <th>No zona Zap</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_zap = 0;
                    $total_no_zap = 0;
                @endphp
                @foreach ($municipios as $municipio)
                    <tr>
                        <td>{{$municipio['municipio']}}</td>
                        <td>{{$municipio['zap']}}</td>
                        <td>{{$municipio['no_zap']}}</td>
                    </tr>
                    @php
                        $total_zap += $municipio['zap'];
                        $total_no_zap += $municipio['no_zap'];
                    @endphp
                @endforeach
                <tfoot class="">
                    <tr class="bg-dark text-white">
                        <td>Total</td>
                        <td>{{$total_zap}}</td>
                        <td>{{$total_no_zap}}</td>
                    </tr>
                    @if ($no_members_municipio > 0)
                        <tr>
                            <td class="text-center bg-danger text-white" colspan="3">Total de integrantes sin municipio asignado {{$no_members_municipio}}</td>
                        </tr>
                    @endif
                </tfoot>
            </tbody>
        </table>
    </div>
    <br>
@endsection