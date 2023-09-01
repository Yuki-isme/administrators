<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:15',
            'description' => 'required',
            'thumbnail' => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bạn phải nhập tên của Danh mục!',
            'name.min' => 'Tên Danh mục tối thiểu là 3 ký tự!',
            'name.max' => 'Tên Danh mục không vượt quá 10 ký tự!',
            'thumbnail.required' => 'Bạn phải tải lên ảnh!',
            'thumbnail.image' => 'Bạn phải tải định dạng ảnh!',
        ];
    }
}
