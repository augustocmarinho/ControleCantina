<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';
    protected $fillable = ['nome', 'dataNascimento','cpf','email'];

    public function telefones(){
        return $this->hasMany(TelefoneCliente::class,'clientes_id','id');
    }
}
