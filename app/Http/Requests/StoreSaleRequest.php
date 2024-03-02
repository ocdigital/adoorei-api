<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class StoreSaleRequest extends FormRequest
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
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.amount' => 'required|integer|min:1'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            'products.required' => 'Products is required',
            'products.*.id.required' => 'Product id is required',
            'products.*.id.exists' => 'Product not found',
            'products.*.amount.required' => 'Product amount is required',
            'products.*.amount.integer' => 'Product amount must be an integer',
            'products.*.amount.min' => 'Product amount must be at least 1'
        ];
    }

    /**
     * Validate if products exist
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateProductsExist($validator);
        });
    }

    private function validateProductsExist($validator)
    {
        $products = $this->input('products');

        foreach ($products as $product) {
            if (!Product::find($product['id'])) {
                $validator->errors()->add('products', 'Product not found');
            }
        }
    }
}
