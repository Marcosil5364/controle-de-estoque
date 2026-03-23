@extends('layouts.app')

@section('title', 'Detalhes do Fornecedor')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Detalhes do Fornecedor</h1>
            <div class="space-x-2">
                <a href="{{ route('fornecedores.edit', $fornecedore) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="{{ route('fornecedores.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
            </div>
        </div>
        
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informações do Fornecedor -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Informações Cadastrais</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Razão Social</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->razao_social }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nome Fantasia</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->nome_fantasia ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">CNPJ</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->cnpj }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Inscrição Estadual</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->inscricao_estadual ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:{{ $fornecedore->email }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $fornecedore->email }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telefone</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->telefone }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Celular</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->celular ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $fornecedore->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $fornecedore->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700">Endereço</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->endereco ?? '-' }}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cidade</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->cidade ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estado</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->estado ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">CEP</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->cep ?? '-' }}</p>
                            </div>
                        </div>
                        
                        @if($fornecedore->observacoes)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700">Observações</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $fornecedore->observacoes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Estatísticas -->
            <div>
                <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Estatísticas</h2>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Total de Produtos</label>
                            <p class="mt-1 text-2xl font-bold text-indigo-600">{{ $fornecedore->produtos->count() }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total de Notas Fiscais</label>
                            <p class="mt-1 text-2xl font-bold text-indigo-600">{{ $fornecedore->notasFiscais->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Últimas Notas Fiscais</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($fornecedore->notasFiscais as $nota)
                            <div class="p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">NF {{ $nota->numero }}</p>
                                        <p class="text-xs text-gray-500">{{ $nota->data_emissao->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-gray-900">
                                            R$ {{ number_format($nota->valor_total, 2, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('notas-fiscais.show', $nota) }}" class="text-xs text-indigo-600 hover:text-indigo-900">
                                        Ver detalhes <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">
                                Nenhuma nota fiscal encontrada.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Produtos do Fornecedor -->
        <div class="mt-6">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Produtos do Fornecedor</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Compra</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Venda</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($fornecedore->produtos as $produto)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $produto->nome }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($produto->descricao, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $produto->sku ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        R$ {{ number_format($produto->preco_compra, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $produto->quantidade_atual <= $produto->estoque_minimo ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $produto->quantidade_atual }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('produtos.show', $produto) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Nenhum produto cadastrado para este fornecedor.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection