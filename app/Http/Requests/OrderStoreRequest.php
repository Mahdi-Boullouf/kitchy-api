<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class OrderStoreRequest extends FormRequest {
    public function rules(): array {
        return [
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'wilaya' => 'required|string|max:100',
            'commune' => 'required|string|max:100',
            'exact_address' => 'required|string|max:255',
            'status' => 'in:pending,confirmed,shipped,delivered,cancelled',
            'hidden' => 'boolean',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
