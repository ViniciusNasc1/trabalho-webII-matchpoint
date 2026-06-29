<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Override;

class GameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    #[Override]
    protected function prepareForValidation()
    {
        $this->merge(
            collect($this->all())->map(function ($value) {
                return is_string($value) ? Str::upper($value) : $value;
            })->toArray()
        );
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('games');
        return [
            'nome' => "required|max:200|unique:nome,{$id}",
            'platform' => 'required|max:100'
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            "required" => "O preenchimento deste campo é obrigatório!",
            "max" => "O máximo de caracteres que este campo aceita é [:max]!",
            "min" => "Insira um mínimo de [:min] caracteres!",
            "nome.unique" => "Um jogo com este nome já foi cadastrado!"
        ];
    }
}
