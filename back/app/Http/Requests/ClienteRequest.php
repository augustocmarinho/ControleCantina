<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255',
            'contato' => 'required|max:20',
        ];
    }
    public function messages()
    {
        return [
            'nome' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ser maior que 255 caracteres.',
            'usuario.required' => 'O usuário é obrigatório.',
            'usuario.unique' => 'O nome de usuário já foi utilizado antes.',
            'usuario.max' => 'O usuario não pode ser maior que 255 caracteres.',
            'email.required'  => 'O email é obrigatório.',
            'email.email'  => 'O email deve ter um endereço válido.',
            'email.max' => 'O email não pode ser maior que 255 caracteres.',
            'password.required'  => 'A senha é obrigatória.',
            'password.max' => 'O senha não pode ser maior que 255 caracteres.',
        ];
    }
}
