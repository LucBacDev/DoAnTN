<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class BannerRequest extends FormRequest
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
            'name' => 'required|distinct:name',
            'image' => 'mimes:jpeg,jpg,png,gif,webp|required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên Danh Mục không được để trống',
            'name.unique' => 'Tên Đã Được Sử Dụng',
            'image.required' => 'Ảnh không được để trống',
            'image.mimes' => 'Ảnh phải là định dạng jpeg,jpg,png,gif',
        ];
    }
}
