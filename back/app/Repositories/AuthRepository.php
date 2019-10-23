<?php
namespace App\Repositories;

use App\Entities\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthRepository extends BaseRepository
{

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return User::class;
    }

    public function login(LoginRequest $request){
        $data = $request->all();
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = auth()->user();
            $response['token'] = $user->createToken($user->email)->accessToken;
            $response['user'] = $user;
//            $response['roles'] = $user->getRoles();
            return json_encode($response);
        }
        return response('', 403);
    }
}