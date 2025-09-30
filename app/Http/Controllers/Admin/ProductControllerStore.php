<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): boolval
    {
        return true;
    }
    public function rules(): array
    {
        return[
            'name'=> 'required|string|max:100',
            'description'=> 'nullable|string',
            'price'=>'required|numeric',
            'stock'=>'required|integer|min:0',
            'image'=>'nullable|image|max:2048',
            'category_id'=> 'nullable|exists:categories,id',
        ];
    }
}