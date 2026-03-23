<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\MovimentacaoEstoque;
use Illuminate\Http\Request;

class MovimentacaoEstoqueController extends Controller
{
    public function index(Request $request)
    {
        $query = MovimentacaoEstoque::with(['produto', 'usuario']);
        
        if ($request->filled('produto_id')) {
            $query->where('produto_id', $request->produto_id);
        }
        
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_movimentacao', '>=', $request->data_inicio);
        }
        
        if ($request->filled('data_fim')) {
            $query->whereDate('data_movimentacao', '<=', $request->data_fim);
        }
        
        $movimentacoes = $query->latest()->paginate(20);
        $produtos = Produto::ativo()->orderBy('nome')->get();
        
        return view('estoque.movimentacoes', compact('movimentacoes', 'produtos'));
    }
    
    public function entrada(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'motivo' => 'nullable',
            'valor_unitario' => 'nullable|numeric|min:0',
        ]);
        
        $produto = Produto::findOrFail($request->produto_id);
        
        $produto->adicionarEstoque(
            $request->quantidade,
            $request->motivo,
            $request->valor_unitario
        );
        
        return redirect()->back()
            ->with('success', "Entrada de {$request->quantidade} unidades realizada com sucesso!");
    }
    
    public function saida(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'motivo' => 'nullable',
        ]);
        
        $produto = Produto::findOrFail($request->produto_id);
        
        if (!$produto->removerEstoque($request->quantidade, $request->motivo)) {
            return redirect()->back()
                ->with('error', 'Estoque insuficiente para esta operação!');
        }
        
        return redirect()->back()
            ->with('success', "Saída de {$request->quantidade} unidades realizada com sucesso!");
    }
    
    public function ajuste(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'nova_quantidade' => 'required|integer|min:0',
            'motivo' => 'required',
        ]);
        
        $produto = Produto::findOrFail($request->produto_id);
        $diferenca = $request->nova_quantidade - $produto->quantidade_atual;
        
        if ($diferenca > 0) {
            $produto->adicionarEstoque($diferenca, "Ajuste de estoque: {$request->motivo}");
        } elseif ($diferenca < 0) {
            $produto->removerEstoque(abs($diferenca), "Ajuste de estoque: {$request->motivo}");
        }
        
        return redirect()->back()
            ->with('success', 'Ajuste de estoque realizado com sucesso!');
    }
}