<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
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
            "tipo_curso" => "required",       
            "tipo_curso_s"=>"required",
            "tipo_curso_t"=>"required",
            "municipio_sede"=>"required",
            "municipio_sede_s" => "required",  
            "municipio_sede_t" => "required",              
        ];
    }

    public function messages(){
        return [
            "tipo_curso.required" => "Selecciona el giro del proyecto",
            "tipo_curso_s.required" => "Selecciona el giro del proyecto",
            "tipo_curso_t.required" => "Selecciona el giro del proyecto",
            "municipio_sede.required" => "Selecciona el giro del proyecto",
            "municipio_sede_s.required" => "Selecciona el giro del proyecto",
            "municipio_sede_t.required" => "Selecciona el giro del proyecto",            
        ];
    }

}
