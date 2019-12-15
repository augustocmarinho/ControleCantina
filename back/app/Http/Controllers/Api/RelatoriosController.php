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

        if(!array_key_exists('data_inicial', $dados)){
            $dados['data_inicial'] = date('Y-m-d H:i:s',0);
        }

        if(!array_key_exists('data_final', $dados)){
            $dados['data_final'] = date('Y-m-d H:i:s',time());
        }

        $vendas = Vendas::with('itens')->where('created_at', '>=', $dados['data_inicial'])->where('created_at', '<=', $dados['data_final'])->get();

        return response()->json($vendas, 200);
    }

    public function estoque(Request $request){
        $dados = $request->all();

        if(!array_key_exists('data_inicialE', $dados)){
            $dados['data_inicialE'] = date('Y-m-d H:i:s',0);
        }

        if(!array_key_exists('data_finalE', $dados)){
            $dados['data_finalE'] = date('Y-m-d H:i:s',time());
        }

        if(!array_key_exists('data_inicialS', $dados)){
            $dados['data_inicialS'] = date('Y-m-d H:i:s',0);
        }

        if(!array_key_exists('data_finalS', $dados)){
            $dados['data_finalS'] = date('Y-m-d H:i:s',time());
        }

        $estoque = ItensEstoque::where('created_at', '>=', $dados['data_inicialE'])->where('created_at', '<=', $dados['data_finalE'])->get();

        return response()->json($estoque, 200);
    }
}

