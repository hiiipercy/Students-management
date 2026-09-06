<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; 

class StudentStoreRequest extends FormRequest
{

//    Determine if the user is authorized to make this request.
   
    public function authorize(): bool
    {
       
        return Auth::check(); 
    }


    //  Get the validation rules that apply to the request.

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'class_id.required' => 'The class field is required.',
            'class_id.exists' => 'The selected class is invalid.',
            'section_id.required' => 'The section field is required.',
            'section_id.exists' => 'The selected section is invalid.',
        ];
    }
}
