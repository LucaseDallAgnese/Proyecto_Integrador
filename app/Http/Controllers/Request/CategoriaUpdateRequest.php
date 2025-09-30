<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaUpdateRequest extends FormRequest
{
    public function authorize(): boolval
    {
        return true;
    }

    public function rules(): array
    {
        return[
            'name'=>'required|string|max:100',
            'description'=> 'nullable|string',
        ];
    }
}