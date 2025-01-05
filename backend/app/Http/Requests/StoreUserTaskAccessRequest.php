<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserTaskAccessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "task_id" => "required|exists:tasks,id",
            "user_email" => "required|exists:users,email",
            "access_type" => "required|in:read,write",
        ];
    }

    public function messages(): array
    {
        return [
            "task_id.required" => "O campo task_id é obrigatório.",
            "task_id.exists" => "O ID da tarefa fornecido não existe.",
            "user_email.required" => "O campo user_email é obrigatório.",
            "user_email.exists" => "O e-mail fornecido não foi encontrado no sistema.",
            "access_type.required" => "O campo access_type é obrigatório.",
            "access_type.in" => "O valor do campo access_type deve ser read ou write.",
        ];
    }
}
