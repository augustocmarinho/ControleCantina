<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGetRequest extends FormRequest
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
            'coluna' => ['nullable','in:name,nivel,setor,cpf'],
            'ordem' => ['nullable','in:asc,desc'],
            'campo' => ['nullable','in:name,email,usuario,cpf'],
            'limite' => ['nullable','numeric'],
        ];
    }
}
