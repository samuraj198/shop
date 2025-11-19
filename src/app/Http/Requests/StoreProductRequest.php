<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:products,name',
            'description' => 'required|string',
            'price' => 'required|integer|min:100',
            'discount' => 'nullable|integer|min:0|max:99',
            'specifications' => 'required|json',
            'category_id' => 'required|integer|exists:categories,id',

        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Такой продукт уже существует',
            'price.min' => 'Минимальная цена продукта 100 ₽',
            'discount.min' => 'Скидка не может быть отрицательной',
            'discount.max' => 'Максимальная скидка 99 %',
            'specifications.json' => 'Неверный формат характеристик',
            'category_id.exists' => 'Такой категории не существует',
        ];
    }
}
