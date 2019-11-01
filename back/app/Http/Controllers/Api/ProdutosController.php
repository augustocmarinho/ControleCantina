<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Produto;

class ProdutosController extends Controller
{
    //Criar novo produto
    public function create(Request $request){
        $data=$request->all();
        return Produto::create($data);
    }

    //Editar Produto
    public function update(Request $request){
        $data=$request->all();
        return Produto::where('id', $data['id'])->update($data);
    }

    //Receber informações de produto e estoque, filtrando por qualquer parametro (ou mais de um)
    public function get(Request $request){
        $data=$request->all();
        return Produto::where($data)->with('estoque')->get();
    }

    //Receber todos os produtos e estoque
    public function getAll(Request $request){
        return Produto::with('estoque')->get();
    }

    //Deletar produto, filtrando por qualquer parametro (ou mais de um)
    public function delete(Request $request){
        $data=$request->all();
        return Produto::where($data)->delete();
    }

}
