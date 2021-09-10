<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Authorisation is handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //Adding the unique rule dynamically, this solves the problem of product already exist
        //when updating a product

        $label_rules = array(0 => 'required');
        if(request()->isMethod('POST')){
            array_push($label_rules, 'unique:products');
        } 

        return [
            'label' => $label_rules,
            'description' => 'required',
            'category_id' => 'required',
            'quantity' => 'required|numeric|min:1',
            'supplier_id' => 'required',
            'buying_cost' => 'required|numeric|min:1',
            'selling_cost' => 'required|numeric|min:1'
        ];
    }
    /**
     * Overriding the default messages 
    */
    public function messages()
    {
        return [
            'label.unique' => 'Product already exists!',
            'quantity.min' => 'Please choose a higher quantity!'
        ];
    }
}
