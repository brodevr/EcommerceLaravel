<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'role'  => ['required', Rule::in(array_column(Role::cases(), 'value'))],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email'    => 'El email no tiene un formato válido.',
            'email.unique'   => 'Ya existe otro usuario con ese email.',
            'role.required'  => 'El rol es obligatorio.',
            'role.in'        => 'El rol seleccionado no es válido.',
        ];
    }
}
