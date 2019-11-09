<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TelefoneFuncionario extends Model
{
    use SoftDeletes;

    protected $table = 'telefones_funcionario';

    public function usuario(){
        return $this->belongsTo(User::class);
    }

}
