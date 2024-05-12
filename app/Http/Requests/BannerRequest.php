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
        'name' => 'required|unique:banners|max:255', // Thay 'table_name' bằng tên bảng thực tế của bạn
        'image' => 'required|mimes:jpeg,jpg,png,gif,webp',
        'status' => 'required|in:0,1',
        'category_id' => 'required|exists:categories,id', // Thay 'categories' bằng tên bảng danh mục thực tế của bạn
    ];
}

public function messages()
{
    return [
        'name.required' => 'Tên Danh Mục không được để trống',
        'name.unique' => 'Tên Danh Mục đã tồn tại',
        'name.max' => 'Tên Danh Mục không được vượt quá 255 ký tự',
        'image.required' => 'Ảnh không được để trống',
        'image.mimes' => 'Ảnh phải có định dạng jpeg, jpg, png, gif, hoặc webp',
        'status.required' => 'Trạng thái không được để trống',
        'status.in' => 'Trạng thái không hợp lệ',
        'category_id.required' => 'Danh mục không được để trống',
        'category_id.exists' => 'Danh mục không tồn tại',
    ];
}
}
