<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "cart_quantity" => [
                "numeric",
                "min:0",
                "max:1000"
            ]
        ];
    }
}
