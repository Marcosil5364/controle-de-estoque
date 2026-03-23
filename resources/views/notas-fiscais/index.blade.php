@extends('layouts.app')

@section('title', 'Notas Fiscais')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Notas Fiscais</h1>
            <a href="{{ route('notas-fiscais.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                <i class="fas fa-plus mr-2"></i>Nova Nota Fiscal
            </a>
        </div>
        
        <!-- Filtros -->
        <div class="mt-4 bg-white p-4 rounded-lg shadow">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <select name="tipo" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Todos</option>
                        <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="saida" {{ request('tipo') == 'saida' ? 'selected' : '' }}>Saída</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número NF</label>
                    <input type="text" name="numero" value="{{ request('numero') }}" placeholder="Número da nota" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fornecedor</label>
                    <select name="fornecedor_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Todos</option>
                        @foreach($fornecedores as $fornecedor)
                            <option value="{{ $fornecedor->id }}" {{ request('fornecedor_id') == $fornecedor->id ? 'selected' : '' }}>{{ $fornecedor->razao_social }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Início</label>
                    <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Fim</label>
                    <input type="date" name="data_fim" value="{{ request('data_fim') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        <i class="fas fa-search mr-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Tabela de Notas Fiscais -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Emissão</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($notasFiscais as $nota)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $nota->numero }}</div>
                                @if($nota->serie)
                                    <div class="text-xs text-gray-500">Série: {{ $nota->serie }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($nota->tipo == 'entrada')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-download mr-1"></i>Entrada
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-upload mr-1"></i>Saída
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $nota->fornecedor->razao_social ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $nota->data_emissao->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                R$ {{ number_format($nota->valor_total, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($nota->itens->count() > 0 && $nota->tipo == 'entrada')
                                    @php
                                        $produtoMovimentado = $nota->itens->first()->produto->movimentacoes()
                                            ->where('documento', 'Nota Fiscal ' . $nota->numero)
                                            ->exists();
                                    @endphp
                                    @if($produtoMovimentado)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Processada
                                        </span>
                                    @else
                                        <a href="{{ route('notas-fiscais.processar', $nota) }}" 
                                           class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200"
                                           onclick="return confirm('Processar esta nota fiscal e dar entrada no estoque?')">
                                            <i class="fas fa-play mr-1"></i>Processar
                                        </a>
                                    @endif
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <i class="fas fa-clock mr-1"></i>Pendente
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('notas-fiscais.show', $nota) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($nota->itens->count() == 0)
                                    <a href="{{ route('notas-fiscais.edit', $nota) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('notas-fiscais.destroy', $nota) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir esta nota fiscal?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Nenhuma nota fiscal encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $notasFiscais->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection