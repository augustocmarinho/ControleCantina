<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelefoneFuncionario extends Model
{
    use SoftDeletes;

    protected $table = 'telefones';

    public function usuario(){
        return $this->belongsTo(User::class);
    }

}
