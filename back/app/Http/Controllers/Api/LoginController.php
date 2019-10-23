<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repositories\LoginRepository;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $loginRepository;

    public function __construct(LoginRepository $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }


    public function login(LoginRequest $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        return $this->loginRepository->login($username, $password);
    }

    public function refresh(Request $request)
    {
        return $this->loginRepository->refresh();
    }

    public function logout()
    {
        return $this->loginRepository->logout();
    }
}
