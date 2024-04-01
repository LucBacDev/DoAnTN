<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Attributes_addRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|distinct:name|unique:attributes',
            
           
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên thuộc tính không được để trống',
            'name.unique' => 'Tên thuộc tính đã có',
            
        ];
    }
}
