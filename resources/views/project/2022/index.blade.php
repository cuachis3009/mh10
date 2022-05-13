@extends('layouts.app')

@section('content')
<style>
    .bs-example {
        margin: 20px;
    }

    .modal-content iframe {
        margin: 0 auto;
        display: block;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header" style="padding-bottom:0px">
            <h5 class="card-title">Registro</h5>
        </div>
        <div class="card-body">
            <p class="text-justify">
                <strong>Objetivo General</strong></br>
                Fomentar el desarrollo y/o fortalecimiento de capacidades técnicas, a través de capacitación para el trabajo impartida a través del ICATMOR, a las personas morelenses en condiciones de pobreza, con la finalidad de contribuir en su desarrollo personal, social y económico, al brindar la oportunidad de generar autoempleo.
                </br></br>
                <strong> Objetivos Específicos</strong>
            <ol type="a">
                <li class="text-justify">
                    Ofrecer cursos de capacitación para el trabajo en las actividades económicas establecidas en las presentes reglas de operación, mismos que serán impartidos por el ICATMOR de forma gratuita, a las personas beneficiarias del programa.
                </li>
                <li class="text-justify">
                    Otorgar un paquete básico de herramientas, equipo y/o insumos, en especie, a las personas que concluyan satisfactoriamente el curso de capacitación impartido por el ICATMOR en el marco del presente programa, y obtengan la constancia correspondiente; con la finalidad de facilitar el desarrollo de su actividad económica.
                </li>
            </ol>
            <strong>Universo de atención</strong> </br> 
            Mujeres y hombres, de 18 años cumplidos en adelante y en condiciones de pobreza, que preferentemente residan en colonias o localidades clasificadas como Zonas de Atención Prioritaria, muy alta, alta y media marginación de los 36 Municipios del Estado de Morelos.
            </p>
            <hr>
            </br>
            <p><strong>
                    Para iniciar el registro de proyecto será necesario consultar el video tutorial para el uso del
                    sistema electrónico, al concluir el video podrá continuar con su registro.
                </strong>
            </p>
            <a href="#myModal" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#myModal"
                data-backdrop="static" data-keyboard="false">Visualizar video</a>

            @error('read-rop')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('read-rob')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('read-roj')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <br> <br>
            <form id="registro" method="POST" action="{{route($period->year. ".project.create",["type_project"=>
                "nuevo"])}}">
                @csrf
                <input type="hidden" name="type" value="nuevo">
                <div class="form-row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="read-rop" value="1" id="check-nuevo-rop">
                        <label class="form-check-label" for="check-nuevo-rop">
                            <a target="_blank" href="https://desarrollosocial.morelos.gob.mx/menucrece">Confirmo
                                que he leído y comprendo las Reglas de Operación del Programa
                                MUJERES Y HOMBRES DE 10, en todos sus términos.</a>

                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="read-rob" value="1" id="check-nuevo-rob">
                        <label class="form-check-label" for="check-nuevo-rob">
                            <a href="https://desarrollosocial.morelos.gob.mx/menucrece">Confirmo que conozco y comprendo los alcances, beneficios y obligaciones
                                del Programa MUJERES Y HOMBRES DE 10.</a>
                        </label>
                    </div>
                </div>
                <!--div class="form-row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="read-roj" value="1" id="check-nuevo-roj">
                        <label class="form-check-label" for="check-nuevo-roj">
                            <a href="#">Confirmo soy jefe o jefa de familia en los términos establecidos en las
                                Reglas de Operación del Programa</a>
                        </label>
                    </div>
                </div-->
                <br>
                <button class="btn btn-sedeso" type="submit">Comenzar registro</button>
            </form>

            <div id="myModal" class="modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title w-100">Videotutorial</h5>
                            <!--span class="label label-default h5" id="timer">00:00</span-->

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <iframe id="video" width="760" height="460"
                                src="https://www.youtube.com/embed/nyZCuY7oNfw?autoplay=1&mute=1&enablejsapi=1&controls=1"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@error('read-rop')
@enderror

<script>
    var totalTime = 0;
    $(document).ready(function(){       
        $("#registro").hide(); 

        var url = $("#video").attr('src');
        $("#video").attr('src', '');

        $("#myModal").on('shown.bs.modal', function(){
            $("#video").attr('src', url);                
            totalTime=5;     
            updateClock();
           
            setTimeout(function(){ 
                $("#registro").show();       
             }, (totalTime*1000));             
        });    
  
     $("#myModal").on('hide.bs.modal', function(){
         $("#video").attr('src', '');
         totalTime=0;  
     });     
 });
 


function updateClock() {   
//document.getElementById('timer').innerHTML = totalTime + " segundos";
if(totalTime==0){
    //alert('Final');
    }else{
    totalTime-=1;
    setTimeout("updateClock()",1000);
    }
}

</script>
@endsection