<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    
    protected $fillable = [
        'razao_social', 'nome_fantasia', 'cnpj', 'inscricao_estadual',
        'email', 'telefone', 'celular', 'endereco', 'cidade', 'estado', 'cep',
        'observacoes', 'ativo'
    ];
    
    protected $casts = [
        'ativo' => 'boolean',
    ];
    
    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class, 'fornecedor_id');
    }
    
    public function notasFiscais(): HasMany
    {
        return $this->hasMany(NotaFiscal::class, 'fornecedor_id');
    }
    
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }
}