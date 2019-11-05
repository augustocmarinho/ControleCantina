<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelefoneCliente extends Model
{
    use SoftDeletes;

    protected $table = 'telefones';

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

}
