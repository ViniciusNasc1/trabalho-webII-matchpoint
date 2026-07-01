<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class TournamentParticipantRequest extends FormRequest
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
            'participant_type' => $this->filled('participant_type')
                ? trim($this->input('participant_type'))
                : $this->input('participant_type'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('tournament_participant');

        return [
            'tournament_id'     => 'required|integer|exists:tournaments,id',
            'participant_type'  => 'required|string|max:255',
            'participant_id'    => [
                'required',
                'integer',
                'min:1',
                Rule::unique('tournament_participants', 'participant_id')
                    ->where('tournament_id', $this->input('tournament_id'))
                    ->where('participant_type', $this->input('participant_type'))
                    ->ignore($id),
            ],
            'registered_at' => 'nullable|date',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'required' => 'O preenchimento deste campo é obrigatório!',
            'integer'  => 'Este campo deve ser um número inteiro!',
            'date'     => 'Insira uma data válida!',
            'tournament_id.exists'    => 'O torneio informado não existe!',
            'participant_id.unique'   => 'Este participante já está inscrito neste torneio!',
        ];
    }
}
