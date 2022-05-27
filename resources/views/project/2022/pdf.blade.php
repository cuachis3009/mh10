<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MH10-2022-{{$project->zeroFolio}}</title>
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
                <p class="title-program">Mujeres y Hombres de 10</p>
            </div>
        </div>
        <div class="qr-folio">           
            <h2 style="margin:0px">Folio : MH10-2022-{{$project->zeroFolio}}</h2>
            <p style="margin: 15px 0px;">Registrado el {{$project->created_at->day}} de
                {{$project->created_at->format("F")}} del
                {{$project->created_at->year." ".$project->created_at->format("H:i:s")}}</p>
            <img class="qrcode-image"
                src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(150)->generate('https://mujeresyhombresde10/2022/project/nuevo/pdf/'.$project->slug."/".$project->folio))
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
                        <td class="field-value font-mini">{{($member->colonia)}}</td>
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
                        <td class="field-name  font-mini" colspan="4">Domicilio idéntico a como esta descrito en tu INE o IFE</td>
                    </tr>
                    <tr>
                        <td class="field-value  font-mini" colspan="4">{{$member->domicilioINE}}</td>
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
                        <td class="main-header-table" colspan="6">CURSOS</td>
                    </tr>
                    <tr>
                        <td class="field-name" colspan="2">Curso (Principal)</td>
                        <td class="field-name" colspan="2">Municipio Sede</td>
                        <td class="field-name" colspan="2">Domicilio</td>
                    </tr>
                    <tr>
                        <td class="field-value" colspan="2">{{($wvcursos[0]->CP)}}</td>
                        <td class="field-value" colspan="2">{{($wvcursos[0]->MP)}}</td>
                        <td class="field-value" colspan="2">{{($wvcursos[0]->DP)}}</td>
                    </tr>
                    <tr>
                        <td class="field-name" colspan="2">Curso (Segunda opción)</td>
                        <td class="field-name" colspan="2">Municipio Sede</td>
                        <td class="field-name" colspan="2">Domicilio</td>
                    </tr>
                    <tr>
                        <td class="field-value" colspan="2">{{($wvcursos[0]->CS)}}</td>
                        <td class="field-value" colspan="2">{{($wvcursos[0]->MS)}} </td>
                        <td class="field-value" colspan="2">{{($wvcursos[0]->DS)}} </td>
                    </tr>     
                    <tr>
                        <td class="field-name" colspan="2">Curso (Tercera opción)</td>
                        <td class="field-name" colspan="2">Municipio Sede</td>
                        <td class="field-name" colspan="2">Domicilio</td>
                    </tr>
                    <tr>
                        <td class="field-value" colspan="2">{{($wvcursos[0]->CT)}}</td>
                        <td class="field-value" colspan="2">{{($wvcursos[0]->MT)}} </td>
                        <td class="field-value" colspan="2">{{($wvcursos[0]->DT)}} </td>
                    </tr>
                </tbody>
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
            <table border="1">
                <thead>                    
                </thead>
                <tbody>                   
                    <tr>
                        <td class="field-name" colspan="12">
                            El registro de solicitud de apoyo no crea el derecho de ser aprobado, de recibir el apoyo para la capacitación por parte del ICATMOR en el marco del presente programa ni de recibir el paquete de herramientas y/o insumos, ya que la aprobación está sujeta al cumplimiento de las reglas de operación sin excepción, así como de la disponibilidad de espacios en los grupos de capacitación que se conformarán.
                        </td>                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>