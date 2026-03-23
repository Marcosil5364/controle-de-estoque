<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotaFiscal extends Model
{
    protected $table = 'notas_fiscais';
    
    protected $fillable = [
        'tipo', 'numero', 'serie', 'chave_acesso', 'data_emissao', 
        'data_entrada_saida', 'valor_total', 'base_calculo_icms', 
        'valor_icms', 'base_calculo_icms_st', 'valor_icms_st', 'valor_ipi',
        'valor_pis', 'valor_cofins', 'fornecedor_id', 'observacoes', 
        'arquivo_xml', 'usuario_id'
    ];
    
    protected $casts = [
        'data_emissao' => 'date',
        'data_entrada_saida' => 'date',
        'valor_total' => 'decimal:2',
        'base_calculo_icms' => 'decimal:2',
        'valor_icms' => 'decimal:2',
        'base_calculo_icms_st' => 'decimal:2',
        'valor_icms_st' => 'decimal:2',
        'valor_ipi' => 'decimal:2',
        'valor_pis' => 'decimal:2',
        'valor_cofins' => 'decimal:2',
    ];
    
    public function itens(): HasMany
    {
        return $this->hasMany(NotaFiscalItem::class, 'nota_fiscal_id');
    }
    
    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }
    
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function processarEntradaEstoque(): void
    {
        foreach ($this->itens as $item) {
            $produto = $item->produto;
            
            // Atualiza o preço de compra
            $produto->preco_compra = $item->valor_unitario;
            $produto->save();
            
            // Adiciona ao estoque
            $produto->adicionarEstoque(
                $item->quantidade,
                "Nota Fiscal {$this->numero}",
                $item->valor_unitario
            );
        }
    }
}