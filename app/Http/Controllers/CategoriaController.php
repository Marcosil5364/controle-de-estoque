<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Listar todas as categorias
     */
    public function index()
    {
        $categorias = Categoria::orderBy('nome')->get();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Mostrar formulário de criação
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Salvar nova categoria
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable'
        ]);

        Categoria::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        return redirect()->route('categorias.index')
                         ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Mostrar formulário de edição
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Atualizar categoria
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable'
        ]);

        $categoria = Categoria::findOrFail($id);

        $categoria->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        return redirect()->route('categorias.index')
                         ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Excluir categoria
     */
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        
        // Verificar se a categoria tem produtos
        if ($categoria->produtos()->count() > 0) {
            return redirect()->route('categorias.index')
                             ->with('error', 'Não é possível excluir uma categoria que possui produtos!');
        }
        
        $categoria->delete();

        return redirect()->route('categorias.index')
                         ->with('success', 'Categoria excluída com sucesso!');
    }
}