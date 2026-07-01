<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Override;

class TeamRequest extends FormRequest
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
            'name' => $this->filled('name') ? trim($this->input('name')) : $this->input('name'),
            'tag'  => $this->filled('tag') ? Str::upper(trim($this->input('tag'))) : $this->input('tag'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('team');

        return [
            'owner_id' => 'required|integer|exists:users,id',
            'name'     => "required|string|max:255|unique:teams,name,{$id}",
            'tag'      => "required|string|max:10|unique:teams,tag,{$id}",
            'logo_url' => 'nullable|url|max:500',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'required' => 'O preenchimento deste campo é obrigatório!',
            'max'      => 'O máximo de caracteres que este campo aceita é :max!',
            'integer'  => 'Este campo deve ser um número inteiro!',
            'owner_id.exists' => 'O usuário informado não existe!',
            'name.unique'      => 'Já existe um time com este nome!',
            'tag.unique'       => 'Já existe um time com esta tag!',
            'logo_url.url'     => 'Insira uma URL válida!',
        ];
    }
}
