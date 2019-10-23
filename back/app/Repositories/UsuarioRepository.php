<?php

namespace App\Repositories;

use App\Entities\User;
use App\Exceptions\SistemaException;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;


class UsuarioRepository
{

    public function add(Request $request){
        $data=$request->all();

        try{
            $data['password']=bcrypt($data['password']);
            $user = User::Create($data);
            // Roles
            $user->syncRoles(['User']);
            return $user;
        } catch (\Exception $e){
            return response($e, 500);
        }

    }

    /* Retorna dados do usuário logado */
    public function getUserCurrent(){
        $usuario_id = Auth::guard('api')->user()->id;
        $user = User::find($usuario_id);
        $permissoes = [];
        foreach ($user->getAllPermissions() as $permission) {
            $permissoes[] = $permission->name;
        }
        $papeis = $user->getRoleNames()->all();
        $permissoes = array_merge($permissoes, $papeis);
        $user['permissoes']=$permissoes;

        return $user;
    }

    public function update(Request $request){
        //return $request;
        $dados = $request->all();

        $avatar = $request->files->all();
        foreach ($avatar as $d) {
            $dados['avatar']= uniqid() . "." . $d->getClientOriginalExtension();
            Storage::disk('local')->put($dados['avatar'], file_get_contents($d));
        }

        return User::where('id', Auth::guard('api')->user()->id)
                    ->update($dados);
    }

    public function findByUser($user){
        return User::where('usuario',$user)->get();
    }
}
