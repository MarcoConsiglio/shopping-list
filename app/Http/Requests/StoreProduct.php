<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"          => [
                "required",
                "min:3",
                "max:50"
            ],
            "brand"         => [
                "nullable",
                "max:50"
            ],
            "price"         => [
                "nullable",
                "numeric",
                "min:0",
                "max:1000"
            ],
            "quantity"      => [
                "numeric",
                "min:1",
                "max:1000"
            ],
            "cart_quantity" => [
                "nullable",
                "numeric",
                "min:0",
                "max:1000"
            ],
            "measure"       => [
                "nullable",
                "string"
            ],
            "note"          => [
                "nullable",
                "string"
            ]
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $quantity = $this->measure ? (float) $this->quantity : $this->quantity;
        $cart_quantity = $this->measure ? (float) $this->cart_quantity : $this->cart_quantity;
        $this->merge([
            "price" => (float) $this->price,
            "quantity" => $quantity,
            "cart_quantity" => $cart_quantity
        ]);
    }
}
