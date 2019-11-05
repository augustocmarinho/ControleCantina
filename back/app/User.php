<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'id','name','cpf','usuario','email'
    ];

    protected $hidden = [
        'password'
    ];
}
