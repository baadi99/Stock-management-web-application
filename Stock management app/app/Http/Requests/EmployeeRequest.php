<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the employee is authorized to make this request.
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
    public function rules()
    {
        $phone_rules = array('required');
        $email_rules = array('required', 'email');
        if(request()->isMethod('POST')){
            array_push($phone_rules, 'unique:users');
            array_push($email_rules, 'unique:users');
        } 

        return [
            'first_name' => 'required', 
            'last_name' => 'required', 
            'address' => 'required', 
            'phone_number' => $phone_rules, 
            'email' => $email_rules
        ];
    }
}
