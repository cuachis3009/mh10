<?php

namespace App\Http\Requests;

use App\Rules\ValidateCurp;
use Illuminate\Foundation\Http\FormRequest;

class MemberStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'txt-curp' => ['required','size:18',new ValidateCurp],
            "name" => 'required',
            "p_surname" => 'required',
            /*"m_surname" => 'required',*/
            "elector-id" => 'required|size:18',
            "cellphone-number" => "required|digits:10",
            /*"has-disability" => "required",*/
            /*"specify-disability" => "exclude_unless:has-disability,true|required",*/
            /*"specify-disability" => "nullable",*/
            "street-name" => "required",
            "exterior-street-number" => "required",
            //"colony-name" => "required",
            "postal-code" => "required|digits:5",
            /*"municipio-name" => "required",
            "estado-name" => "required",*/
            "year-id-validity" => "required|digits:4",
            //"monthly-income" => "required|integer|min:1",
            //"employment" => "required",
            //"dependent-ids" => "required",
            /*"people-live-in-house" => "nullable|integer|min:0",
            "number-rooms-as-bedroom" => "nullable|integer|min:0",
            "years-experience-project" => "nullable|integer|min:0",
            "number-of-bathrooms" => "nullable|integer|min:0",*/
            //"doc-carta" => "required|mimetypes:application/pdf|file|max:2000",
            "doc-official-id" => "mimetypes:application/pdf|file|max:2000",
            "doc-curp" => "mimetypes:application/pdf|file|max:2000",
            //"doc-constancia" => "mimetypes:application/pdf|file|max:2000",
            /*"water" => "required",*/
            "email" => "required|email|unique:App\Member,email",
            "municipio-zap" => "required",
            //"localidad-zap" => "required",
            //"colonia-zap" => "required",
            "loc_col-zap" => "required",
            //"member-rfc" => "required",
            //"member-status_rfc" => "required",            
            //"member-discharge_date_rfc" => "required",            
            "read-CN" => "required",   
            //"read-CZAP" => "required",               
            "tipo_vialidad" => "required",
            "tipo_asentamiento" => "required",
            "member_age" => "required",
            "member-sex" => "required",
            "study_member"=>"required",
            "referencia_domicilio"=>"required",
        ];
    }

    public function messages(){
        return [
            'txt-curp.required' => 'Ingresa tu curp.',
            'name.required' => 'Ingresa tu nombre(s).',
            'p_surname.required' => 'Ingresa tu apellido paterno.',
            /*'m_surname.required' => 'Ingresa tu apellido materno.',*/
            "elector-id.required" =>  "Ingresa la clave de elector de tu INE/IFE.",
            "elector-id.size" => "La clave de elector debe tener al menos 18 caracteres",           
            "cellphone-number.required" => "Ingresa tu número de teléfono celular.",
            "cellphone-number.digits" => "El número de teléfono celular debe ser de al menos 10 digitos, incluyendo la Lada.",
            "street-name.required" => "Ingresa el nombre de tu calle.",
            "exterior-street-number.required" => "Ingresa el numero exterior.",
            //"colony-name.required" => "Ingresa el nombre de tu colonia.",
            "postal-code.required" => "Ingresa tu código postal.",
            "postal-code.digits" => "El código postal debe estar compuesto por 5 digitos.",
            //"municipio-name.required" => "Ingresa el nombre de tu municipio.",
            //"estado-name.required" => "Ingresa el nombre de tu estado.",
            "year-id-validity.required" => "Selecciona el año de vigencia de tu INE/IFE.",
            "year-id-validity.digits" => "El año de la vigencia de tu INE/IFE debe estar compuesta por 4 digitos.",
            /*
            "monthly-income.required" => "Escribe el monto aproximado de ingresos que tiene la familia.",
            "monthly-income.integer" => "El monto aproximado de ingresos no debe contener signo de $ ó decimales, solo números enteros.",
            "monthly-income.min" => "Ingresa un monto aproximade de ingresos de la familia valido, recuerda que debe ser mayor a 0.",
            */
            //"employment.required" => "Ingresa tu actividad laboral o productiva",
            "dependent-ids.required" => "Debes ingresar al menos un dependiente economico",
            /*"doc-carta.required" => "Selecciona el archivo de tu carta",
            "doc-carta.mimetypes" => "El archivo de tu carta debe ser en formato PDF",
            "doc-carta.max" => "El archivo de tu carta no debe superar los 2MB",*/
            "doc-official-id.required" => "Selecciona el archivo de tu INE/IFE",
            "doc-official-id.mimetypes" => "El archivo de tu INE/IFE debe ser en formato PDF",
            "doc-official-id.max" => "El archivo de tu INE/IFE no debe superar los 2MB",
            "doc-curp.required" => "Selecciona el archivo de tu CURP",
            "doc-curp.mimetypes" => "El archivo de tu CURP debe ser en formato PDF",
            "doc-curp.max" => "El archivo de tu CURP no debe superar los 2MB",
            /*"doc-constancia.required" => "Selecciona el archivo de tu constancia",
            "doc-constancia.mimetypes" => "El archivo de tu constancia debe ser en formato PDF",
            "doc-constancia.max" => "El archivo de tu constancia no debe superar los 2MB",
            "number-rooms-as-bedroom.min" => "El número mínimo para este campo es 0",
            "years-experience-project.min" => "El número mínimo para este campo es 0",
            "number-of-bathrooms.min" => "El número mínimo para este campo es 0",*/
            "email.required" => "Debes ingresa un correo",
            "email.email" => "Ingresa un correo valido",
            "email.unique" => "El correo electrónico que estas ingresando, ya fue registrado anteriormente. Ingresa uno diferente",
            "municipio-zap.required" => "Selecciona tu municipio",
            //"localidad-zap.required" => "Selecciona tu localidad",
            //"colonia-zap.required" => "Selecciona tu colonia",
            "loc_col-zap.required" => "Selecciona tu localidad o colonia",
            //'member-rfc.required' => 'Ingresa tu RFC.',
            //'member-status_rfc.required' => 'Selecciona el estado del RFC.',           
            //'member-discharge_date_rfc.required' => 'Selecciona la fecha de alta',  
            "read-CN.required" => "Confirmar nombre",               
            //"read-CZAP.required" => "Confirmar domicilio en Zona de Atención Prioritaria",               
            "tipo_vialidad.required" => "Selecciona el tipo vialidad",
            "tipo_asentamiento.required" => "Selecciona el tipo de asentamiento",
            "member_age.required" => "Debes ingresar tu edad",
            "member-sex.required" => "Selecciona el sexo",
            "study_member.required" => "Selecciona el nivel máximo de estudios",
            "referencia_domicilio.required"=>"Ingresa la referencia de tu domicilio",
        ];
    }
}
