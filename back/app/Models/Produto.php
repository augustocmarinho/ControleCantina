<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;

    protected $table = 'produtos';
    protected $fillable = ['nome', 'preco'];

    public function estoque(){
        return $this->hasOne(ItensEstoque::class);
    }
}
