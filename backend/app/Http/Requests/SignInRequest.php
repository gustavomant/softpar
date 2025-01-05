<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email",
            "password" => "required|string"
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "O campo email é obrigatório.",
            "email.email" => "O campo email deve ser um endereço de e-mail válido.",
            "password.required" => "O campo password é obrigatório.",
            "password.string" => "O campo password deve ser uma string.",
        ];
    }

}
