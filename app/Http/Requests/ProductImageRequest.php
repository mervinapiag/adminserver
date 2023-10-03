<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductImageRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // You can add custom authorization logic here if needed
    }

    public function rules()
    {
        return [
            'imageable_id' => 'required|integer',
            'imageable_type' => 'required|string|in:shoe,accessory',
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
