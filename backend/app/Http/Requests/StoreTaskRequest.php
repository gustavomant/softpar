<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
    public function messages(): array
    {
        return [
            "title.required" => "O título é obrigatório.",
            "title.string" => "O título deve ser um texto válido.",
            "subtitle.required" => "O subtítulo é obrigatório.",
            "subtitle.string" => "O subtítulo deve ser um texto válido.",
            "description.required" => "A descrição é obrigatória.",
            "description.string" => "A descrição deve ser um texto válido.",
            "due_date.required" => "A data de vencimento é obrigatória.",
            "due_date.date_format" => "A data de vencimento deve estar no formato YYYY-MM-DD.",
        ];
    }

}
