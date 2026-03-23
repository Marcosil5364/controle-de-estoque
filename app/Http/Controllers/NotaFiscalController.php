<?php

namespace App\Http\Controllers;

use App\Models\NotaFiscal;
use App\Models\Fornecedor;
use App\Models\Produto;
use Illuminate\Http\Request;

class NotaFiscalController extends Controller
{
    public function index(Request $request)
    {
        $query = NotaFiscal::with(['fornecedor', 'usuario']);
        
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->filled('numero')) {
            $query->where('numero', 'like', "%{$request->numero}%");
        }
        
        if ($request->filled('fornecedor_id')) {
            $query->where('fornecedor_id', $request->fornecedor_id);
        }
        
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_emissao', '>=', $request->data_inicio);
        }
        
        if ($request->filled('data_fim')) {
            $query->whereDate('data_emissao', '<=', $request->data_fim);
        }
        
        $notasFiscais = $query->latest()->paginate(15);
        $fornecedores = Fornecedor::ativo()->orderBy('razao_social')->get();
        
        return view('notas-fiscais.index', compact('notasFiscais', 'fornecedores'));
    }
    
    public function create()
    {
        $fornecedores = Fornecedor::ativo()->orderBy('razao_social')->get();
        $produtos = Produto::ativo()->orderBy('nome')->get();
        
        return view('notas-fiscais.create', compact('fornecedores', 'produtos'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:entrada,saida',
            'numero' => 'required|max:20',
            'serie' => 'nullable|max:10',
            'chave_acesso' => 'nullable|unique:notas_fiscais|size:44',
            'data_emissao' => 'required|date',
            'data_entrada_saida' => 'nullable|date',
            'valor_total' => 'required|numeric|min:0',
            'base_calculo_icms' => 'nullable|numeric',
            'valor_icms' => 'nullable|numeric',
            'base_calculo_icms_st' => 'nullable|numeric',
            'valor_icms_st' => 'nullable|numeric',
            'valor_ipi' => 'nullable|numeric',
            'valor_pis' => 'nullable|numeric',
            'valor_cofins' => 'nullable|numeric',
            'fornecedor_id' => 'nullable|exists:fornecedores,id',
            'observacoes' => 'nullable',
            'itens' => 'required|array|min:1',
            'itens.*.produto_id' => 'required|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
            'itens.*.desconto' => 'nullable|numeric|min:0',
        ]);
        
        $validated['usuario_id'] = auth()->id();
        
        $notaFiscal = NotaFiscal::create($validated);
        
        // Criar os itens da nota fiscal
        foreach ($request->itens as $item) {
            $valorTotal = ($item['valor_unitario'] * $item['quantidade']) - ($item['desconto'] ?? 0);
            
            $notaFiscal->itens()->create([
                'produto_id' => $item['produto_id'],
                'quantidade' => $item['quantidade'],
                'valor_unitario' => $item['valor_unitario'],
                'valor_total' => $valorTotal,
                'desconto' => $item['desconto'] ?? 0,
            ]);
        }
        
        return redirect()->route('notas-fiscais.show', $notaFiscal)
            ->with('success', 'Nota Fiscal cadastrada com sucesso!');
    }
    
    public function show(NotaFiscal $notas_fiscai)
    {
        $notas_fiscai->load(['fornecedor', 'usuario', 'itens.produto']);
        
        return view('notas-fiscais.show', compact('notas_fiscai'));
    }
    
    public function edit(NotaFiscal $notas_fiscai)
    {
        if ($notas_fiscai->itens()->count() > 0) {
            return redirect()->route('notas-fiscais.show', $notas_fiscai)
                ->with('error', 'Não é possível editar uma nota fiscal que já possui itens!');
        }
        
        $fornecedores = Fornecedor::ativo()->orderBy('razao_social')->get();
        $produtos = Produto::ativo()->orderBy('nome')->get();
        
        return view('notas-fiscais.edit', compact('notas_fiscai', 'fornecedores', 'produtos'));
    }
    
    public function update(Request $request, NotaFiscal $notas_fiscai)
    {
        if ($notas_fiscai->itens()->count() > 0) {
            return redirect()->route('notas-fiscais.show', $notas_fiscai)
                ->with('error', 'Não é possível editar uma nota fiscal que já possui itens!');
        }
        
        $validated = $request->validate([
            'tipo' => 'required|in:entrada,saida',
            'numero' => 'required|max:20',
            'serie' => 'nullable|max:10',
            'chave_acesso' => 'nullable|size:44|unique:notas_fiscais,chave_acesso,' . $notas_fiscai->id,
            'data_emissao' => 'required|date',
            'data_entrada_saida' => 'nullable|date',
            'valor_total' => 'required|numeric|min:0',
            'base_calculo_icms' => 'nullable|numeric',
            'valor_icms' => 'nullable|numeric',
            'base_calculo_icms_st' => 'nullable|numeric',
            'valor_icms_st' => 'nullable|numeric',
            'valor_ipi' => 'nullable|numeric',
            'valor_pis' => 'nullable|numeric',
            'valor_cofins' => 'nullable|numeric',
            'fornecedor_id' => 'nullable|exists:fornecedores,id',
            'observacoes' => 'nullable',
        ]);
        
        $notas_fiscai->update($validated);
        
        return redirect()->route('notas-fiscais.show', $notas_fiscai)
            ->with('success', 'Nota Fiscal atualizada com sucesso!');
    }
    
    public function destroy(NotaFiscal $notas_fiscai)
    {
        if ($notas_fiscai->itens()->count() > 0) {
            return back()->with('error', 'Não é possível excluir uma nota fiscal que possui itens!');
        }
        
        $notas_fiscai->delete();
        
        return redirect()->route('notas-fiscais.index')
            ->with('success', 'Nota Fiscal excluída com sucesso!');
    }
    
    public function processar(NotaFiscal $notas_fiscai)
    {
        if ($notas_fiscai->tipo !== 'entrada') {
            return back()->with('error', 'Apenas notas fiscais de entrada podem ser processadas!');
        }
        
        if ($notas_fiscai->itens()->count() === 0) {
            return back()->with('error', 'Nota fiscal sem itens para processar!');
        }
        
        try {
            $notas_fiscai->processarEntradaEstoque();
            
            return redirect()->route('notas-fiscais.show', $notas_fiscai)
                ->with('success', 'Nota Fiscal processada e estoque atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao processar nota fiscal: ' . $e->getMessage());
        }
    }
}