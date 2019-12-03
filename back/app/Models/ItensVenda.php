<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItensVenda extends Model
{
    use SoftDeletes;

    protected $table = 'itens_venda';
    protected $fillable = ['id', 'produto_id','quantidade','venda_id'];

    public function venda(){
        return $this->belongsTo(Vendas::class);
    }
}
