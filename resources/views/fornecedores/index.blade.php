@extends('layouts.app')

@section('title', 'Fornecedores')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Fornecedores</h1>
            <a href="{{ route('fornecedores.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                <i class="fas fa-plus mr-2"></i>Novo Fornecedor
            </a>
        </div>
        
        <!-- Filtros -->
        <div class="mt-4 bg-white p-4 rounded-lg shadow">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Nome, CNPJ ou Email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Todos</option>
                        <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativos</option>
                        <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativos</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        <i class="fas fa-search mr-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Tabela de Fornecedores -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Razão Social</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contato</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cidade/UF</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($fornecedores as $fornecedor)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $fornecedor->razao_social }}</div>
                                <div class="text-sm text-gray-500">{{ $fornecedor->nome_fantasia ?? 'Sem nome fantasia' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fornecedor->cnpj }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $fornecedor->email }}</div>
                                <div class="text-sm text-gray-500">{{ $fornecedor->telefone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $fornecedor->cidade }}/{{ $fornecedor->estado }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $fornecedor->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $fornecedor->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('fornecedores.show', $fornecedor) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('fornecedores.edit', $fornecedor) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('fornecedores.destroy', $fornecedor) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nenhum fornecedor encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $fornecedores->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection