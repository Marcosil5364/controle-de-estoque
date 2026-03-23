<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';
    
    protected $fillable = [
        'nome', 'descricao', 'ativo'
    ];
    
    protected $casts = [
        'ativo' => 'boolean',
    ];
    
    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class, 'categoria_id');
    }
    
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }
}