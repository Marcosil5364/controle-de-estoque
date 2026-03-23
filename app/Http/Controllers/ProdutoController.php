<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::with(['categoria', 'fornecedor'])->ativo();
        
        // Filtros
        if ($request->filled('busca')) {
            $query->where(function($q) use ($request) {
                $q->where('nome', 'like', "%{$request->busca}%")
                  ->orWhere('sku', 'like', "%{$request->busca}%")
                  ->orWhere('codigo_barras', 'like', "%{$request->busca}%");
            });
        }
        
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }
        
        if ($request->filled('estoque_baixo')) {
            $query->comEstoqueBaixo();
        }
        
        $produtos = $query->orderBy('nome')->paginate(15);
        $categorias = Categoria::ativo()->orderBy('nome')->get();
        
        return view('produtos.index', compact('produtos', 'categorias'));
    }
    
    public function create()
    {
        $categorias = Categoria::ativo()->orderBy('nome')->get();
        $fornecedores = Fornecedor::ativo()->orderBy('razao_social')->get();
        
        return view('produtos.create', compact('categorias', 'fornecedores'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:150',
            'descricao' => 'nullable',
            'codigo_barras' => 'nullable|unique:produtos',
            'sku' => 'nullable|unique:produtos',
            'preco_compra' => 'required|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
            'preco_promocional' => 'nullable|numeric|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'estoque_maximo' => 'required|integer|min:0',
            'quantidade_atual' => 'required|integer|min:0',
            'unidade_medida' => 'required',
            'localizacao' => 'nullable',
            'categoria_id' => 'required|exists:categorias,id',
            'fornecedor_id' => 'nullable|exists:fornecedores,id',
        ]);
        
        $produto = Produto::create($validated);
        
        return redirect()->route('produtos.index')
            ->with('success', 'Produto criado com sucesso!');
    }
    
    public function show(Produto $produto)
    {
        $produto->load(['categoria', 'fornecedor', 'movimentacoes' => function($q) {
            $q->latest()->limit(50);
        }]);
        
        return view('produtos.show', compact('produto'));
    }
    
    public function edit(Produto $produto)
    {
        $categorias = Categoria::ativo()->orderBy('nome')->get();
        $fornecedores = Fornecedor::ativo()->orderBy('razao_social')->get();
        
        return view('produtos.edit', compact('produto', 'categorias', 'fornecedores'));
    }
    
    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome' => 'required|max:150',
            'descricao' => 'nullable',
            'codigo_barras' => 'nullable|unique:produtos,codigo_barras,' . $produto->id,
            'sku' => 'nullable|unique:produtos,sku,' . $produto->id,
            'preco_compra' => 'required|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
            'preco_promocional' => 'nullable|numeric|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'estoque_maximo' => 'required|integer|min:0',
            'unidade_medida' => 'required',
            'localizacao' => 'nullable',
            'categoria_id' => 'required|exists:categorias,id',
            'fornecedor_id' => 'nullable|exists:fornecedores,id',
        ]);
        
        $produto->update($validated);
        
        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }
    
    public function destroy(Produto $produto)
    {
        if ($produto->quantidade_atual > 0) {
            return back()->with('error', 'Não é possível excluir um produto com estoque positivo!');
        }
        
        $produto->delete();
        
        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}