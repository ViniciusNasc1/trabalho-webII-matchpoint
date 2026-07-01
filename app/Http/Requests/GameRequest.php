<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class GameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('games');
        return [
            'name'      => "required|string|max:200|unique:games,name,{$id}",
            'platform'  => 'required|string|max:100',
            'image_url' => 'nullable|url|max:500',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'required' => 'O preenchimento deste campo é obrigatório!',
            'max'      => 'O máximo de caracteres que este campo aceita é :max!',
            'min'      => 'Insira um mínimo de :min caracteres!',
            'name.unique' => 'Um jogo com este nome já foi cadastrado!',
            'image_url.url' => 'Insira uma URL válida!',
        ];
    }
}