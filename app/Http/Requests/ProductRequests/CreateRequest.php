<?php

namespace App\Http\Requests\ProductRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to true to allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // dd(request()->all());
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation rules
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:new,old',
            'price' => 'required|numeric|min:0',
            'item_types' => 'nullable|array',
            'item_types.*' => 'exists:item_types,id',
            'items' => 'nullable|array',
            'items.*' => 'array', // Ensure each item type has an array of item IDs
            'items.*.*' => 'required|integer|exists:items,id', // Validate each item ID
            'sizes' => 'nullable|array',
            'sizes.*.size_id' => 'required|integer|exists:sizes,id',
            'sizes.*.price' => 'nullable|numeric|min:0',
        ];

        // Add unique rule for name during creation
        if ($this->isMethod('post')) {
            $rules['name'] .= '|unique:products,name';
        }

        // Add unique rule for name during update, ignoring the current product
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'; // Add image validation rules

            $rules['name'] .= '|unique:products,name,'.$this->route('product');
        }

        return $rules;
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'name.unique' => 'The product name already exists.',
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category is invalid.',
            'type.required' => 'The product type is required.',
            'type.in' => 'The product type must be either "new" or "old".',
            'price.required' => 'The product price is required.',
            'price.numeric' => 'The product price must be a number.',
            'price.min' => 'The product price must be at least 0.',
            'item_types.array' => 'The item types must be an array.',
            'item_types.*.exists' => 'One or more selected item types are invalid.',
            'sizes.array' => 'The sizes must be an array.',
            'sizes.*.size_id.exists' => 'One or more selected sizes are invalid.',
            'sizes.*.price.numeric' => 'The price for each size must be a number.',
            'sizes.*.price.min' => 'The price for each size must be at least 0.',
        ];
    }
}
