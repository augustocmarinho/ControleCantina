<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Cliente;

class ClientesController extends Controller
{
    //Criar novo cliente
    public function create(Request $request){
        $data=$request->all();
        return Cliente::create($data);
    }

    //Editar Cliente
    public function update(Request $request){
        $data=$request->all();
        return Cliente::where('id', $data['id'])->update($data);
    }

   //Receber informações de cliente, telefone, e responsaveis, filtrando por qualquer parametro (ou mais de um)
   public function get(Request $request){
    $data=$request->all();
    return Cliente::where($data)->with('telefone')->get();
}

    //Receber todos cliente, telefone, e responsaveis
    public function getAll(){
        return Cliente::with('telefone')->get();
    }

    //Deletar cliente, filtrando por qualquer parametro (ou mais de um)
    public function delete(Request $request){
        $data=$request->all();
        return Cliente::where($data)->delete();
    }

}
