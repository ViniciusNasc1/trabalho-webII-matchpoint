<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class ResultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'score_a' => $this->filled('score_a') ? trim($this->input('score_a')) : $this->input('score_a'),
            'score_b' => $this->filled('score_b') ? trim($this->input('score_b')) : $this->input('score_b'),
            'notes'   => $this->filled('notes') ? trim($this->input('notes')) : $this->input('notes'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'match_id'      => 'required|integer|exists:matches,id',
            'registered_by' => 'required|integer|exists:users,id',
            'score_a'       => 'required|string|max:10',
            'score_b'       => 'required|string|max:10',
            'notes'         => 'nullable|string|max:1000',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'required' => 'O preenchimento deste campo é obrigatório!',
            'max'      => 'O máximo de caracteres que este campo aceita é :max!',
            'integer'  => 'Este campo deve ser um número inteiro!',
            'match_id.exists'      => 'A partida informada não existe!',
            'registered_by.exists' => 'O usuário informado não existe!',
        ];
    }
}
