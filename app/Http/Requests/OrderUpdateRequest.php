<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest {
    public function rules(): array {
        return [
            'status' => 'in:pending,confirmed,shipped,delivered,cancelled',
            'hidden' => 'boolean',
        ];
    }
}