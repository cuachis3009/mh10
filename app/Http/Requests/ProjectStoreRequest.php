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
            "tipo_estandar" => "required",       
            "project-experience-time"=>"required",
            "project-objective"=>"required",
            "project-activity-description"=>"required",
            "read-CDE" => "required",  
            "read-CCB" => "required",  
            "item-ids" => "required",
            "chkList" => "required",
        ];
    }

    public function messages(){
        return [
            "tipo_estandar.required" => "Selecciona el giro del proyecto",
            "project-experience-time.required"=>"Ingresa el tiempo de experiencia",
            "project-objective.required"=>"Ingresa el objetivo del proyecto",          
            "project-activity-description.required"=>"Ingresa las actividades que usted realizará en el proyecto",
            "read-CDE.required" => "Confirmar que se encuentra sin empleo",               
            "read-CCB.required" => "Confirmar que cuenta con los conocimientos básicos, habilidades y destrezas del Estándar de Competencia",  
            "item-ids.required" => "Debes ingresar al menos un artículo",
            "chkList.required" => "Debes seleccionar al menos un conocimiento de competencia laboral",

            
        ];
    }

}
