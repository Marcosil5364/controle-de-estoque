<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listar todos os usuários
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Mostrar formulário de criação
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Salvar novo usuário
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso! Senha: ' . $request->password);
    }

    /**
     * Mostrar detalhes do usuário
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Mostrar formulário de edição
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Atualizar usuário
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Excluir usuário
     */
    public function destroy(User $user)
    {
        // Impedir exclusão do próprio usuário
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Você não pode excluir seu próprio usuário!');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }
}