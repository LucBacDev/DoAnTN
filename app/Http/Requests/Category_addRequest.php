<?php

namespace App\Http\Requests;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class Category_addRequest extends FormRequest
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
            // 'name' => 'required|unique:Categories,name,NULL,id,parent_id,'.Auth::user() -> id.'',
            // 'name' => 'required|distinct:name|unique:Categories,name,parent_id,'. Auth::id()
            'name' => 'required|distinct:name|unique:Categories,name,parent_id,id'

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên Danh Mục không được để trống',
            'name.unique' => 'Tên Đã Được Sử Dụng',
           

        ];
    }
}
