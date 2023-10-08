<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShoeRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // You can add custom authorization logic here if needed
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'image' => $this->isMethod('patch') ? 'sometimes|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
