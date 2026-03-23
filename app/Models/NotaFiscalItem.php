<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotaFiscalItem extends Model
{
    protected $table = 'nota_fiscal_itens';
    
    protected $fillable = [
        'nota_fiscal_id', 'produto_id', 'quantidade', 'valor_unitario', 
        'valor_total', 'desconto'
    ];
    
    protected $casts = [
        'quantidade' => 'integer',
        'valor_unitario' => 'decimal:2',
        'valor_total' => 'decimal:2',
        'desconto' => 'decimal:2',
    ];
    
    public function notaFiscal(): BelongsTo
    {
        return $this->belongsTo(NotaFiscal::class, 'nota_fiscal_id');
    }
    
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}