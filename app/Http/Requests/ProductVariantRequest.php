<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // You can add custom authorization logic here if needed
    }

    public function rules()
    {
        return [
            'product_id' => 'required|integer',
            'product_type' => 'required|string|in:shoe,accessory',
            'color' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ];
    }
}
