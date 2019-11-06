<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User as Funcionario;
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
	if (strlen($dados['cpf']) != 14){
		return response()->json(['erro' => 'CPF inválido'],500);
	}
	if (Funcionario::where('email', '=', $dados['email'])->exists()) {
		return response()->json(['erro' => 'e-mail já cadastrado'],500);
	}
	if (Funcionario::where('cpf', '=', $dados['cpf'])->exists()) {
		return response()->json(['erro' => 'CPF já cadastrado'],500);
	}
	if (Funcionario::where('usuario', '=', $dados['usuario'])->exists()) {
		return response()->json(['erro' => 'Nome de usuário já cadastrado'],500);
	}
        $dados['usuario'] = strtolower($dados['usuario']);
        $dados['password'] = bcrypt($dados['password']);
        $funcionario = Funcionario::create($dados);
        return response()->json($funcionario, 201);
    }
    public function update(Request $request, Funcionario $funcionario)
    {
        $dados = $request->all();
	if (strlen($dados['cpf']) != 14){
		return response()->json(['erro' => 'CPF inválido'],500);
	}
	$func = Funcionario::where('email', '=', $dados['email'])->where('id','!=', $funcionario->id)->first();
	if ($func !== null) {
		return response()->json(['erro' => 'e-mail já cadastrado'],500);
	}
	$func = Funcionario::where('cpf', '=', $dados['cpf'])->where('id','!=', $funcionario->id)->first();
	if ($func !== null) {
		return response()->json(['erro' => 'CPF já cadastrado'],500);
	}
	$func = Funcionario::where('usuario', '=', $dados['usuario'])->where('id','!=', $funcionario->id)->first();
	if ($func !== null) {
		return response()->json(['erro' => 'Nome de usuário já cadastrado'],500);
	}
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
        $funcionarios = Funcionario::whereRaw('unaccent(name) ILIKE unaccent(\'%'.$termo.'%\')')->get();
        return response()->json($funcionarios, 200);
    }
}
