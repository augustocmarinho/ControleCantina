<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendas extends Model
{
    use SoftDeletes;

    protected $table = 'vendas';
    protected $fillable = ['id', 'clientes_id','user_id'];

    public function itens(){
        return $this->hasMany(ItensVenda::class,'venda_id');
    }
}
