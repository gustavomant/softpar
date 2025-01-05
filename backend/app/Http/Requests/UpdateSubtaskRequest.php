<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubtaskRequest extends FormRequest
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
            "subtask_id" => "required|integer|exists:subtasks,id",
            "title" => "nullable|string",
            "subtitle" => "nullable|string",
            "description" => "nullable|string",
            "status" => "nullable|string|in:pending,done,removed",
        ];
    }

    public function messages(): array
    {
        return [
            "subtask_id.required" => "O campo subtask_id é obrigatório.",
            "subtask_id.integer" => "O campo subtask_id deve ser um número inteiro.",
            "subtask_id.exists" => "O ID da subtask fornecido não existe.",
            "title.string" => "O campo title deve ser uma string.",
            "subtitle.string" => "O campo subtitle deve ser uma string.",
            "description.string" => "O campo description deve ser uma string.",
            "status.string" => "O campo status deve ser uma string.",
            "status.in" => "O campo status deve ser um dos seguintes valores: pending, done, removed.",
        ];
    }

}
