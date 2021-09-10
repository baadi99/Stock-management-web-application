<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //hand that responsability to middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if(request()->routeIs('checkCredentials')){

            return ['email' => 'required|email', 
                    'password' => 'required'];

        } else if(request()->routeIs('profile.update')) {

            return ['first_name' => 'required', 
                    'last_name' => 'required', 
                    'address' => 'required', 
                    'phone_number' => ['required', Rule::unique('users')->ignore($this->user->id)], 
                    'email' => ['required', 'email', Rule::unique('users')->ignore($this->user->id)], 
                    'password' => 'required'
                ];
        }
        
    }
}
