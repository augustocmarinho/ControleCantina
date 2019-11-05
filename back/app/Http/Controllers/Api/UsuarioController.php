<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UsuarioRepository;
use Illuminate\Http\Request;
use App\Models\User as Funcionario;

use Auth;

class UsuarioController extends Controller
{
    protected $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function add(Request $request){
        return $this->usuarioRepository->add($request);
    }

    public function getUserCurrent()
    {
        $data = $this->usuarioRepository->getUserCurrent();
        return json_encode($data);
    }

    public function getusuario($user){
        return $this->usuarioRepository->findByUser($user);
    }

    public function update(Request $request){
        return $this->usuarioRepository->update($request);
    }
}
