<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //handled with middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //Solves the 'email/phone number already exists problem when trying to update existing suppliers
        $emailRules = array('required', 'email');
        $phoneRules = array('required');
        if(request()->isMethod('POST')) {
            array_push($emailRules, 'unique:suppliers');
            array_push($phoneRules, 'unique:suppliers');
        }

        return [
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'email' => $emailRules,
            'address' => 'required',
            'phone_number' => $phoneRules
        ];
    }

    /**
     * Overriding the default messages 
    */
    public function messages()
    {
        return [
            
        ];
    }
}
