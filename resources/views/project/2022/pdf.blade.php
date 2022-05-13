<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDSCE-2022-{{$project->zeroFolio}}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .container-info {
            width: 683px;
            border: 1px solid #000;
            padding-bottom: 10px;
        }

        .header {
            width: 100%;
            height: 80px;
            padding: 10px;
            border-bottom: 1px solid #000;
        }

        .col-logo {
            float: left;
            width: 35%;
        }

        .col-logo img {
            margin-top: 10px;
            width: 100%;
        }

        .col-program-name {
            width: 65%;
            float: right;
        }

        .title-program {
            margin: 0px;
            padding: 0px 10px;
            text-transform: uppercase;
            text-align: center;
            margin-top: 10px;
        }

        .map-store {
            clear: both;
            text-align: center;
        }

        .info-project table {
            margin: 0px;
            font-size: 14px;
            border: 1px solid #000;
            border-collapse: collapse;
            width: 100%;
        }

        .info-member table {
            margin: 0px;
            font-size: 14px;
            border: 1px solid #000;
            border-collapse: collapse;
            width: 100%;
        }

        .info-products table {
            margin: 10px;
            font-size: 14px;
            border: 1px solid #000;
            border-collapse: collapse;
            width: 100%;
        }

        .info-merchant tr td,
        .info-merchant tr td {}

        .main-header-table {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 10px 0px;
        }

        .header-section-table {
            padding: 5px 10px;
            font-weight: bold;
            text-align: center;
        }

        .field-name {
            width: 25%;
            background: #b5b5b5;
            font-weight: bold;
            padding: 5px 10px;
        }

        .field-value {
            width: 25%;
            padding: 5px 5px;
        }

        .font-mini {
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .product-info {
            font-size: 12px;
            padding: 5px;
        }

        #info-items thead tr th {
            font-size: 12px;
            background: #b5b5b5;
            font-weight: bold;
            padding: 5px 10px;
        }

        #document-member thead tr th {
            font-size: 12px;
            background: #b5b5b5;
            font-weight: bold;
            padding: 5px 10px;
        }

        #info-items tbody tr td {
            font-size: 12px;
            padding: 5px 10px;
        }

        .qr-folio {
            padding: 20px;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-uppercase {
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container-info">
        <div class="header">
            <div class="col-logo">
                <img class="logo" src="{{public_path("images/logos/desarrollosocial.png")}}">
            </div>
            <div class="col-program-name">
                <p class="title-program">CRECE Morelos "Certifica, Reactiva, Entrega, Crea y Emplea"</p>
            </div>
        </div>
        <div class="qr-folio">           
            <h2 style="margin:0px">Folio : CRECE-2022-{{$project->zeroFolio}}</h2>
            <p style="margin: 15px 0px;">Registrado el {{$project->created_at->day}} de
                {{$project->created_at->format("F")}} del
                {{$project->created_at->year." ".$project->created_at->format("H:i:s")}}</p>
            <img class="qrcode-image"
                src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(150)->generate($project->slug."/".$project->folio))
                !!} ">
        </div>
        <div class=" info-project">
            <p class="text-center text-bold text-uppercase">Titular</p>
            @foreach ($members as $member)
            <!--div class="info-member"-->
            <table border="1" style="width:90%"  >
                <thead>
                    <tr>
                        <td class="main-header-table" colspan="4">{{$member->fullName}}</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="max-width:25%" class="field-name font-mini">CURP</td>
                        <td style="max-width: 25%" class="field-value font-mini">{{strtoupper($member->curp)}}</td>
                        <td style="max-width: 25%" class="field-name font-mini">Clave de elector</td>
                        <td style="max-width: 25%" class="field-value font-mini">{{strtoupper($member->official_id_clave)}}</td>
                    </tr>
                    <tr>
                        <td class="field-name font-mini">Año de vigencia INE ó IFE</td>
                        <td class="field-value font-mini">{{$member->officlal_id_year_expiration}}</td>
                        <td class="field-name font-mini">Sexo</td>
                        <td class="field-value font-mini">{{($member->sex== 1) ? "Mujer" : "Hombre"}}</td>
                    </tr>
                    <tr>
                        <td class="field-name font-mini">Teléfono celular</td>
                        <td class="field-value font-mini">{{$member->cellphone_number}}</td>
                        <td class="field-name font-mini">Teléfono de casa</td>
                        <td class="field-value font-mini">{{$member->house_phonenumber}}</td>
                    </tr>
                    <tr>
                        <td class="field-name font-mini">Correo electrónico</td>
                        <td class="field-value font-mini">{{$member->email}}</td>
                        <td class="field-name font-mini">Edad</td>
                        <td class="field-value font-mini">{{$member->age}}</td>
                    </tr>                   
                    <tr>                    
                        <td class="field-name font-mini">Nivel máximo de estudios cursados</td>
                        <td class="field-value font-mini">{{$member->estudios->descripcion}}</td>
                    </tr>                   
                    <tr>
                        <td colspan="4">
                            <p style="font-size:1.17em!important;" class="text-center">Dirección</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="field-name font-mini">Calle</td>
                        <td class="field-value font-mini">{{($member->street)}}</td>
                        <td class="field-name font-mini">Número exterior</td>
                        <td class="field-value font-mini">{{($member->exterior_number)}}</td>
                    </tr>
                    <tr>
                        <td class="field-name font-mini">Número interior</td>
                        <td class="field-value font-mini">{{($member->interior_number)}}</td>
                        <td class="field-name font-mini">Colonia</td>
                        <td class="field-value font-mini">{{($member->locCol->loc_col)}}</td>
                    </tr>
                    <tr>
                        <td class="field-name font-mini">Código postal</td>
                        <td class="field-value font-mini">{{$member->postal_code}}</td>
                        <td class="field-name font-mini">Municipio</td>
                        <td class="field-value font-mini">{{($member->municipioDb->municipio)}}</td>
                    </tr>
                    <tr>
                        <td class="field-name font-mini">Tipo de vialidad</td>
                        <td class="field-value font-mini">{{($member->tipoVialidad->descripcion)}}</td>
                        <td class="field-name font-mini">Tipo de asentamiento</td>
                        <td class="field-value font-mini">{{($member->tipoAsentamiento->descripcion)}}</td>
                    </tr>
                    <tr>
                        <td class="field-name font-mini">¿Reside en un municipio indigena?</td>
                        <td class="field-value font-mini">{{($member->municipioIndigena==NULL)?"No":"Si"}}</td>
                        <td class="field-name font-mini">Municipio indigena</td>
                        <td class="field-value font-mini">{{(($member->municipioIndigena!=NULL)?$member->municipioIndigena->municipio:"--")}}</td>
                    </tr>
                    <tr>
                        <td class="field-name  font-mini" colspan="4">Referencias del domicilio (Información que
                            facilite identificar la vivienda y ubicación de ésta)</td>
                    </tr>
                    <tr>
                        <td class="field-value  font-mini" colspan="4">{{$member->referencia_domicilio}}</td>
                    </tr>
                </tbody>
            </table>
           
            <table border="1">
                <thead>                    
                </thead>
                <tbody>
                    <tr>
                        <td class="main-header-table" colspan="4">Datos del estandar</td>
                    </tr>
                    <tr>
                        <td class="field-name" colspan="2">Estandar</td>
                        <td class="field-name" colspan="2">Tipo de Proceso</td>
                    </tr>
                    <tr>
                        <td class="field-value" colspan="2">{{$project->estandar->estandar}}</td>
                        <td class="field-value" colspan="2">{{$project->estandar->proceso}}</td>
                    </tr>
                    <tr>
                        <td class="field-name" colspan="2">Sede</td>
                        <td class="field-name" colspan="2">Domicilio</td>
                    </tr>
                    <tr>
                        <td class="field-value" colspan="2">{{$project->estandar->sede}}</td>
                        <td class="field-value" colspan="2">{{$project->estandar->domicilio}}</td>
                    </tr>
                    <tr>
                        <td class="field-name" colspan="2">Tiempo de experiencia básica en el Estándar que solicita</td>
                        <td class="field-name" colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="field-value" colspan="2">{{$project->experience_time}}</td>
                        <td class="field-value" colspan="2"></td>
                    </tr>     
                    
                    <tr>
                        <td class="field-name" colspan="4">Conocimientos de competencias laborales</td>
                    </tr>
                    <tr>
                        <td class="field-value" colspan="4">
                            @foreach ($project->Project_conocimientos as $proj_con)
                                    <ul>
                                @foreach ($proj_con->conocimientos as $con)
                                   
                                <li>{{$con->conocimiento}}</li>                      
                                   
                                @endforeach   
                                    </ul>                       
                            @endforeach
                        
                        </td>
                    </tr>

                    <tr>
                        <td class="field-name" colspan="4">Objetivo que se pretende alcanzar con la actividad económica
                            que
                            realizará en el proyecto productivo</td>
                    </tr>
                    <tr>
                        <td class="field-value" colspan="4">{{$project->objective}}</td>
                    </tr>
                    <tr>
                        <td class="field-name" colspan="4">Describa las actividades que usted realizará con la
                            Certificación y entrega del apoyo económico</td>
                    </tr>
                    <tr>
                        <td class="field-value" colspan="4">{{$project->activity_description}}</td>
                    </tr>
                </tbody>
            </table>

            <p class="text-center text-bold text-uppercase">Componentes</p>
            <table border="1" id="info-items">
                <thead>
                    <tr>
                        <th>COMPONENTE</th>
                        <th>UNIDAD DE MEDIDA</th>
                        <th>CANTIDAD REQUERIDAD</th>
                        <th>COSTO UNITARIO</th>
                        <th>COSTO TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    {{$TOTAL=0}}
                    @foreach ($project->items as $item)
                    <tr>
                        <td class="text-center">{{$item->item}}</td>
                        <td class="text-center">{{$item->unit}}</td>
                        <td class="text-center">{{$item->quantity}}</td>
                        <td>${{number_format($item->price,2,".",",")}}</td>
                        <td>${{number_format($item->total_cost,2,".",",")}}</td>
                        {{$TOTAL=$TOTAL+$item->total_cost}}
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="thead-light">
                    <tr>
                        <th colspan="4" style="text-align: right;">Total</th>
                        <th style="text-align: left;">${{number_format($TOTAL,2,".",",")}}</th>
                    </tr>
                </tfoot>
            </table>                       
            <br>            
            <p class="text-center">Documentación ingresada</p>
            <table border="1" id="document-member">
                <thead>
                    <tr>                        
                        <th class="text-center">Identificación Oficial (INE/IFE)</th>
                        <th class="text-center">Clave Única de Registro de Población (CURP)</th>                       
                    </tr>
                    <tr>               
                        <td class="text-center">
                            @if ($member->documents->doc_official_id == 1)
                            Si
                            @else
                            No
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($member->documents->doc_curp == 1)
                            Si
                            @else
                            No
                            @endif
                        </td>
                
                    </tr>
                </thead>
            </table>
            
 
            <!--/div-->
            <br><br>
            @endforeach
        </div>
    </div>
</body>

</html>