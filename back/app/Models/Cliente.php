<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';

    public function telefone(){
        return $this->hasMany(TelefoneCliente::class);
    }
}
