<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Cliente;
use App\Models\TelefoneCliente;

class ClientesController extends Controller
{
    //Criar novo cliente
    public function create(Request $request){
        $data=$request->all();

        //Criar Cliente
        $cliente = Cliente::create($data);

        //Criar Telefones
        foreach($data['telefones'] as $item){
            TelefoneCliente::create(['clientes_id'=>$cliente['id'], 'telefone'=>$item['telefone']]);
        }
        return $cliente;
    }

    //Editar Cliente
    public function update(Request $request){
        $data=$request->all();

        //Atualizar Cliente
        $cliente = Cliente::where('id', $data['id'])->update(['nome'=>$data['nome'],'dataNascimento'=>$data['dataNascimento'],'cpf'=>$data['cpf'],'email'=>$data['email']]);

        //Deleta todos os telefones, e depois cria outros novamente
        TelefoneCliente::where(['clientes_id'=>$data['id']])->delete(); 
        foreach($data['telefones'] as $item){
            TelefoneCliente::Create(['clientes_id'=>$data['id'], 'telefone'=>$item['telefone']]);
        }

        return $cliente;
    }

   //Receber informações de cliente, telefone, e responsaveis, filtrando por qualquer parametro (ou mais de um)
    public function get(Request $request){
        $data=$request->all();
        return Cliente::where($data)->with('telefones')->get();
    }

    //Receber todos cliente, telefone, e responsaveis
    public function getAll(){
        return Cliente::with('telefones')->get();
    }

    //Deletar cliente, filtrando por qualquer parametro (ou mais de um)
    public function delete(Request $request){
        $data=$request->all();
        return Cliente::where($data)->delete();
    }

}
