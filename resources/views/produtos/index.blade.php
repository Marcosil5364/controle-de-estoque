@extends('layouts.app')

@section('title', 'Produtos')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Produtos</h1>
            <a href="{{ route('produtos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                <i class="fas fa-plus mr-2"></i>Novo Produto
            </a>
        </div>
        
        <!-- Filtros -->
        <div class="mt-4 bg-white p-4 rounded-lg shadow">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Nome, SKU ou código de barras" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                    <select name="categoria_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Todas</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <label class="flex items-center">
                        <input type="checkbox" name="estoque_baixo" value="1" {{ request('estoque_baixo') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Apenas estoque baixo</span>
                    </label>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        <i class="fas fa-search mr-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Tabela de Produtos -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Venda</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($produtos as $produto)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $produto->sku ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $produto->nome }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($produto->descricao, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $produto->categoria->nome }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $produto->quantidade_atual <= $produto->estoque_minimo ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $produto->quantidade_atual }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('produtos.show', $produto) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('produtos.edit', $produto) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nenhum produto encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $produtos->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection