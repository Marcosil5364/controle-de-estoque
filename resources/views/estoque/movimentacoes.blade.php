@extends('layouts.app')

@section('title', 'Movimentações de Estoque')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Movimentações de Estoque</h1>
            <div class="space-x-2">
                <button onclick="openModal('entrada')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-plus-circle mr-2"></i>Entrada
                </button>
                <button onclick="openModal('saida')" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-minus-circle mr-2"></i>Saída
                </button>
                <button onclick="openModal('ajuste')" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-adjust mr-2"></i>Ajuste
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="mt-4 bg-white p-4 rounded-lg shadow">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Produto</label>
                    <select name="produto_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Todos</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}" {{ request('produto_id') == $produto->id ? 'selected' : '' }}>{{ $produto->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <select name="tipo" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Todos</option>
                        <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="saida" {{ request('tipo') == 'saida' ? 'selected' : '' }}>Saída</option>
                        <option value="ajuste" {{ request('tipo') == 'ajuste' ? 'selected' : '' }}>Ajuste</option>
                        <option value="devolucao" {{ request('tipo') == 'devolucao' ? 'selected' : '' }}>Devolução</option>
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

        <!-- Tabela de Movimentações -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                     <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data/Hora</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Unitário</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($movimentacoes as $mov)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($mov->data_movimentacao)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $mov->produto->nome }}</div>
                            @if($mov->motivo)
                                <div class="text-xs text-gray-500">{{ $mov->motivo }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($mov->tipo == 'entrada')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-arrow-down mr-1"></i>Entrada
                                </span>
                            @elseif($mov->tipo == 'saida')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-arrow-up mr-1"></i>Saída
                                </span>
                            @elseif($mov->tipo == 'ajuste')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-adjust mr-1"></i>Ajuste
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-undo mr-1"></i>Devolução
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            {{ number_format($mov->quantidade, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            @if($mov->valor_unitario)
                                R$ {{ number_format($mov->valor_unitario, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            @if($mov->valor_total)
                                R$ {{ number_format($mov->valor_total, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $mov->usuario->name }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Nenhuma movimentação encontrada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $movimentacoes->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Modais de Movimentação -->
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
    const modals = ['modalEntrada', 'modalSaida', 'modalAjuste'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
}
</script>
@endsection
