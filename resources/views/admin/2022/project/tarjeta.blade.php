<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TARJETA-MH10-2022-C-{{$project->zeroFolio}}</title>
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
    $folio = "MH10-2022-".$project->zeroFolio;
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
    $tipoBeneficiario='“LA BENEFICIARIA”';
    else
    $tipoBeneficiario='“EL BENEFICIARIO”';
    

@endphp
<body>
    <header>
        <table style="border-collapse: collapse;">
            <tr>
                <td style="width: 230px">
                    <img class="logo" src="{{public_path("images/logos/logo-convenio.png")}}">
                </td>
                <td>
                    <p id="program-name">“Programa Mujeres y Hombres de 10”</p>
                    <p id="folio">Acta de Entrega-Recepción de tarjeta bancaria</p>
                </td>
            </tr>
        </table>
    </header>
    <footer><span class="pagenum"></span></footer>
    <div class="container-info">
        <div class="content">            
            <p class="paragraph">
                En el municipio de Cuernavaca Morelos, en las oficinas que ocupa la Secretaría de Desarrollo Social del Poder Ejecutivo del Estado de Morelos ubicadas en Avenida Plan
                 de Ayala número 825 Plaza Cristal tercer piso locales 26 y 27, en la Colonia Teopanzolco, siendo las {{\Carbon\Carbon::now()->format('H')}} horas del día {{\Carbon\Carbon::now()->format('d')}} del mes de enero
                  de 2022 y con fundamento en los numerales 10.7 incisos f), h), i), j), k) de las Reglas de Operación del programa denominado “Programa Mujeres y Hombres de 10”, la Secretaría de Desarrollo Social en adelante “LA SECRETARÍA”, hace constar que en cumplimiento a lo establecido
                    en las Reglas de Operación y en apego a la normatividad vigente y aplicable, realizó el trámite de la tarjeta bancaria a
                     nombre @if($sex==1) la @else del @endif C. {{$fullName}}, en adelante {{$tipoBeneficiario}}, para recibir el apoyo económico por la cantidad de
                      $12,000.00 (Doce mil pesos 00/100 M.N.) para la adquisición del equipo, mobiliario, insumos y/o materia prima referente al Estándar de 
                      competencia “{}” registrado con número de folio <b>{{$folio}}</b>, aprobado por el Comité Dictaminador del programa; 
                      apoyo que fue transferido a la tarjeta correspondiente a la institución bancaria Banco Mercantil del Norte, S.A. BANORTE, 
                      número <u>{{$card1}}</u>-<u>{{$card2}}</u>-<u>{{$card3}}</u>-<u>{{$card4}}</u>
                      la cual se encuentra fondeada y en este acto se entrega a {{$tipoBeneficiario}}, quien la recibe a su entera satisfacción y desde este momento asume 
                      que es la única persona responsable de los recursos transferidos y entregados a su nombre; manifestando bajo protesta de decir verdad que conoce y 
                      comprende las Reglas de Operación del programa en su totalidad, así como lo establecido en el Convenio de Ejecución firmado y libre de cualquier 
                      coacción, error o mala fe,  asumiendo las siguientes OBLIGACIONES: 
            </p>
            <p class="paragraph">
                a) {{$tipoBeneficiario}} se compromete a que en un plazo de 10 (diez) días naturales contados a partir del día 
                {{\Carbon\Carbon::now()->format('d')}} de enero del 2022 realizará la compra del equipo, mobiliario, insumos y/o materia prima, de la solicitud registrada y que quedó aprobada, 
                los cuales deberán coincidir en su totalidad. En caso de que por cualquier circunstancia ajena a “LA SECRETARÍA”, {{$tipoBeneficiario}} 
                no realice el correcto ejercicio de los recursos, deberá realizar el reintegro del total del apoyo económico recibido en el mismo periodo que se establece 
                para presentar la comprobación.</p>
            <p class="paragraph">
                b) Una vez concluido el periodo del ejercicio de recursos, <b>a partir del día siguiente y durante un periodo de 5 (cinco) días hábiles,</b> 
                {{$tipoBeneficiario}} deberá presentar las facturas o Comprobantes Fiscales Digitales por internet (CFDI) que comprueben los recursos económicos otorgados, 
                los cuales deberán cumplir con los siguientes aspectos:</p> 
            <ol style="list-style-type:upper-roman;font-size: 11px;  margin-top: 0px !important; text-align:justify;">
                <li>
                    Facturas o CFDI expedidas a nombre de {{$tipoBeneficiario}};
                </li>
                <li>
                    La o las facturas o CFDI deberán amparar el total de los recursos recibidos, es decir $12,000.00 (Doce mil pesos 00/100 M.N.);
                </li>
                <li>
                    En caso de que la o las facturas o CFDI rebasen la cantidad total de $12,000.00 (Doce mil pesos 00/100 M.N.) y en virtud de que la diferencia 
                    fue absorbida por la persona beneficiaria {{$tipoBeneficiario}} bajo su responsabilidad, la comprobación se considerará como completa, una vez 
                    cumplimentados los demás criterios de validación;
                </li>
                <li>
                    Deberá incluir la verificación de cada factura o CFDI, la cual se emite a través del portal del Sistema de Administración Tributaria de la Secretaría de Hacienda 
                    y Crédito Público; 
                </li>
                <li>
                    Deberá contener la descripción de concepto y características de los artículos o productos señalados en la solicitud de apoyo aprobada;
                </li>
                <li>
                    En caso de no ejercer los recursos otorgados en su totalidad y haber obtenido la o las facturas o CFDI correspondientes, {{$tipoBeneficiario}} 
                    deberá realizar el reintegro de los recursos no ejercidos, aún y cuando la cantidad faltante sea de menos un peso;
                </li>
                <li>
                    Los reintegros se realizarán ante la Secretaría de Hacienda del Poder Ejecutivo del Estado de Morelos, y sólo se podrán realizar en pesos completos. 
                    El procedimiento para la realización de reintegros se detalla en el numeral 10.8 inciso g) de las presentes reglas de operación.
                </li>
            </ol> 
            <p class="paragraph">
                c) La forma de presentar la comprobación correspondiente es a través del correo electrónico oficial del programa mujeresyhombresde10@morelos.gob.mx enviando 
                las facturas, CFDI y documentos correspondientes en formato PDF, señalando el nombre de {{$tipoBeneficiario}}, número de folio o bien realizando una cita vía 
                telefónica al número 7773.10.06.40 ext. 66425, para realizar la entrega de la documentación de forma física.
            </p>
            <p class="paragraph">
                d) En caso de que {{$tipoBeneficiario}} no presente la totalidad de la documentación que ampara la comprobación del ejercicio de los recursos económicos o del reintegro 
                correspondiente durante el periodo establecido, o bien se detecten facturas o CFDI duplicados, falsos o alterados, se iniciarán los procedimientos administrativos para 
                solicitar por escrito el reintegro de la totalidad de los recursos otorgados; en caso de que se presente una negativa a realizar dicho reintegro, se dará inicio a los 
                procedimientos inherentes al requerimiento jurídico por incumplimiento a las presentes reglas de operación, sobre la presunción de afectación al erario público del 
                estado de Morelos.
            </p>
            <p class="paragraph">
                e) Queda estrictamente prohibido utilizar los recursos económicos otorgados a través del presente programa para fines distintos a los establecidos en la solicitud de 
                apoyo aprobada originalmente; para la compra o adquisición de equipo, mobiliario, insumos y/o materia prima usados o semi-nuevos; compra de material para cualquier tipo 
                de obra o construcción; pago de servicios de ampliaciones, remodelaciones, instalaciones eléctricas; agua, energía eléctrica, teléfono, viáticos, fletes, mano de obra, 
                y otros similares; pago de sueldos, deudas, renta de bienes muebles o equipo; realización de pagos que abonen en la compra de vehículos nuevos o usados; traspaso de 
                negocios o licencias; compra de productos nocivos para la salud (bebidas alcohólicas, cigarros, entre otros); y, pago de anticipo o renta de bienes inmuebles, terrenos 
                y locales comerciales.
            </p>
            <p class="paragraph">
                f) {{$tipoBeneficiario}} manifiesta que conoce y acepta la responsabilidad de cumplir todos y cada uno de los procedimientos administrativos que soliciten por parte de 
                “LA SECRETARÍA”, derivado de la recepción de la tarjeta bancaria en la que se depositaron los recursos, por concepto del apoyo económico identificado con el folio antes 
                referido.
            </p>            
            <p class="paragraph last-p">
                No habiendo otro asunto que más que tratar, se da por terminada la presente acta, firmando como constancia las personas que en ella intervinieron al calce, a las 
                {{\Carbon\Carbon::now()->format('H')}} horas del día de su inicio, haciendo constar la entrega – recepción de la tarjeta bancaria fondeada con la cantidad total de $12,000.00 
                (Doce mil pesos 00/100 M.N.); se emite la presente en tres tantos originales.     
            </p>
            <br><br>
            
            <h1 class="title-section">ATENTAMENTE</h1>
            <table id="sedeso-signs">      
                <tr>
                    <td>
                        <b>{{$tipoBeneficiario}}</b>
                        <br><br><br><br><br><br>
                        _________________________________________________<br><br>                                        
                    </td>
                    <td>
                        <b>POR LA SECRETARÍA DE DESARROLLO SOCIAL DEL PODER EJECUTIVO DEL ESTADO DE MORELOS</b>
                        <br><br><br>_________________________________________________<br><br>
                        <strong>HUGO OMAR ARANDA NAVA
                        <br>DIRECTOR GENERAL DE GESTIÓN SOCIAL<br>Y ECONOMÍA SOLIDARIA</strong>
                    </td>
                   
                </tr>
            </table>
            <br><br>
            <p class="paragraph"><b>“Este programa es público, ajeno a cualquier Partido Político. Queda prohibido su uso para fines distintos al Desarrollo Social. Quien haga uso 
                indebido de los recursos de este Programa deberá ser denunciado ante las autoridades conforme a las disposiciones jurídicas aplicables”.</b>
            </p>
        </div>
    </div>
</body>
</html>