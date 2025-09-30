<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class CartAddRequest extends FormRequest
{
    public function authorize(): boolval
    {
        return true;
    }

    public function rules(): array
    {
        return[
            'quantity'=> 'required|integer|min:1',
        ];
    }
}
