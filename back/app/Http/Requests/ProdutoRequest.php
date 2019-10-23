<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
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
            'tipo' => 'required|max:50',
            'fase' => 'required|max:50',
            'tipo_negocio' => 'required|integer',
            'ano_entrega' => 'required|integer',
            'descricao' => 'required',
            'publicado' => 'required',
            'cep' => 'required|max:10',
            'logradouro' => 'required|max:255',
            'numero' => 'required|max:10',
            'bairro' => 'required|max:30',
            'cidade' => 'required|max:50',
            'uf' => 'required|max:2'
        ];
    }
}
