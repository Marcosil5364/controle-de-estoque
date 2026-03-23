@extends('layouts.app')

@section('title', 'Nova Nota Fiscal')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Nova Nota Fiscal</h1>
            <a href="{{ route('notas-fiscais.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
        
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <form action="{{ route('notas-fiscais.store') }}" method="POST" id="formNotaFiscal">
                @csrf
                
                <!-- Dados da Nota Fiscal -->
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Dados da Nota Fiscal</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo *</label>
                            <select name="tipo" id="tipo" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Selecione</option>
                                <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada (Compra)</option>
                                <option value="saida" {{ old('tipo') == 'saida' ? 'selected' : '' }}>Saída (Venda)</option>
                            </select>
                            @error('tipo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Número *</label>
                            <input type="text" name="numero" value="{{ old('numero') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('numero') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Série</label>
                            <input type="text" name="serie" value="{{ old('serie') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('serie') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Chave de Acesso (44 dígitos)</label>
                            <input type="text" name="chave_acesso" value="{{ old('chave_acesso') }}" maxlength="44" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('chave_acesso') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data Emissão *</label>
                            <input type="date" name="data_emissao" value="{{ old('data_emissao', date('Y-m-d')) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('data_emissao') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data Entrada/Saída</label>
                            <input type="date" name="data_entrada_saida" value="{{ old('data_entrada_saida') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('data_entrada_saida') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div id="fornecedorDiv" style="display: {{ old('tipo') == 'entrada' ? 'block' : 'none' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fornecedor *</label>
                            <select name="fornecedor_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Selecione</option>
                                @foreach($fornecedores as $fornecedor)
                                    <option value="{{ $fornecedor->id }}" {{ old('fornecedor_id') == $fornecedor->id ? 'selected' : '' }}>{{ $fornecedor->razao_social }}</option>
                                @endforeach
                            </select>
                            @error('fornecedor_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valor Total *</label>
                            <input type="number" step="0.01" name="valor_total" value="{{ old('valor_total') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('valor_total') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Impostos -->
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Impostos</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Base ICMS</label>
                            <input type="number" step="0.01" name="base_calculo_icms" value="{{ old('base_calculo_icms') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valor ICMS</label>
                            <input type="number" step="0.01" name="valor_icms" value="{{ old('valor_icms') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Base ICMS ST</label>
                            <input type="number" step="0.01" name="base_calculo_icms_st" value="{{ old('base_calculo_icms_st') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valor ICMS ST</label>
                            <input type="number" step="0.01" name="valor_icms_st" value="{{ old('valor_icms_st') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valor IPI</label>
                            <input type="number" step="0.01" name="valor_ipi" value="{{ old('valor_ipi') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valor PIS</label>
                            <input type="number" step="0.01" name="valor_pis" value="{{ old('valor_pis') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valor COFINS</label>
                            <input type="number" step="0.01" name="valor_cofins" value="{{ old('valor_cofins') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>
                </div>
                
                <!-- Itens da Nota Fiscal -->
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Itens da Nota Fiscal</h2>
                    <div id="itens-container">
                        <div class="item-row grid grid-cols-1 md:grid-cols-6 gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Produto *</label>
                                <select name="itens[0][produto_id]" required class="produto-select w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Selecione</option>
                                    @foreach($produtos as $produto)
                                        <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_compra }}">{{ $produto->nome }} (R$ {{ number_format($produto->preco_compra, 2, ',', '.') }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade *</label>
                                <input type="number" name="itens[0][quantidade]" required min="1" class="quantidade w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" step="1">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Valor Unitário *</label>
                                <input type="number" step="0.01" name="itens[0][valor_unitario]" required class="valor-unitario w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Desconto</label>
                                <input type="number" step="0.01" name="itens[0][desconto]" value="0" class="desconto w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                                <input type="text" class="item-total w-full rounded-md bg-gray-100 border-gray-300" readonly>
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="remove-item bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" id="add-item" class="mt-2 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>Adicionar Item
                    </button>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                    <textarea name="observacoes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('observacoes') }}</textarea>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-200">
                        <i class="fas fa-save mr-2"></i>Salvar Nota Fiscal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let itemCount = 1;
    
    // Mostrar/esconder campo fornecedor baseado no tipo
    document.getElementById('tipo').addEventListener('change', function() {
        const fornecedorDiv = document.getElementById('fornecedorDiv');
        if (this.value === 'entrada') {
            fornecedorDiv.style.display = 'block';
        } else {
            fornecedorDiv.style.display = 'none';
        }
    });
    
    // Adicionar item
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('itens-container');
        const newItem = container.children[0].cloneNode(true);
        const inputs = newItem.querySelectorAll('input, select');
        
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\d+\]/, `[${itemCount}]`));
            }
            if (input.type !== 'button') {
                input.value = '';
            }
        });
        
        newItem.querySelector('.item-total').value = '';
        container.appendChild(newItem);
        itemCount++;
        
        // Reaplicar eventos
        attachItemEvents(newItem);
    });
    
    // Remover item
    function attachItemEvents(item) {
        const removeBtn = item.querySelector('.remove-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    item.remove();
                } else {
                    alert('É necessário ter pelo menos um item na nota fiscal!');
                }
            });
        }
        
        const produtoSelect = item.querySelector('.produto-select');
        const quantidade = item.querySelector('.quantidade');
        const valorUnitario = item.querySelector('.valor-unitario');
        const desconto = item.querySelector('.desconto');
        const itemTotal = item.querySelector('.item-total');
        
        // Carregar preço do produto
        produtoSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const preco = selectedOption.getAttribute('data-preco');
            if (preco) {
                valorUnitario.value = preco;
                calcularTotal();
            }
        });
        
        function calcularTotal() {
            const qtd = parseFloat(quantidade.value) || 0;
            const unit = parseFloat(valorUnitario.value) || 0;
            const desc = parseFloat(desconto.value) || 0;
            const total = (qtd * unit) - desc;
            itemTotal.value = total.toFixed(2);
        }
        
        quantidade.addEventListener('input', calcularTotal);
        valorUnitario.addEventListener('input', calcularTotal);
        desconto.addEventListener('input', calcularTotal);
    }
    
    // Aplicar eventos aos itens existentes
    document.querySelectorAll('.item-row').forEach(item => {
        attachItemEvents(item);
    });
</script>
@endpush
@endsection