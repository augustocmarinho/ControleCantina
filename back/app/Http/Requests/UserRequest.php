<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->route('id');
        $id = $id?$id:'NULL';
        return [
            'name' => ['required','max:255'],
            'usuario' => ['required','unique:users,usuario,'.$id,'max:255'],
            'email' => ['email','max:255'],
            'password' => ['required','max:255'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
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
