<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vendas;

class RelatoriosController extends Controller
{
    public function vendas(Request $request){
        $dados = $request->all();

        if(!array_key_exists('dataInicial', $dados)){
            $dados['dataInicial'] = date('Y-m-d H:i:s',0);
        }

        if(!array_key_exists('dataFinal', $dados)){
            $dados['dataFinal'] = date('Y-m-d H:i:s',time());
        }

        $vendas = Vendas::where('created_at', '>=', $dados['dataInicial'])->where('created_at', '<=', $dados['dataFinal'])->get();

        return response()->json($vendas, 200);
    }

    public function estoque(Request $dados){

    }
}

