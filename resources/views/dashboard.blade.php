@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mt-8">
            <div class="bg-white overflow-hidden shadow rounded-lg card-hover">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-boxes text-2xl text-indigo-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total de Produtos</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $totalProdutos }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg card-hover">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-2xl text-yellow-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Estoque Baixo</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $produtosEstoqueBaixo }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg card-hover">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-dollar-sign text-2xl text-green-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Valor do Estoque</dt>
                                <dd class="text-lg font-semibold text-gray-900">R$ {{ number_format($valorEstoque, 2, ',', '.') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg card-hover">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line text-2xl text-blue-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Movimentações Hoje</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    +{{ $entradasHoje }} / -{{ $saidasHoje }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Ações Rápidas</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <button onclick="openModal('entrada')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-plus-circle mr-2"></i>Entrada de Estoque
                </button>
                <button onclick="openModal('saida')" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-minus-circle mr-2"></i>Saída de Estoque
                </button>
                <button onclick="openModal('ajuste')" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-adjust mr-2"></i>Ajuste de Estoque
                </button>
                <a href="{{ route('notas-fiscais.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-200 text-center">
                    <i class="fas fa-file-invoice mr-2"></i>Lançar Nota Fiscal
                </a>
            </div>
        </div>

        <!-- Últimas Movimentações -->
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Últimas Movimentações</h2>
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @forelse($ultimasMovimentacoes as $mov)
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if($mov->tipo == 'entrada')
                                            <i class="fas fa-arrow-down text-green-600 mr-3"></i>
                                        @else
                                            <i class="fas fa-arrow-up text-red-600 mr-3"></i>
                                        @endif
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $mov->produto->nome }}
                                        </p>
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $mov->tipo == 'entrada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $mov->tipo == 'entrada' ? 'Entrada' : 'Saída' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-cubes mr-1"></i>
                                            Quantidade: {{ $mov->quantidade }}
                                        </p>
                                        <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                            <i class="fas fa-user mr-1"></i>
                                            {{ $mov->usuario->name }}
                                        </p>
                                    </div>
                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ \Carbon\Carbon::parse($mov->data_movimentacao)->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-4 text-center text-gray-500">Nenhuma movimentação registrada.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal Entrada -->
<div id="modalEntrada" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Entrada de Estoque</h3>
            <form action="{{ route('estoque.entrada') }}" method="POST" id="formEntrada">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Produto</label>
                    <select name="produto_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Selecione um produto</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->nome }} (Estoque: {{ $produto->quantidade_atual ?? 0 }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade</label>
                    <input type="number" name="quantidade" required min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Valor Unitário (opcional)</label>
                    <input type="number" step="0.01" name="valor_unitario" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo</label>
                    <textarea name="motivo" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('entrada')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Confirmar Entrada</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Saída -->
<div id="modalSaida" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Saída de Estoque</h3>
            <form action="{{ route('estoque.saida') }}" method="POST" id="formSaida">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Produto</label>
                    <select name="produto_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Selecione um produto</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->nome }} (Estoque: {{ $produto->quantidade_atual ?? 0 }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade</label>
                    <input type="number" name="quantidade" required min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo</label>
                    <textarea name="motivo" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('saida')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Confirmar Saída</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ajuste -->
<div id="modalAjuste" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Ajuste de Estoque</h3>
            <form action="{{ route('estoque.ajuste') }}" method="POST" id="formAjuste">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Produto</label>
                    <select name="produto_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Selecione um produto</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->nome }} (Estoque atual: {{ $produto->quantidade_atual ?? 0 }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nova Quantidade</label>
                    <input type="number" name="nova_quantidade" required min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo do Ajuste</label>
                    <textarea name="motivo" required rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('ajuste')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">Confirmar Ajuste</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(tipo) {
    if (tipo === 'entrada') {
        document.getElementById('modalEntrada').classList.remove('hidden');
    } else if (tipo === 'saida') {
        document.getElementById('modalSaida').classList.remove('hidden');
    } else if (tipo === 'ajuste') {
        document.getElementById('modalAjuste').classList.remove('hidden');
    }
}

function closeModal(tipo) {
    if (tipo === 'entrada') {
        document.getElementById('modalEntrada').classList.add('hidden');
        document.getElementById('formEntrada').reset();
    } else if (tipo === 'saida') {
        document.getElementById('modalSaida').classList.add('hidden');
        document.getElementById('formSaida').reset();
    } else if (tipo === 'ajuste') {
        document.getElementById('modalAjuste').classList.add('hidden');
        document.getElementById('formAjuste').reset();
    }
}

// Fechar modal ao clicar fora
window.onclick = function(event) {
    const modalEntrada = document.getElementById('modalEntrada');
    const modalSaida = document.getElementById('modalSaida');
    const modalAjuste = document.getElementById('modalAjuste');

    if (event.target === modalEntrada) {
        modalEntrada.classList.add('hidden');
    }
    if (event.target === modalSaida) {
        modalSaida.classList.add('hidden');
    }
    if (event.target === modalAjuste) {
        modalAjuste.classList.add('hidden');
    }
}
</script>
@endsection
