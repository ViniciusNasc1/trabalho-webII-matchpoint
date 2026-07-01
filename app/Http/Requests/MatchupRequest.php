<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;
use Illuminate\Support\Str;

class MatchupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
        {
            $this->merge([
                'round_label' => $this->filled('round_label')
                    ? Str::upper(trim($this->input('round_label')))
                    : $this->input('round_label'),
                'status' => $this->filled('status')
                    ? Str::lower(trim($this->input('status')))
                    : $this->input('status'),
            ]);
        }

    public function rules(): array
    {
        return [
            'tournament_id'      => 'required|integer|exists:tournaments,id',
            'round_number'       => 'required|integer|min:1',
            'round_label'        => 'required|string|max:255',
            'participant_a_type' => 'required|string|max:255',
            'participant_a_id'   => 'required|integer|min:1',
            'participant_b_type' => 'nullable|required_with:participant_b_id|string|max:255',
            'participant_b_id'   => 'nullable|required_with:participant_b_type|integer|min:1',
            'winner_type'        => 'nullable|required_with:winner_id|string|max:255',
            'winner_id'          => 'nullable|required_with:winner_type|integer|min:1',
            'status'             => 'sometimes|required|in:pending,ongoing,finished',
            'scheduled_at'       => 'nullable|date',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'required'      => 'O preenchimento deste campo é obrigatório!',
            'max'           => 'O máximo de caracteres que este campo aceita é :max!',
            'min'           => 'Insira um mínimo de :min caracteres!',
            'integer'       => 'Este campo deve ser um número inteiro!',
            'date'          => 'Insira uma data válida!',
            'in'            => 'O valor selecionado é inválido!',
            'required_with' => 'Este campo é obrigatório junto com o campo relacionado!',
            'tournament_id.exists' => 'O torneio informado não existe!',
        ];
    }
}
