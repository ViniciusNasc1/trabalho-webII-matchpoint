<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Override;

class TeamMemberRequest extends FormRequest
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
        $status = $this->filled('status') ? Str::lower(trim($this->input('status'))) : $this->input('status');

        $this->merge([
            'status'     => $status,
            'joined_at'  => $status === 'active' && !$this->filled('joined_at')
                ? now()
                : $this->input('joined_at'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('team_member');

        return [
            'team_id' => 'required|integer|exists:teams,id',
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
                Rule::unique('team_members', 'user_id')
                    ->where('team_id', $this->input('team_id'))
                    ->ignore($id),
            ],
            'status'     => 'sometimes|required|in:active,invited,removed',
            'joined_at'  => 'nullable|date',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'required' => 'O preenchimento deste campo é obrigatório!',
            'integer'  => 'Este campo deve ser um número inteiro!',
            'date'     => 'Insira uma data válida!',
            'in'       => 'O valor selecionado é inválido!',
            'team_id.exists' => 'O time informado não existe!',
            'user_id.exists' => 'O usuário informado não existe!',
            'user_id.unique' => 'Este usuário já faz parte deste time!',
        ];
    }
}
