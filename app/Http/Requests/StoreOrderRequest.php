<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address_id' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'address_id.required' => 'Tenés que elegir una dirección de envío para confirmar el pedido.',
        ];
    }
}
