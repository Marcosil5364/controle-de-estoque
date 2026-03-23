<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimentacaoEstoque extends Model
{
    protected $table = 'movimentacoes_estoque';
    
    protected $fillable = [
        'produto_id', 'tipo', 'quantidade', 'valor_unitario', 'valor_total',
        'motivo', 'documento', 'numero_documento', 'data_movimentacao', 'usuario_id'
    ];
    
    protected $casts = [
        'quantidade' => 'integer',
        'valor_unitario' => 'decimal:2',
        'valor_total' => 'decimal:2',
        'data_movimentacao' => 'date',
    ];
    
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
    
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}