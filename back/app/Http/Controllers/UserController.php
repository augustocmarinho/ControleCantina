<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User as Funcionario;
class UserController extends Controller
{
    public function index()
    {
        return Funcionario::all();
    }
    public function show(Funcionario $funcionario)
    {
        return $funcionario;
    }
    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['username'] = strtolower($dados['username']);
        $dados['password'] = bcrypt($dados['password']);
        $funcionario = Funcionario::create($dados);
        return response()->json($funcionario, 201);
    }
    public function update(Request $request, Funcionario $funcionario)
    {
        $dados = $request->all();
        if (array_key_exists('password', $dados)) $dados['password'] = bcrypt($dados['password']);
        $funcionario->update($dados);
        return response()->json($funcionario, 200);
    }
    public function delete(Funcionario $funcionario)
    {
        $funcionario->delete();
        return response()->json(null, 204);
    }
    public function search($termo)
    {
        $funcionarios = Funcionario::whereRaw('unaccent(nome) ILIKE unaccent(\'%'.$termo.'%\')')->get();
        return response()->json($funcionarios, 200);
    }
}