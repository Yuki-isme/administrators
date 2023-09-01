<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|min:3|max:25',
            'category_id' => ['required', 'integer', 'not_in:0'],
            'brand_id' => ['required', 'integer', 'not_in:0'],
            'sku' => 'required',
            'description' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image',
            'catalog' => 'required|array', // Kiểm tra xem catalog là một mảng
            'catalog.*' => 'image|image', // Kiểm tra từng phần tử trong mảng là một tệp hợp lệ
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bạn phải nhập tên của sản phẩm!',
            'name.min' => 'Tên Danh mục tối thiểu là 3 ký tự!',
            'name.max' => 'Tên Danh mục không vượt quá 25 ký tự!',
            'category_id.not_in' => 'Bạn phải chọn đủ danh mục!',
            'category_id.required' => 'Bạn phải chọn đủ danh mục!',
            'brand_id.not_in' => 'Bạn phải chọn thương hiệu!',
            'brand_id.required' => 'Bạn phải chọn thương hiệu!',
            'sku.required' => 'Bạn phải nhập tên của sản phẩm!',
            'thumbnail.required' => 'Bạn phải tải lên ảnh!',
            'thumbnail.image' => 'Bạn phải tải định dạng ảnh!',
            'catalog.required' => 'Bạn phải tải lên ảnh!',
            'catalog.image' => 'Bạn phải tải định dạng ảnh!',
        ];
    }
}
