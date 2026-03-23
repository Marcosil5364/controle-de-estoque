<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produto extends Model
{
    protected $table = 'produtos';
    
    protected $fillable = [
        'nome', 'descricao', 'codigo_barras', 'sku', 'preco_compra', 
        'preco_venda', 'preco_promocional', 'estoque_minimo', 'estoque_maximo',
        'quantidade_atual', 'unidade_medida', 'localizacao', 'categoria_id', 
        'fornecedor_id', 'ativo'
    ];
    
    protected $casts = [
        'preco_compra' => 'decimal:2',
        'preco_venda' => 'decimal:2',
        'preco_promocional' => 'decimal:2',
        'quantidade_atual' => 'integer',
        'estoque_minimo' => 'integer',
        'estoque_maximo' => 'integer',
        'ativo' => 'boolean',
    ];
    
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    
    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }
    
    public function movimentacoes(): HasMany
    {
        return $this->hasMany(MovimentacaoEstoque::class, 'produto_id');
    }
    
    public function notaFiscalItens(): HasMany
    {
        return $this->hasMany(NotaFiscalItem::class, 'produto_id');
    }
    
    // Métodos de controle de estoque
    public function adicionarEstoque(int $quantidade, string $motivo = null, $valorUnitario = null): void
    {
        $this->quantidade_atual += $quantidade;
        $this->save();
        
        $this->movimentacoes()->create([
            'tipo' => 'entrada',
            'quantidade' => $quantidade,
            'valor_unitario' => $valorUnitario,
            'valor_total' => $valorUnitario ? $valorUnitario * $quantidade : null,
            'motivo' => $motivo,
            'data_movimentacao' => now(),
            'usuario_id' => auth()->id()
        ]);
    }
    
    public function removerEstoque(int $quantidade, string $motivo = null, $valorUnitario = null): bool
    {
        if ($this->quantidade_atual < $quantidade) {
            return false;
        }
        
        $this->quantidade_atual -= $quantidade;
        $this->save();
        
        $this->movimentacoes()->create([
            'tipo' => 'saida',
            'quantidade' => $quantidade,
            'valor_unitario' => $valorUnitario,
            'valor_total' => $valorUnitario ? $valorUnitario * $quantidade : null,
            'motivo' => $motivo,
            'data_movimentacao' => now(),
            'usuario_id' => auth()->id()
        ]);
        
        return true;
    }
    
    public function estaEmEstoqueMinimo(): bool
    {
        return $this->quantidade_atual <= $this->estoque_minimo;
    }
    
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }
    
    public function scopeComEstoqueBaixo($query)
    {
        return $query->whereRaw('quantidade_atual <= estoque_minimo');
    }
}