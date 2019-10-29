<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Foundation\Application;

class LoginRepository
{
    const ACCESS_TOKEN = 'session';
    const REFRESH_TOKEN = 'loadSession';

    private $apiConsumer;

    private $auth;

    private $cookie;

    private $db;

    private $request;

    public function __construct(Application $app)
    {
        $this->apiConsumer = $app->make('apiconsumer');
        $this->auth = $app->make('auth');
        $this->cookie = $app->make('cookie');
        $this->db = $app->make('db');
        $this->request = $app->make('request');
    }

    /**
     * Attempt to create an access token using user credentials
     *
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        $grantType = 'password';
        $user = User::Where('usuario', $username)
        ->orWhere('email',$username)
        ->first();
        if (!is_null($user)) {
            return $this->proxy($grantType, [
                'username' => $user['usuario'],
                'password' => $password
            ]);
        } else {
            return $this->getJsonUnauthenticated($grantType);
        }
    }

    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     */
    public function refresh()
    {
        $refreshToken = $this->request->cookie(self::REFRESH_TOKEN);
        // $refreshToken = $this->request->refresh;
        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Proxy a request to the OAuth server.
     *
     * @param string $grantType what type of grant type should be proxied
     * @param array $data the data to send to the server
     */
    public function proxy($grantType, array $data = [])
    {
        $client = $this->db->table('oauth_clients')->where('name', 'Laravel Password Grant Client')->first();
        $data = array_merge($data, [
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'grant_type'    => $grantType
            ]);
        // $http = new Client(['base_uri' => url('/'),'timeout'  => 2.0,]);
        // try {
        //     $response = $http->post('/oauth/token', ['json' => $data]);
        // } catch (Exception $e) {
        //     return $this->getJsonUnauthenticated($grantType);
        // }
        // $data = json_decode($response->getBody());

        $response = $this->apiConsumer->post('/oauth/token', $data);
        if (!$response->isSuccessful()) {
            return $this->getJsonUnauthenticated($grantType);
        }

        $data = json_decode($response->getContent());

        $response = Response([
            'access_token' => $data->access_token,
            'expires_in' => $data->expires_in
        ]);

        // Create a session token cookie
        $response->cookie($this->cookie->make(
            self::ACCESS_TOKEN,
            $data->access_token,
            $data->expires_in * 2,
            null,
            null,
            false,
            true // HttpOnly
        ));
        
        // Create a refresh token cookie
        $response->cookie($this->cookie->make(
            self::REFRESH_TOKEN,
            $data->refresh_token,
            1440, // 1 day
            null,
            null,
            false,
            true // HttpOnly
        ));

        return $response;
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     */
    public function logout()
    {
        $accessToken = $this->auth->user()->token();

        $refreshToken = $this->db
            ->table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));

        $json = $this->getJsonResponse(200, 'You are Logged out.');
        return response()->json($json, '200');
    }

    private function getJsonResponse($code, $message)
    {
        $json = [
            'code' => $code,
            'message' => $message,
        ];
        return $json;
    }

    private function getJsonUnauthenticated($grantType)
    {
        $json = [];
        if ($grantType != 'password') {
            $json = $this->getJsonResponse(401, 'Unauthenticated! '.$grantType);
        } else {
            $json = $this->getJsonResponse(401, 'Unauthenticated!');
        }
        $response = Response($json, 401);
        return $response;
    }
}
