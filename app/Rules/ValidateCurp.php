<?php

namespace App\Rules;

use App\Member;
use Illuminate\Contracts\Validation\Rule;

class ValidateCurp implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
        $curp_exist = Member::where(["curp" => $value,"web_registration" => true])->first();
        return ($curp_exist == null) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La curp que estas ingresando ya esta registrada';
    }
}
