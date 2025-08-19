<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'net_price' => 'required|integer|min:0|lte:price',
            'active' => 'boolean',
            'colors' => 'array',
            'colors.*' => 'integer|exists:colors,id',
            'images' => 'array',
            'images.*.path' => 'required|string',
            'images.*.is_primary' => 'boolean',
            'images.*.sort_order' => 'integer|min:0',
        ];
    }
}