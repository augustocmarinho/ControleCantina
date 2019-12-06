<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vendas;
use App\Models\ItensEstoque;

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

        $vendas = Vendas::with('itens')->where('created_at', '>=', $dados['dataInicial'])->where('created_at', '<=', $dados['dataFinal'])->get();

        return response()->json($vendas, 200);
    }

    public function estoque(Request $request){
        $dados = $request->all();

        if(!array_key_exists('dataInicialE', $dados)){
            $dados['dataInicialE'] = date('Y-m-d H:i:s',0);
        }

        if(!array_key_exists('dataFinalE', $dados)){
            $dados['dataFinalE'] = date('Y-m-d H:i:s',time());
        }

        if(!array_key_exists('dataInicialS', $dados)){
            $dados['dataInicialS'] = date('Y-m-d H:i:s',0);
        }

        if(!array_key_exists('dataFinalS', $dados)){
            $dados['dataFinalS'] = date('Y-m-d H:i:s',time());
        }

        $estoque = ItensEstoque::where('created_at', '>=', $dados['dataInicialE'])->where('created_at', '<=', $dados['dataFinalE'])->get();

        return response()->json($estoque, 200);
    }
}

