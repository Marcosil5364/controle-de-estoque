@extends('layouts.app')

@section('title', 'Detalhes da Nota Fiscal')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Nota Fiscal {{ $notas_fiscai->numero }}</h1>
            <div class="space-x-2">
                @if($notas_fiscai->itens->count() == 0)
                    <a href="{{ route('notas-fiscais.edit', $notas_fiscai) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                @endif
                @if($notas_fiscai->tipo == 'entrada' && !$notas_fiscai->itens->first()?->produto->movimentacoes()->where('documento', 'Nota Fiscal ' . $notas_fiscai->numero)->exists())
                    <a href="{{ route('notas-fiscais.processar', $notas_fiscai) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200"
                       onclick="return confirm('Processar esta nota fiscal e dar entrada no estoque?')">
                        <i class="fas fa-play mr-2"></i>Processar Nota
                    </a>
                @endif
                <a href="{{ route('notas-fiscais.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
            </div>
        </div>
        
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Dados da Nota Fiscal -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Dados da Nota Fiscal</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Número</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $notas_fiscai->numero }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Série</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $notas_fiscai->serie ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                                <p class="mt-1">
                                    @if($notas_fiscai->tipo == 'entrada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Entrada (Compra)
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Saída (Venda)
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Data Emissão</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $notas_fiscai->data_emissao->format('d/m/Y') }}</p>
                            </div>
                            @if($notas_fiscai->data_entrada_saida)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Data Entrada/Saída</label>
                                <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($notas_fiscai->data_entrada_saida)->format('d/m/Y') }}</p>
                            </div>
                            @endif
                            @if($notas_fiscai->fornecedor)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fornecedor</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <a href="{{ route('fornecedores.show', $notas_fiscai->fornecedor) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $notas_fiscai->fornecedor->razao_social }}
                                    </a>
                                </p>
                            </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Usuário</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $notas_fiscai->usuario->name }}</p>
                            </div>
                            @if($notas_fiscai->chave_acesso)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Chave de Acesso</label>
                                <p class="mt-1 text-sm text-gray-900 break-all">{{ $notas_fiscai->chave_acesso }}</p>
                            </div>
                            @endif
                        </div>
                        
                        @if($notas_fiscai->observacoes)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700">Observações</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $notas_fiscai->observacoes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Totais e Impostos -->
            <div>
                <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Totais</h2>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Valor Total da Nota</label>
                            <p class="mt-1 text-2xl font-bold text-indigo-600">R$ {{ number_format($notas_fiscai->valor_total, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                
                @if($notas_fiscai->valor_icms || $notas_fiscai->valor_ipi || $notas_fiscai->valor_pis)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Impostos</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($notas_fiscai->base_calculo_icms)
                        <div>
                            <label class="block text-xs text-gray-500">Base ICMS</label>
                            <p class="text-sm font-medium">R$ {{ number_format($notas_fiscai->base_calculo_icms, 2, ',', '.') }}</p>
                        </div>
                        @endif
                        @if($notas_fiscai->valor_icms)
                        <div>
                            <label class="block text-xs text-gray-500">Valor ICMS</label>
                            <p class="text-sm font-medium">R$ {{ number_format($notas_fiscai->valor_icms, 2, ',', '.') }}</p>
                        </div>
                        @endif
                        @if($notas_fiscai->valor_ipi)
                        <div>
                            <label class="block text-xs text-gray-500">Valor IPI</label>
                            <p class="text-sm font-medium">R$ {{ number_format($notas_fiscai->valor_ipi, 2, ',', '.') }}</p>
                        </div>
                        @endif
                        @if($notas_fiscai->valor_pis)
                        <div>
                            <label class="block text-xs text-gray-500">Valor PIS</label>
                            <p class="text-sm font-medium">R$ {{ number_format($notas_fiscai->valor_pis, 2, ',', '.') }}</p>
                        </div>
                        @endif
                        @if($notas_fiscai->valor_cofins)
                        <div>
                            <label class="block text-xs text-gray-500">Valor COFINS</label>
                            <p class="text-sm font-medium">R$ {{ number_format($notas_fiscai->valor_cofins, 2, ',', '.') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Itens da Nota Fiscal -->
        <div class="mt-6">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Itens da Nota Fiscal</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Unitário</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Desconto</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($notas_fiscai->itens as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->produto->nome }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->produto->sku ?? 'Sem SKU' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        {{ number_format($item->quantidade, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        R$ {{ number_format($item->desconto, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                        R$ {{ number_format($item->valor_total, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Nenhum item cadastrado nesta nota fiscal.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                    Total Geral:
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600 text-right">
                                    R$ {{ number_format($notas_fiscai->valor_total, 2, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection