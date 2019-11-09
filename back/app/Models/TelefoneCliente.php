<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TelefoneCliente extends Model
{
    use SoftDeletes;

    protected $table = 'telefones_cliente';

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

}
