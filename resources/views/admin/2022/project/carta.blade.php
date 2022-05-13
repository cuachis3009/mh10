<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CARTA-CRECE-2022-C-{{$project->zeroFolio}}</title>
    <style>

        body{
            font-family: Arial, Helvetica, sans-serif;
        }

        @page { 
            margin: 130px 50px 40px 50px; 
            font-family: Arial, Helvetica, sans-serif;
        }

        .container-info{
            
        }

        header { 
            position: fixed; 
            top: -65px; 
            left: 0px; 
            right: 0px; 
        }

        header p{
            margin: 0px;
            width: 100%;
        }

        header table{
            margin: 0px;
        }

        footer {
            border-top: 1px solid #000;
            position: fixed; 
            bottom: 10px; 
            left: 0px; 
            right: 0px; 
            text-align: right;
            padding-top: 5px;
        }

        footer span{
            font-size: 11px;
        }

        .pagenum:before {
            content: counter(page) ' | Página';
        }

        .logo{
            width: 220px;
        }

        #program-name{
            font-size: 10px;
            text-align: center;
        }

        #type-project,#folio{
            font-size: 14px;
            margin: 0px;
        }

        .convenio-init{
            font-weight: bold;
            text-align: justify;
            margin: 0px;
            font-size: 12px;
        }

        p.paragraph{
            font-size: 11px;
            text-align: justify;
            margin: 0px;
            margin-bottom: 10px;
        }

        p.paragraph span{
            font-weight: bold;
        }

        .last-p{
            margin-bottom: 0px !important;
        }

        .title-section{
            font-size: 11px;
            text-align: center;
            margin: 18px 0px;
        }

        .sub-title-section{
            font-size: 11px;
            text-align: left;
            margin: 18px 0px;
        }

        .next-sub-title{
            margin-bottom: 0px !important;
        }

        #info-members-table{
            width: 100%;
            border-color: #000;
            border-collapse: collapse;
            font-size: 11px; 
            margin-bottom: 10px;
        }

        #info-members-table tr td{
            padding: 1px 5px;
        }

        #member-directions tr td{
            font-size: 11px;
            padding: 0px;
        }

        #sedeso-signs{
            width: 100%;
            font-size: 11px;
        }

        #sedeso-signs tr td{
            padding-top: 30px;
            text-align: center;
        }

        #member-signs{
            width: 100%;
            border-color: #000;
            border-collapse: collapse;
            font-size: 11px; 
            margin-bottom: 10px;
        }

        #member-signs thead tr td{
            padding:5px 10px;
            font-weight: bold;
        }
        #member-signs tbody tr td{
            padding:10px;
        }

    </style>
</head>
@php
    $folio = "CRECE-2022-".$project->zeroFolio;
    $iterate = 5;
    $sex=0;
    $fullName="";
    $card="";
    $rfc="";
    $rfcStatus="";
    $official_id_clave="";
    $domIne="";
    //$domProject=Str::upper($project->street.' '.$project->exterior_number.' '.$project->interior_number.' '.$project->postal_code.' '.$project->colonia .' '. $project->municipioDb->municipio .' MORELOS');
    $tipoBeneficiario="";
    foreach ($project->members as $member){
        $sex=$member->sex;
        $fullName=$member->fullName;
        $rfc=$member->rfc;
        $official_id_clave=$member->official_id_clave;
        //$rfcStatus=$member->rfcStatus->status;
        $card1=substr($member->card_bank_owner,0,4);
        $card2=substr($member->card_bank_owner,4,4);
        $card3=substr($member->card_bank_owner,8,4);
        $card4=substr($member->card_bank_owner,12,4);
        //$domIne=Str::upper($member->street.' '.$member->exterior_number.' '.$member->interior_number.' '.$member->locCol->loc_col.' '.$member->postal_code.' '.$member->municipioDb->municipio);
        break;
    }
   
    if($sex==1)
    $tipoBeneficiario='beneficiaria';
    else
    $tipoBeneficiario='beneficiario';
    

