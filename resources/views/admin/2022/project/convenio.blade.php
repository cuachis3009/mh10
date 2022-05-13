<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CONVENIO-CRECE-2022-C-{{$project->zeroFolio}}</title>
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
    $rfc="";
    $rfcStatus="";
    $official_id_clave="";
    $domIne="";
    $tel="";
    $correo="";
    //$domProject=Str::upper($project->street.' '.$project->exterior_number.' '.$project->interior_number.' '.$project->postal_code.' '.$project->colonia .' '. $project->municipioDb->municipio .' MORELOS');
    $tipoBeneficiario="";
    foreach ($project->members as $member){
        $sex=$member->sex;
        $fullName=$member->fullName;
        $rfc=$member->rfc;
        $official_id_clave=$member->official_id_clave;
        $tel=$member->cellphone_number;
        $correo=$member->email;
        //$rfcStatus=$member->rfcStatus->status;
        
        if(strlen($member->domicilioINE)>0){
            $domIne= $member->domicilioINE; //Str::upper($member->street.' '.$member->exterior_number.' '.$member->interior_number.' '.$member->locCol->loc_col.' '.$member->postal_code.' '.$member->municipioDb->municipio);
        }
        else {
            $domIne= Str::upper($member->street.' '.$member->exterior_number.', '.$member->interior_number.', '.$member->locCol->loc_col.', '.$member->municipioDb->municipio).', MORELOS, C.P. ' .$member->postal_code .'.';
        }
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
                    <p id="program-name">Convenio de Ejecución de “Programa CRECE Morelos (Certifica, Reactiva, Entrega, Crea y Emplea)”</p>
                    <p id="folio">{{$folio}}</p>
                </td>
            </tr>
        </table>
    </header>
    <footer><span class="pagenum"></span></footer>
    <div class="container-info">
        <div class="content">
            <p class="convenio-init">
                CONVENIO DE EJECUCIÓN DEL “PROGRAMA CRECE MORELOS (CERTIFICA, REACTIVA, ENTREGA, CREA Y EMPLEA)”, QUE CELEBRAN POR UNA PARTE EL GOBIERNO DEL ESTADO LIBRE Y SOBERANO DE MORELOS, A TRAVÉS DE LA SECRETARÍA DE DESARROLLO SOCIAL, REPRESENTADA EN ESTE ACTO POR SU TITULAR ALFONSO DE JESÚS SOTELO MARTÍNEZ, ASISTIDO POR LA DIRECTORA GENERAL DE GESTIÓN SOCIAL Y ECONOMÍA SOLIDARIA MELISSA PALOMA VILLADA ARELLANO Y LA DIRECTORA DE PROGRAMAS COMPLEMENTARIOS NANCY ELIZABETH REYES VIVEROS, A QUIEN EN LO SUCESIVO Y PARA LOS EFECTOS DEL PRESENTE INSTRUMENTO SE LES DENOMINARÁ “LA SECRETARÍA”, Y POR LA OTRA PARTE     
                    @if($sex==1)
                        LA C. {{Str::upper($fullName)}}, BENEFICIARIA  
                    @else
                        EL C. {{Str::upper($fullName)}}, BENEFICIARIO  
                    @endif                    
                    DEL PROGRAMA REGISTRADO CON NÚMERO DE FOLIO {{$folio}} A QUIEN EN LO SUCESIVO Y PARA LOS EFECTOS DEL PRESENTE CONVENIO SE LE DENOMINARÁ
                    {{$tipoBeneficiario}},” Y CUANDO ACTÚEN EN CONJUNTO SE LES DENOMINARÁ “LAS PARTES”, SUJETANDOSE AL TENOR DE LOS SIGUIENTES ANTECEDENTES, DECLARACIONES Y CLÁUSULAS:            
            </p>
            <h1 class="title-section">ANTECEDENTES</h1>
            <p class="paragraph">1. De conformidad con la Ley de Desarrollo Social del Estado de Morelos, publicada en el periódico Oficial “Tierra y Libertad” número 5139 de fecha seis de noviembre del dos mil trece, establece en su artículo 8, que toda persona jurídica individual tiene derecho a participar y a beneficiarse de los Programas y Acciones de Desarrollo Social y de acuerdo con los principios rectores de las Políticas Públicas Estatales y Municipales en los términos que establezca la normatividad aplicable.</p>
            <p class="paragraph">2. Con la finalidad de fortalecer las estrategias de reactivación económica en el estado de Morelos en beneficio de las mujeres y los hombres en condiciones de desventaja social y económica, <b>“LA SECRETARÍA”</b> y el Consejo Nacional de Normalización y Certificación de Competencias Laborales en adelante <b>“CONOCER”</b>, determinaron la viabilidad de suscribir un Convenio de Colaboración para la certificación de Estándares de Competencia.</p>
            <p class="paragraph">3. Que para la ejecución del presente programa se tiene como Fuente de Financiamiento Recursos Fiscales y Procedencia Ingresos Propios, precisando que su pago estará sujeto a la disponibilidad presupuestal existente en el Gobierno del Estado.</p>
            <p class="paragraph">4. <b>Con fecha 27 de agosto de 2022 “LA SECRETARÍA”</b> y el <b>“CONOCER”</b> suscribieron un Convenio General de Colaboración número <b>04/2022/SDS</b>, con el objetivo de establecer los términos para proveer un derecho social fundamental e incentivar a la población a la creación de autoempleo a través de la entrega de apoyos económicos para la adquisición de equipos y herramientas en el Estado de Morelos por parte de la Secretaría de Desarrollo Social y a certificarse en estándares de competencia laborales a través de la entidad paraestatal CONOCER.</p>
            <p class="paragraph">5. <b>Con fecha 15 de octubre de 2022 “LA SECRETARÍA”</b> y el <b>“CONOCER”</b> suscribieron un Convenio General de Colaboración número <b>11/2022/SDS</b>, con el objetivo de establecer vínculos de colaboración y coordinación con la finalidad de propiciar los derechos sociales fundamentales de los morelenses, a través de los prestadores de servicio que llevarán a cabo los procesos de evaluación en las competencias laborales y expidiendo para tal efecto los Certificados de Competencia Laboral.</p>
            <p class="paragraph">6. <b>Con fecha 11 de noviembre de 2022</b> se publicaron las Reglas de Operación del programa denominado “Programa CRECE Morelos (Certifica, Reactiva, Entrega, Crea y Emplea)”, en adelante <b>“EL PROGRAMA”</b>, en el Periódico Oficial “Tierra y Libertad” número 6009.</p>
            <p class="paragraph">7. De conformidad con lo establecido en los numerales 10.7, 10.8, 10.9 y 11.2 de las Reglas de Operación de <b>“EL PROGRAMA”</b>, es procedente y necesario celebrar el presente Convenio de Ejecución entre <b>“LAS PARTES”</b>, con el objeto de establecer las condiciones del otorgamiento del apoyo económico, liberación y comprobación de los recursos, verificación de los recursos ejercidos y los derechos y obligaciones a las que se sujetan las personas beneficiarias.</p>            
            <p class="paragraph last-p">8. La solicitud con el número de folio citado al rubro, se encuentra en estatus de aprobado y se hace constar en el Acuerdo xxx tomado por el Comité Dictaminador y que se encuentra publicado en la página oficial de la Secretaría de Desarrollo Social <a href="http://desarrollosocial.morelos.gob.mx">http://desarrollosocial.morelos.gob.mx</a>; lo anterior conforme a lo establecido en el numeral 10.1 inciso a) de las Reglas de Operación del programa.</p>            
            
                <h1 class="title-section next-sub-title">DECLARACIONES</h1>           
            <h1 class="sub-title-section">I.- DECLARA "LA SECRETARÍA" QUE:</h1>
            <p class="paragraph">I.1 Es una Dependencia que forma parte de la Administración Pública Central del Poder Ejecutivo del Gobierno del Estado Libre y Soberano de Morelos, de conformidad con lo dispuesto por el artículo 74 de la Constitución Política para el Estado Libre y Soberano de Morelos, artículos 3 segundo párrafo, 4 fracción XV, 9 fracción XII, 13 fracción VI, 14 y 32 fracciones I, III, IV, V, IX y XVIII de la Ley Orgánica de la Administración Pública del Estado Libre y Soberano de Morelos.</p>
            <p class="paragraph">I.2 Sus representantes disponen de facultades suficientes para celebrar actos como el presente Convenio, de conformidad con los artículos 13 fracción VI, 14 y 32 de la Ley Orgánica de la Administración Pública del Estado Libre y Soberano de Morelos; 2 fracciones X y XIII, 4 fracciones I y II, 6, 7, 8 fracciones I y VII, y 9 fracciones III, XVII, y XXXVI, 10 y 26 del Reglamento Interior de la Secretaría de Desarrollo Social.</p>
            <p class="paragraph last-p">I.3 Para los efectos del presente instrumento jurídico, se señala como domicilio el ubicado en avenida Plan de Ayala, número 825, tercer piso, local 26, Colonia Teopanzolco, Código Postal 62350, en la Ciudad de Cuernavaca, Morelos.</p>            
           
            <h1 class="sub-title-section">II.- DECLARA {{$tipoBeneficiario}} QUE: </h1>
            <p class="paragraph">II.1 Manifiesta bajo protesta de decir verdad que reconoce ser la persona titular de la solicitud con número de folio <b>{{$folio}}</b>, aprobado para recibir el apoyo económico en el “Programa CRECE Morelos (Certifica, Reactiva, Entrega, Crea y Emplea)”; ser residente en el estado de Morelos, con la capacidad legal, consiente y libre para celebrar el presente instrumento jurídico, y así mismo se identifica con credencial oficial vigente expedida por el Instituto Nacional/Federal Electoral como sigue:</p>           
            <table id="info-members-table" border="1">
                <thead>
                    <tr>
                        <td>NOMBRE</td>
                        <td>CLAVE DE ELECTOR</td>
                    </tr>
                </thead>
                <tbody>                   
                        <tr>
                            <td style="width: 450px">{{Str::upper($fullName)}}</td>
                            <td>{{Str::upper($official_id_clave)}}</td>
                        </tr>                   
                </tbody>
            </table>            
            <p class="paragraph">II.2 Manifiesta bajo protesta de decir verdad que conoce las Reglas de Operación del programa, así como las responsabilidades que debe asumir, por lo que se compromete a dar cumplimiento total a cada uno de los procedimientos establecidos en éstas, en su carácter de persona beneficiaria aprobada; así mismo reconoce que el presente Convenio de Ejecución se celebra como requisito indispensable para llevar a cabo los trámites y gestiones institucionales para la entrega del apoyo económico del Programa, hasta el momento contable devengado; apoyo que queda sujeto a la suficiencia y disponibilidad presupuestal en el Gobierno del Estado de Morelos, conforme a lo establecido en el numeral 10.7 inciso g) de las Reglas de Operación del programa.</p>
            <p class="paragraph">II.3 Manifiesta que conoce y comprende claramente lo establecido en los numerales 10.5 Criterios de improcedencia y cancelación de las solicitudes de apoyo, 10.7 Del procedimiento para la firma de convenios de ejecución, liberación y comprobación de recursos otorgados, 10.8 Del seguimiento y verificación de los recursos ejercidos y 11 Derechos y Obligaciones de las personas beneficiarias del programa, así mismo, acepta de conformidad y en todos sus términos las condiciones de cumplimiento e incumplimiento según sea el caso; conoce y acepta los términos establecidos aplicables en los casos de incumplimiento que amerita el reintegro de los recursos otorgados, lo cual atenderá cabalmente conforme a las Reglas de Operación del programa y lo establecido en el presente Convenio.</p>
            <p class="paragraph">II.4 Para los efectos del presente Convenio, señala como domicilio para oír y recibir todo tipo de notificaciones y documentos que deriven de los actos inherentes a este instrumento legal y que servirá para practicar las notificaciones aún de carácter personal, las que surtirán todos sus efectos legales, el ubicado en: {{$domIne}}</p>
            <p class="paragraph">II.5 Para efecto de comunicación, coordinación y demás actuaciones o acciones que resulten necesarias para el debido cumplimiento del presente convenio señala como número telefónico {{$tel}} y correo electrónico {{$correo}}.</p>
            <p class="paragraph last-p">II.6. Bajo protesta de decir vedad manifiesta que a la firma del presente convenio ha realizado su proceso de evaluación, por lo que ha sido dictaminado(a) como “Competente” en el Estándar de Competencia {{$project->estandar->estandar}}, y validado por el Consejo Nacional de Normalización de Certificación de Competencias Laborales CONOCER.</p>
                        
            <h1 class="sub-title-section">III.- DECLARAN “LAS PARTES” QUE: </h1>
            <p class="paragraph">III.1 Manifiestan estar plenamente conscientes de las obligaciones que asumen con la firma del presente Convenio, que no existe error, dolo, lesión o mala fe, así como cualquier otro vicio que invalide la voluntad de los que en él intervienen; reconociéndose mutuamente la personalidad y capacidad legal con que se ostentan para celebrar el presente convenio y estar conformes con las declaraciones que anteceden.</p>            
            <p class="paragraph last-p">Expuestas las declaraciones anteriores, <b>“LAS PARTES”</b> están de acuerdo en celebrar el presente convenio, de conformidad con las siguientes:</p>
            
            <h1 class="title-section">CLÁUSULAS</h1>
            <p class="paragraph"><span>PRIMERA. DEL OBJETO.-</span> El presente Convenio tiene por objeto establecer las obligaciones, procedimientos y acciones entre <b>“LAS PARTES”</b> 
                para la debida ejecución del programa social derivada de la solicitud registrada y aprobada en el marco del programa, con el folio {{$folio}}, referente a la certificación de competencias laborales y entrega de apoyo económico.
            </p>
            <p class="paragraph"><span>SEGUNDA. DE LOS DERECHOS Y OBLIGACIONES DE {{$tipoBeneficiario}}.- “LAS PARTES”</span> comprenden y aceptan los derechos y obligaciones de {{$tipoBeneficiario}}, conforme a lo establecido en las Reglas de Operación del programa, en todos sus términos y contenido íntegro.</p>
            <h1 class="sub-title-section" style="margin-bottom: 0px;">
                Derechos:
            </h1>
            <p class="paragraph">
                a) Tener acceso a las reglas de operación del programa;<br>
                b) Recibir asesoría por parte de la Secretaría a través de la URP, respecto al contenido de las reglas de operación, objetivos, requisitos y alcances del programa en todos sus términos, considerando que dicha asesoría será atendida a través del correo electrónico programa.crecemorelos@morelos.gob.mx, y en caso de ser necesaria la asistencia a las instalaciones de la Secretaría, las personas interesadas deberán realizar una cita con el personal de la URP, vía telefónica al número 7773.10.06.40 ext. 66425, o mediante el correo electrónico disponible, y acatar las disposiciones institucionales que para tal efecto la Secretaría señale;<br>
                c) Registrar una solicitud de apoyo en el sistema electrónico del programa en la página <a href="http://programacrece.morelos.gob.mx">http://programacrece.morelos.gob.mx</a>;<br>
                d) Obtener de forma gratuita el certificado de competencia laboral que otorga el CONOCER, de conformidad y en cumplimiento de las Reglas de Operación de <b>“EL PROGRAMA”</b>;<br>
                e) Ser informadas por la URP de los términos y alcances del programa, así como de los periodos que conlleva cada uno de los procedimientos, conforme a lo establecido en las reglas de operación;<br>
                f) Las personas beneficiarias del programa, de conformidad con el artículo 66 de la Ley de Desarrollo Social para el Estado de Morelos, serán registradas en el padrón único de beneficiarios de programas sociales, por lo que, en caso de tener algún inconveniente, deberá manifestarlo por escrito a la URP.
            </p>
            <h1 class="sub-title-section" style="margin-bottom: 0px;">
                Obligaciones:
            </h1>
            <p class="paragraph">
                a)	Conducirse con verdad en la información que proporcione a la Secretaría de Desarrollo Social del Gobierno del Estado de Morelos, con motivo de su registro en el programa y en la información que le sea solicitada por parte de las personas servidoras públicas adscritas al Gobierno del Estado de Morelos.<br>
                b)	Leer y cumplir con las Reglas de Operación de <b>“EL PROGRAMA”</b>, procedimientos establecidos por el Comité Dictaminador que correspondan y con los términos del Convenio de Ejecución que se celebrará con la Secretaría.<br> 
                c)	Verificar, ordenar, actualizar y/o entregar según corresponda la documentación solicitada por la Secretaría, en todos los procesos que se desarrollarán en el programa.<br> 
                d)	Respetar la resolución que emita el Comité Dictaminador del programa, respecto a la aprobación o cancelación de solicitudes de apoyo.<br>
                e)	Respetar la dictaminación que realice el CONOCER derivado de la o las evaluaciones que realice a las personas solicitantes de apoyo.<br> 
                f)	Emplear el apoyo económico recibido, única y exclusivamente para la adquisición del equipo, mobiliario, insumos y/o materia prima establecidos en la solicitud de apoyo aprobada y deberán ser nuevos.<br>
                g)	Informar a esta Secretaría de Desarrollo Social sobre cualquier cambio que resulte relevante para que la URP desarrolle los procedimientos de seguimiento correspondientes; incluyendo principalmente el cambio de domicilio de residencia, en su carácter de persona beneficiada por el programa.<br>
                h)	Presentar la documentación comprobatoria mediante la cual se hace constar el correcto ejercicio de los recursos económicos otorgados por concepto del apoyo económico del programa, conforme a lo establecido en las Reglas de Operación y en el Convenio de Ejecución suscrito con la Secretaría.<br>
                i)	Permitir la o las visitas de verificación que la Secretaría determine necesarias y proporcionar la información que le sea requerida por parte de las personas servidoras públicas de la Secretaría, con el fin de verificar la correcta aplicación de los recursos económicos otorgados. Así mismo, deberán facilitar documentación que les sea requerida durante las actividades en comento.<br> 
                j)	Dar cumplimiento a lo establecido en los ordenamientos legales aplicables en materia de: derechos de autor, propiedad intelectual, propiedad industrial, protección civil, obligaciones patronales, obligaciones fiscales o las que correspondan por cuanto al ejercicio de su actividad laboral.<br>
                k)	Una vez transferidos los recursos económicos a las personas beneficiarias y en caso de presentarse cualquier situación de índole legal inherente a su persona, que afecte la adecuada utilización o ejercicio de los recursos económicos otorgados o los bienes adquiridos con dichos recursos, es su responsabilidad, por lo que deberá apegarse a lo establecido en las Reglas de Operación y del Convenio de Ejecución firmado, por cuanto a la comprobación y/o reintegro de los recursos económicos otorgados.<br> 
                l)	Las personas con solicitud aprobada y/o beneficiarias del programa, deberán conducirse con respeto e integridad ante el Gobierno del Estado de Morelos y ante la Secretaría, cumpliendo cabalmente lo establecido en las Reglas de Operación; de no hacerlo, la solicitud de apoyo es susceptible de ser cancelada por incumplimiento.<br>  
            </p>
            <p class="paragraph">
                <span>TERCERA. DEL ESTANDAR DE COMPETENCIA.-</span> Para la entrega del apoyo económico {{$tipoBeneficiario}} manifiesta conocer el procedimiento 
                de entrega de recurso otorgado que se realizará una vez aplicadas las evaluaciones que correspondan por parte del CONOCER y habiéndose dictaminado que cumple con 
                el Estándar de Competencia <b>{{$project->estandar->estandar}}</b> y declarado como “Competentes” y beneficiario(a) del programa, por lo que se procederá efectuar 
                las gestiones pertinentes para otorgar el recurso por concepto de apoyo económico.
            </p>                       
            <p class="paragraph">
                <span>CUARTA. DE LOS RECURSOS ECONÓMICOS OTORGADOS.-</span> Para la adquisición del equipo, mobiliario, insumos y/o materia prima, <b>“LA SECRETARÍA”</b> 
                hará entrega a {{$tipoBeneficiario}} el apoyo consistente en recursos económicos por la cantidad total de <b>$12,000.00 (Doce Mil Pesos 00/100 M.N.),</b> a través de una 
                transferencia electrónica a una tarjeta bancaria que tramitará <b>“LA SECRETARÍA”</b>. A partir del momento en el que {{$tipoBeneficiario}} reciba la tarjeta bancaria, 
                acepta de conformidad que es responsable del ejercicio de los recursos recibidos para la adquisición del equipo, mobiliario, insumos y/o materia prima y que serán nuevos, 
                de acuerdo a lo establecido en la solicitud aprobada.  
            </p>
            <p class="paragraph">
                <b> {{$tipoBeneficiario}}</b> reconoce que los recursos económicos provienen del Poder Ejecutivo del Estado de Morelos, por lo que cualquier incumplimiento en su ejercicio 
                implica una responsabilidad que causa una afectación a la Hacienda Pública, por lo que la Secretaría podrá interponer las acciones legales que considere pertinentes, 
                aún las de carácter penal. 
            </p>
            <p class="paragraph">
                <span>QUINTA. DEL PLAZO DE EJECUCIÓN.-</span> A partir del momento en que {{$tipoBeneficiario}} reciba los recursos económicos, se obliga al 
                estricto cumplimiento de las Reglas de Operación del programa, de la solicitud aprobada y del presente Convenio y se sujeta a los plazos en todos los términos; 
                por tanto, cuenta con <b>10 (DIEZ) días naturales como máximos contados a partir del día en que reciban la tarjeta bancaria, para realizar las adquisiciones del 
                equipo, mobiliario, insumos y/o materia prima.</b>Por ningún motivo y bajo ninguna circunstancia <b>“LA SECRETARÍA”</b> autorizará modificaciones en la solicitud de 
                registro del programa, cualquiera que sea la naturaleza o alcance de dicho cambio. 
            </p>
            <p class="paragraph">
                <span>SEXTA. DE LA COMPROBACIÓN DE LOS RECURSOS ECONÓMICOS OTORGADOS.-</span> {{$tipoBeneficiario}}, manifiesta que conoce y comprende los 
                términos establecidos en el punto 10.7 de las Reglas de Operación del programa, por lo que acepta y está consciente del compromiso que tiene para presentar ante 
                <b>“LA SECRETARÍA”<b> la documentación que compruebe el ejercicio de los recursos recibidos por concepto del apoyo económico la adquisición del equipo, mobiliario, 
                insumos y/o materia prima. Por lo que dicha documentación avalará la cantidad total de $12,000.00 (Doce mil pesos 00/100 M.N.) y se integrará de facturas y/o 
                Comprobantes Fiscales Digitales por Internet (CFDI) y la verificación emitida por el Sistema de Administración Tributaria (SAT) de estos documentos; en su caso 
                y por cuanto, a los recursos económicos no ejercidos en equipo, mobiliario, insumos y/o materia prima, presentará el Comprobante Fiscal Digital por Internet 
                (CFDI) por concepto de reintegro de recursos. Sin excepción toda la documentación señalará su expedición a nombre de {{$tipoBeneficiario}}, y la descripción 
                detallada del concepto o artículo adquirido, el costo unitario, la cantidad de artículos adquiridos, el monto correspondiente a los impuestos y el total; 
                particularmente en los casos de realizarse reintegros de recursos no ejercidos, deberá describir el nombre completo de {{$tipoBeneficiario}}, el número de 
                folio de la solicitud de registro aprobado, el nombre completo del programa y la cantidad total del reintegro. Lo anterior una vez concluido el periodo del 
                ejercicio de recursos, a partir del día siguiente y durante un periodo de 5 (cinco) días hábiles y conforme a lo establecido en los incisos k) y i) del numeral 
                10.7 de las Reglas de Operación.  
                <p>    
            <p class="paragraph">
                {{$tipoBeneficiario}}, se obliga a presentar la documentación que comprueba el ejercicio de los recursos recibidos a través del correo electrónico oficial del 
                programa <a href="mailto:programa,crecemorelos@morelos.gob.mx">programa.crecemorelos@morelos.gob.mx</a> enviando la documentación legible y completa en formato 
                PDF, señalando el nombre completo de {{$tipoBeneficiario}}, y el número de folio de solicitud registrado aprobado; o bien realizando <b>una cita vía telefónica 
                al número 7773.10.06.40 Ext. 66425, para entregar la comprobación presencialmente. En caso de que la o las facturas o CFDI rebasen la cantidad total de 
                $12,000.00 (Doce mil pesos 00/100 M.N.) y en virtud de que la diferencia fue absorbida por la persona beneficiaria bajo su responsabilidad, la comprobación 
                se considerará como completa, una vez cumplimentados los demás criterios de validación, sin que le asista ningún derecho para reclamar su pago a <b>“LA SECRETARÍA”</b>, 
                ni a ninguna otra Dependencia del Gobierno del Estado de Morelos.</b>
                <p>
            <p class="paragraph">
                <span>SÉPTIMA. DEL INCUMPLIMIENTO Y REQUERIMIENTO DE REINTEGRO Y/O ACCIÓN LEGAL.- “LAS PARTES”</span> manifiestan que reconocen y comprenden 
                plenamente el contenido y los alcances de lo establecido en los numerales 10.7 y 10.8 de las Reglas de Operación del programa; por lo que se someten al estricto 
                cumplimiento en todos sus términos; en caso de que {{$tipoBeneficiario}}, realice el uso indebido o desvío de los recursos otorgados para la solicitud aprobada 
                objeto del presente Convenio, presente un documento falso, alterado o duplicado, o bien presente una negativa reiterada hasta por una segunda ocasión para 
                realizar la verificación de la adquisición del equipo, mobiliario, insumos y/o materia prima, <b>“LA SECRETARÍA”</b> iniciará las acciones que considere pertinentes; 
                así mismo se pone de manifiesto particularmente que {{$tipoBeneficiario}}, reconoce que en caso de no presentar la documentación que ampare la comprobación del 
                debido ejercicio de los recursos otorgados en su totalidad conforme a los plazos establecidos en la Cláusula anterior, <b>“LA SECRETARÍA”</b> iniciará de forma inmediata 
                los procedimientos correspondientes a solicitar el reintegro total de los recursos otorgados; en caso de que {{$tipoBeneficiario}}, presente una negativa a 
                realizar el reintegro, debido a la afectación a la Hacienda Pública Estatal por dolo, mala fe, error, violencia o lesión, <b>“LA SECRETARÍA”</b> dará inicio a los 
                procedimientos legales que considere pertinentes, incluso acciones de carácter penal, las cuales deberán ser sancionadas en los términos de las Leyes y disposiciones 
                legales aplicables.
            </p>  
            <p class="paragraph">
                <span>OCTAVA. DEL REINTEGRO DE LOS RECURSOS OTORGADOS.-</span> {{$tipoBeneficiario}} que en el supuesto de incumplimiento a lo establecido en el 
                presente Convenio y/o en las Reglas de Operación del programa, y que por cualquiera que fuere el motivo de éste, le sea requerido el reintegro de los recursos 
                económicos otorgados, se obligan a realizarlo por el total de los recursos otorgados, ante la Secretaría de Hacienda del Poder Ejecutivo del Estado de Morelos, 
                conforme al procedimiento y los plazos que para tal efecto se establezcan en el oficio de requerimiento emitido por parte de <b>“LA SECRETARÍA”</b>. 
            </p>            
            <p class="paragraph">
                <span>NOVENA. DEL SEGUIMIENTO Y VERIFICACIÓN DE LOS RECURSOS EJERCIDOS.-</span> {{$tipoBeneficiario}} reconoce, comprende y acepta de conformidad que 
                <b>“LA SECRETARÍA”</b> realice las actividades de visitas de seguimiento y verificación de los recursos ejercidos derivados del otorgamiento de apoyos económicos 
                a las personas beneficiarias, de conformidad con lo establecido en el numeral 10.8 de las Reglas de Operación del programa; así mismo y en el supuesto de 
                que por cualquier motivo o circunstancia se presente una negativa hasta por una segunda ocasión por parte de {{$tipoBeneficiario}} para llevar a cabo la 
                verificación, <b>“LA SECRETARÍA”</b> dictaminará un incumplimiento a las Reglas de Operación del programa y procederá a ejecutar lo consignado en la Cláusula 
                Séptima del presente Convenio. 
            </p>              
            <p class="paragraph">                
                <b>“LAS PARTES”</b> aceptan que <b>“LA SECRETARÍA”</b> podrá programar y realizar visitas inherentes a actividades de orden institucional u oficial relativas a 
                evaluaciones, verificaciones de control, revisión y/o auditoria, pudiendo ser éstas en acompañamiento o coordinación con organismos fiscalizadores y/o 
                autoridades competentes, hasta por un periodo de tres años posteriores a la vigencia del programa y del presente Convenio.
            </p> 
            <p class="paragraph">
                <span>DÉCIMA. DE LAS RELACIONES LABORALES.-</span> Las relaciones laborales que {{$tipoBeneficiario}} tenga a la fecha de firma del presente Convenio o en 
                el futuro, en ningún supuesto se vinculan, asocian, generan o relacionan jurídica o laboralmente con la Secretaría de Desarrollo Social; siendo 
                {{$tipoBeneficiario}} el único responsable directo de cumplir con todas las obligaciones laborales y fiscales. 

            </p>
            <p class="paragraph">
                <span>DÉCIMO PRIMERA. DE LAS MODIFICACIONES.-</span> El presente Convenio podrá ser modificado o adicionado por mutuo acuerdo entre <b>“LAS PARTES”</b>, siempre que 
                conste por escrito y este sea avalado por <b>“LA SECRETARÍA”</b>. Las modificaciones o adiciones al Convenio de Ejecución obligarán a los signatarios a partir de la 
                fecha de su firma y deberán anexarse al presente, para que forme parte integral del mismo. 
            </p>  
            <p class="paragraph"><span>DÉCIMO SEGUNDA. DE LA CONFIDENCIALIDAD.- “LAS PARTES” </span>se comprometen a respetar la confidencialidad de la información que se 
                genere en virtud del presente Convenio, debiendo realizar los actos necesarios para tal fin, conforme a la normatividad aplicable. Así mismo y en caso de que 
                <b>“LA SECRETARÍA”</b> registre solicitud de información, relacionada a los datos de {{$tipoBeneficiario}} en su calidad de persona beneficiaria del apoyo del 
                Programa, <b>“LA SECRETARÍA”</b> proporcionará la información requerida observando los términos que la Ley de Transparencia y Acceso a la Información Pública del 
                Estado de Morelos, la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados del Estado de Morelos y de las Reglas de Operación del programa. 
            </p>            
            <p class="paragraph">Así mismo {{$tipoBeneficiario}}, está consciente y manifiesta expresamente su conformidad en que la información proporcionada formará parte del 
                Padrón Único de Beneficiarios de Programas Sociales.  
            </p>            
            <p class="paragraph">
                <span>DÉCIMO TERCERA. DE LA TERMINACIÓN ANTICIPADA.-</span> Cualquiera de <b>“LAS PARTES”</b> podrá promover la terminación anticipada del presente Convenio, de acuerdo a su 
                fecha de vencimiento, siempre y cuando conste por escrito y se justifique la imposibilidad de dar cumplimiento a los objetivos del Programa. En este supuesto, 
                {{$tipoBeneficiario}} deberá reintegrar el total de los recursos económicos otorgados por <b>“LA SECRETARÍA”</b>, conforme los términos y plazos que se establezcan para tal 
                fin; así mismo, <b>“LAS PARTES”</b> deberán elaborar y signar un Acta de Hechos para hacer constar los acuerdos establecidos para la terminación anticipada. 
            </p>
            <p class="paragraph">
                <span>DÉCIMO CUARTA. DE LA JURISDICCIÓN.-</span> Las controversias que surjan con motivo de la interpretación y cumplimiento del presente Convenio, se llevará a cabo 
                de común acuerdo entre <b>“LAS PARTES”</b>; en caso de continuar la controversia, <b>“LAS PARTES”</b> se someten a la jurisdicción y competencia de las autoridades en la materia, 
                de la Ciudad de Cuernavaca estado de Morelos, renunciando desde este momento, al fuero que les pudiera corresponder en razón de sus domicilios presentes o futuros.
            </p>
            <p class="paragraph">
                <span>DÉCIMO QUINTA. DE LA VIGENCIA.-</span> El presente Convenio de Ejecución entrará en vigor a partir de su fecha de firma y concluirá el día 31 de diciembre de 
                2022; o bien, hasta el debido cumplimiento de las obligaciones contraídas. 
            </p>
            <p class="paragraph">
                Leído el presente Convenio de Ejecución por <b>“LAS PARTES”</b> que en él intervienen, y una vez comprendido el contenido y los alcances legales, se rubrica en todas sus 
                fojas y firma al calce por triplicado en la Ciudad de Cuernavaca Morelos a los {{\Carbon\Carbon::now()->format('d')}} días del mes de Diciembre de 2022.
            </p>

            <br><br><br><br>
            <h1 class="title-section">POR “LA SECRETARÍA”</h1>
            <table id="sedeso-signs">
                <tr>
                    <td>
                        _________________________________________________<br><br>
                        <strong> ALFONSO DE JESÚS SOTELO MARTÍNEZ
                        <br>SECRETARIO DE DESARROLLO SOCIAL</strong>
                    </td>
                    <td>
                        <br><br>_________________________________________________<br><br>
                        <strong>MELISSA PALOMA VILLADA ARELLANO
                        <br>DIRECTORA GENERAL DE GESTIÓN SOCIAL<br>Y ECONOMÍA SOLIDARIA</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br><br>_________________________________________________<br><br>
                        <strong>NANCY ELIZABETH REYES VIVEROS
                        <br>DIRECTORA DE PROGRAMAS COMPLEMENTARIOS</strong>
                    </td>
                    <td>
                        <b>{{$tipoBeneficiario}}</b>
                        <br><br><br>
                        <br><br><br>_________________________________________________<br><br>                                        
                    </td>
                </tr>
            </table>            
        </div>
    </div>
</body>
</html>