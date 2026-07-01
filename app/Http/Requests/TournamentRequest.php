<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Override;

class TournamentRequest extends FormRequest
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
            'name'   => $this->filled('name') ? trim($this->input('name')) : $this->input('name'),
            'mode'   => $this->filled('mode') ? Str::lower(trim($this->input('mode'))) : $this->input('mode'),
            'status' => $this->filled('status') ? Str::lower(trim($this->input('status'))) : $this->input('status'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('tournament');

        return [
            'game_id'          => 'required|integer|exists:games,id',
            'created_by'       => 'required|integer|exists:users,id',
            'name'             => "required|string|max:255|unique:tournaments,name,{$id}",
            'mode'             => 'required|string|in:solo,team',
            'max_participants' => 'required|integer|min:2',
            'status'           => 'sometimes|required|in:draft,open,ongoing,finished',
            'starts_at'        => 'nullable|date',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'required' => 'O preenchimento deste campo é obrigatório!',
            'max'      => 'O máximo de caracteres que este campo aceita é :max!',
            'min'      => 'Insira um mínimo de :min caracteres!',
            'integer'  => 'Este campo deve ser um número inteiro!',
            'date'     => 'Insira uma data válida!',
            'in'       => 'O valor selecionado é inválido!',
            'game_id.exists'    => 'O jogo informado não existe!',
            'created_by.exists' => 'O usuário informado não existe!',
            'name.unique'       => 'Já existe um torneio com este nome!',
            'max_participants.min' => 'O torneio precisa aceitar no mínimo :min participantes!',
        ];
    }
}
