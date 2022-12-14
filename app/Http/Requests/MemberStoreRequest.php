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
            "employment" => "required",
            "family_head" => "required", 
            "has_desability" => "required", 
            "dependent" => "required", 
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
            "municipio" => "required",
            //"localidad-zap" => "required",
            //"colonia-zap" => "required",
            "loc_col" => "required",
            "domicilioINE" => "required",
            //"member-rfc" => "required",
            //"member-status_rfc" => "required",            
            //"member-discharge_date_rfc" => "required",            
            "read-CN" => "required",   
            //"read-CZAP" => "required",               
            "tipo_vialidad" => "required",
            "tipo_asentamiento" => "required",
            //"member_age" => "required",
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
            "cellphone-number.required" => "Ingresa tu n??mero de tel??fono celular.",
            "cellphone-number.digits" => "El n??mero de tel??fono celular debe ser de al menos 10 digitos, incluyendo la Lada.",
            "street-name.required" => "Ingresa el nombre de tu calle.",
            "exterior-street-number.required" => "Ingresa el numero exterior.",
            //"colony-name.required" => "Ingresa el nombre de tu colonia.",
            "postal-code.required" => "Ingresa tu c??digo postal.",
            "postal-code.digits" => "El c??digo postal debe estar compuesto por 5 digitos.",
            //"municipio-name.required" => "Ingresa el nombre de tu municipio.",
            //"estado-name.required" => "Ingresa el nombre de tu estado.",
            "year-id-validity.required" => "Selecciona el a??o de vigencia de tu INE/IFE.",
            "year-id-validity.digits" => "El a??o de la vigencia de tu INE/IFE debe estar compuesta por 4 digitos.",
            /*
            "monthly-income.required" => "Escribe el monto aproximado de ingresos que tiene la familia.",
            "monthly-income.integer" => "El monto aproximado de ingresos no debe contener signo de $ ?? decimales, solo n??meros enteros.",
            "monthly-income.min" => "Ingresa un monto aproximade de ingresos de la familia valido, recuerda que debe ser mayor a 0.",
            */
            "employment.required" => "Ingresa tu ocupaci??n",
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
            "number-rooms-as-bedroom.min" => "El n??mero m??nimo para este campo es 0",
            "years-experience-project.min" => "El n??mero m??nimo para este campo es 0",
            "number-of-bathrooms.min" => "El n??mero m??nimo para este campo es 0",*/
            "email.required" => "Debes ingresa un correo",
            "email.email" => "Ingresa un correo valido",
            "email.unique" => "El correo electr??nico que estas ingresando, ya fue registrado anteriormente. Ingresa uno diferente",
            "municipio.required" => "Selecciona tu municipio",
            //"localidad-zap.required" => "Selecciona tu localidad",
            //"colonia-zap.required" => "Selecciona tu colonia",
            "family_head.required" => "Selecciona si es jefa o jefe de familia", 
            "has_desability.required" => "Selecciona si cuentas con discapacidad", 
            "dependent.required" => "Ingresa el n??mero de dependientes econ??micos", 
            
            "loc_col.required" => "Ingresa el nombre de tu localidad o colonia",
            "domicilioINE.required" => "Ingresa el domicilio id??ntico a como esta en tu INE o IFE",            
            //'member-rfc.required' => 'Ingresa tu RFC.',
            //'member-status_rfc.required' => 'Selecciona el estado del RFC.',           
            //'member-discharge_date_rfc.required' => 'Selecciona la fecha de alta',  
            "read-CN.required" => "Confirmar nombre",               
            //"read-CZAP.required" => "Confirmar domicilio en Zona de Atenci??n Prioritaria",               
            "tipo_vialidad.required" => "Selecciona el tipo vialidad",
            "tipo_asentamiento.required" => "Selecciona el tipo de asentamiento",
            //"member_age.required" => "Debes ingresar tu edad",
            "member-sex.required" => "Selecciona el sexo",
            "study_member.required" => "Selecciona el nivel m??ximo de estudios",
            "referencia_domicilio.required"=>"Ingresa la referencia de tu domicilio",
        ];
    }
}
