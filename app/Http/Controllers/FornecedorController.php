<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {
        $query = Fornecedor::query();
        
        if ($request->filled('busca')) {
            $query->where(function($q) use ($request) {
                $q->where('razao_social', 'like', "%{$request->busca}%")
                  ->orWhere('cnpj', 'like', "%{$request->busca}%")
                  ->orWhere('email', 'like', "%{$request->busca}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('ativo', $request->status == 'ativo');
        }
        
        $fornecedores = $query->orderBy('razao_social')->paginate(15);
        
        return view('fornecedores.index', compact('fornecedores'));
    }
    
    public function create()
    {
        return view('fornecedores.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'razao_social' => 'required|max:150',
            'nome_fantasia' => 'nullable|max:150',
            'cnpj' => 'required|unique:fornecedores|size:18',
            'inscricao_estadual' => 'nullable|max:20',
            'email' => 'required|email|max:100',
            'telefone' => 'required|max:20',
            'celular' => 'nullable|max:20',
            'endereco' => 'nullable',
            'cidade' => 'nullable|max:100',
            'estado' => 'nullable|size:2',
            'cep' => 'nullable|max:10',
            'observacoes' => 'nullable',
        ]);
        
        Fornecedor::create($validated);
        
        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor cadastrado com sucesso!');
    }
    
    public function show(Fornecedor $fornecedore)
    {
        $fornecedore->load(['produtos', 'notasFiscais' => function($q) {
            $q->latest()->limit(10);
        }]);
        
        return view('fornecedores.show', compact('fornecedore'));
    }
    
    public function edit(Fornecedor $fornecedore)
    {
        return view('fornecedores.edit', compact('fornecedore'));
    }
    
    public function update(Request $request, Fornecedor $fornecedore)
    {
        $validated = $request->validate([
            'razao_social' => 'required|max:150',
            'nome_fantasia' => 'nullable|max:150',
            'cnpj' => 'required|size:18|unique:fornecedores,cnpj,' . $fornecedore->id,
            'inscricao_estadual' => 'nullable|max:20',
            'email' => 'required|email|max:100',
            'telefone' => 'required|max:20',
            'celular' => 'nullable|max:20',
            'endereco' => 'nullable',
            'cidade' => 'nullable|max:100',
            'estado' => 'nullable|size:2',
            'cep' => 'nullable|max:10',
            'observacoes' => 'nullable',
            'ativo' => 'boolean',
        ]);
        
        $fornecedore->update($validated);
        
        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor atualizado com sucesso!');
    }
    
    public function destroy(Fornecedor $fornecedore)
    {
        if ($fornecedore->produtos()->count() > 0) {
            return back()->with('error', 'Não é possível excluir um fornecedor que possui produtos vinculados!');
        }
        
        $fornecedore->delete();
        
        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor excluído com sucesso!');
    }
    
    public function toggleStatus(Fornecedor $fornecedore)
    {
        $fornecedore->ativo = !$fornecedore->ativo;
        $fornecedore->save();
        
        return back()->with('success', 'Status do fornecedor alterado com sucesso!');
    }
}