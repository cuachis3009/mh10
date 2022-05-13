@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header" style="padding-bottom:0px">
                <h5 class="card-title">Resultados del Programa CRECE Morelos "Certifica, Reactiva, Entrega, Crea y Emplea"</h5>
            </div>
            <div class="card-body">
                <iframe class="pdf" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="no" width="100%" height="800px" src="{{asset('docs/PUBLICACION-DE-RESULTADOS-PROGRAMA-DE-IMPULSO-PRODUCTIVO-COMUNITARIO-2022-2.pdf')}}" data-src="{{asset('docs/PUBLICACION-DE-RESULTADOS-PROGRAMA-DE-IMPULSO-PRODUCTIVO-COMUNITARIO-2022-2.pdf')}}">{{asset('docs/PUBLICACION-DE-RESULTADOS-PROGRAMA-DE-IMPULSO-PRODUCTIVO-COMUNITARIO-2022-2.pdf')}}</iframe>
                <hr>
                <iframe class="pdf" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="no" width="100%" height="800px" src="{{asset('docs/PUBLICACION-DE-RESULTADOS-PROGRAMA-DE-IMPULSO-PRODUCTIVO-COMUNITARIO-2022.pdf')}}" data-src="{{asset('docs/PUBLICACION-DE-RESULTADOS-PROGRAMA-DE-IMPULSO-PRODUCTIVO-COMUNITARIO-2022.pdf')}}">{{asset('docs/PUBLICACION-DE-RESULTADOS-PROGRAMA-DE-IMPULSO-PRODUCTIVO-COMUNITARIO-2022.pdf')}}</iframe>
            </div>
        </div>
    </div>
@endsection