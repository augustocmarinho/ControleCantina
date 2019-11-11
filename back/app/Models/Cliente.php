<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';
    protected $fillable = ['nome', 'dataNascimento'];

    public function telefone(){
        return $this->hasMany(TelefoneCliente::class);
    }
}