@endphp
<body>
    <header>
        <table style="border-collapse: collapse;">
            <tr>
                <td style="width: 230px">
                    <img class="logo" src="{{public_path("images/logos/logo-convenio.png")}}">
                </td>
                <td>
                    <p id="program-name">“Programa CRECE Morelos (Certifica, Reactiva, Entrega, Crea y Emplea)”</p>
                    <p id="folio">Carta compromiso para la ejecución de procesos administrativos
                    </p>
                </td>
            </tr>
        </table>
    </header>
    <footer><span class="pagenum"></span></footer>
    <div class="container-info">
        <div class="content">   
            <p class="paragraph"><b>
                Folio: {{$folio}}<br>
                Nombre completo de la persona beneficiaria: {{$fullName}}<br>
                Fecha: {{\Carbon\Carbon::now()->format('d/m/Y')}}</b>
            </p>             
            <p class="paragraph">
                Con fundamento en los numerales 9.3, 10.2, 10.4, 10.6, 10.7 10.10 y 11.2 de las Reglas de Operación del programa denominado “Programa CRECE Morelos (Certifica, Reactiva, Entrega, Crea y Emplea)”, confirmo que conozco, comprendo y acepto los procesos administrativos y operativos que se desarrollan en coordinación con la Secretaría de Desarrollo Social para la recepción, ejecución y comprobación de los apoyos económicos que se otorgarán para la adquisición del equipo, mobiliario, insumos y/o materia prima referente al Estándar de competencia registrado con número de folio <b>{{$folio}}</b>, el cual fue aprobado por el Comité Dictaminador del Programa, con los siguientes datos: 
            </p>
            <p class="paragraph">
               <b>Estándar de competencia: {{$project->estandar->estandar}}.</b>
            </p>
            <p class="paragraph">
                1.- Confirmo que conozco, comprendo y acepto los términos y plazos establecidos para cada uno de los procesos, considerando que con esta fecha se da inicio a los mismos.  
            </p> 
            <p class="paragraph">
                Así mismo reconozco que la entrega de apoyo económico se realizará una vez que CONOCER informe a la Secretaría de Desarrollo Social si fui declarado “COMPETENTE” por tener los conocimientos, habilidades, destrezas y actitudes requeridos para alcanzar el Estándar de Competencia conforme a lo establecido en el numeral 10.6. de las Reglas de Operación del programa.
            </p>             
            <p class="paragraph">
                2. Con relación al procedimiento para la recepción de los recursos económicos y que derivado de lo establecido en el numeral 10.7 incisos f), g) h), i), j) y k) la Secretaría llevará a cabo el trámite de una tarjeta bancaria a mi nombre con la finalidad de garantizar la correcta transferencia del apoyo económico, con esta fecha, la Secretaría me informa que la institución bancaria a través de la cual se tramitarán dichas tarjetas es Banco Mercantil del Norte, S.A BANORTE; en este orden de ideas y en cumplimiento a lo dispuesto en las Reglas de Operación, manifiesto lo siguiente: 
            </p>
            <p class="paragraph"><b>
                BAJO PROTESTA DE DECIR VERDAD MANIFIESTO que no tengo adeudos o compromisos administrativo-financieros pendientes por pagar con la Institución bancaria </b>Banco Mercantil del Norte, S.A BANORTE; <b>que pudieran afectar la recepción de los recursos del apoyo económico aprobado a mi nombre. </b> 
            </p>
            <p class="paragraph"><b>
                Así mismo y en conocimiento pleno de las Reglas de Operación del programa, otorgo mi consentimiento para que la Secretaría de Desarrollo Social del Poder Ejecutivo del Estado de Morelos tramite una tarjeta bancaria a mi nombre con la institución bancaria BANORTE; de igual forma, a través del presente acepto que los recursos económicos del apoyo por un monto total de $12,000.00 (Doce mil pesos 00/100 M.N.) sean transferidos a dicha cuenta. 
            </b>
            </p>  
            <p class="paragraph">
                Preciso que en caso de que la institución bancaria <b>BANORTE</b> realice alguna afectación total o parcial de los recursos económicos en materia del apoyo otorgado por parte del Gobierno del Estado de Morelos, derivado de compromisos contraídos por mi parte previamente con dicha institución, me encuentro con la responsabilidad de dar cabal cumplimiento  a las obligaciones adquiridas con motivo del Programa “CRECE Morelos (Certifica, Reactiva, Entrega, Crea y Emplea)”; por lo que me comprometo a adquirir el equipo, mobiliario, insumos y/o materia prima establecidos en mi solicitud de registro y en caso de no continuar con el proceso, en el mismo periodo realizaré el reintegro de los recursos otorgados por la cantidad total de $12,000.00 (Doce mil pesos 00/100 M.N.) de conformidad con el procedimiento establecido en el numeral 10.7 inciso n) y 10.8 inciso g) de las Reglas de Operación del programa.
            </p>            
            <p class="paragraph">
                Se suscribe la presente a los {{\Carbon\Carbon::now()->format('d')}} días del mes de diciembre de 2022, en tres tantos originales, anexando a la presente copia simple de mi identificación oficial con fotografía. 
                 
            </p>            
            <h1 class="title-section">ATENTAMENTE</h1>            
            <table id="member-signs" border="1">
                <thead>
                    <tr>
                        <td>NOMBRE COMPLETO</td>
                        <td>FIRMA</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($project->members as $member)
                        <tr>
                            <td style="width: 450px">
                                <br><br>                     
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            <p class="paragraph"><b>“Este programa es público, ajeno a cualquier Partido Político. Queda prohibido su uso para fines distintos al Desarrollo Social. Quien haga uso indebido de los recursos de este Programa deberá ser denunciado ante las autoridades conforme a las disposiciones jurídicas aplicables”.</b>
            </p>
        </div>
    </div>
</body>
</html>