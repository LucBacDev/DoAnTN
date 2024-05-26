<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Attributes_add_colorRequest extends FormRequest
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
            'name.*' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\Attributes::where('attribute_group_id', 1)
                        ->where('name', $value)
                        ->whereNull('deleted_at')
                        ->exists();
                   
                    if ($exists) {
                        $fail('Tên thuộc tính "' . $value . '" đã tồn tại.');
                    }
                },
         
            ],
        ];
    }
    
    public function messages()
    {
        return [
            'name.*.required' => 'Tên thuộc tính không được để trống',
        ];
    }
}
