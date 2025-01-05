<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            "title" => "nullable|string",
            "subtitle" => "nullable|string",
            "description" => "nullable|string",
            "due_date" => "nullable|date_format:Y-m-d", 
            "status" => "nullable|in:pending,done,removed",
        ];
    }

    public function messages(): array
    {
        return [
            "task_id.required" => "O campo task_id é obrigatório.",
            "task_id.exists" => "O ID da tarefa fornecido não existe.",
            "title.string" => "O campo title deve ser uma string.",
            "subtitle.string" => "O campo subtitle deve ser uma string.",
            "description.string" => "O campo description deve ser uma string.",
            "due_date.date_format" => "O campo due_date deve estar no formato YYYY-MM-DD.",
            "status.in" => "O campo status deve ser um dos seguintes valores: pending, done, removed.",
        ];
    }

}
