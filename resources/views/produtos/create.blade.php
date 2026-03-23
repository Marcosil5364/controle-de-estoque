@extends('layouts.app')

@section('title', 'Novo Produto')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Novo Produto</h1>
            <a href="{{ route('produtos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
        
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <form action="{{ route('produtos.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                        <input type="text" name="nome" value="{{ old('nome') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('nome') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categoria *</label>
                        <select name="categoria_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Selecione</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                        @error('categoria_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SKU (Código Interno)</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Código de Barras</label>
                        <input type="text" name="codigo_barras" value="{{ old('codigo_barras') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('codigo_barras') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preço de Compra *</label>
                        <input type="number" step="0.01" name="preco_compra" value="{{ old('preco_compra') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('preco_compra') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preço de Venda *</label>
                        <input type="number" step="0.01" name="preco_venda" value="{{ old('preco_venda') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('preco_venda') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preço Promocional</label>
                        <input type="number" step="0.01" name="preco_promocional" value="{{ old('preco_promocional') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('preco_promocional') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade Inicial *</label>
                        <input type="number" name="quantidade_atual" value="{{ old('quantidade_atual', 0) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('quantidade_atual') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estoque Mínimo *</label>
                        <input type="number" name="estoque_minimo" value="{{ old('estoque_minimo', 0) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('estoque_minimo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estoque Máximo *</label>
                        <input type="number" name="estoque_maximo" value="{{ old('estoque_maximo', 0) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('estoque_maximo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unidade de Medida *</label>
                        <select name="unidade_medida" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="UN" {{ old('unidade_medida') == 'UN' ? 'selected' : '' }}>Unidade (UN)</option>
                            <option value="PC" {{ old('unidade_medida') == 'PC' ? 'selected' : '' }}>Peça (PC)</option>
                            <option value="KG" {{ old('unidade_medida') == 'KG' ? 'selected' : '' }}>Quilograma (KG)</option>
                            <option value="LT" {{ old('unidade_medida') == 'LT' ? 'selected' : '' }}>Litro (LT)</option>
                            <option value="MT" {{ old('unidade_medida') == 'MT' ? 'selected' : '' }}>Metro (MT)</option>
                        </select>
                        @error('unidade_medida') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fornecedor</label>
                        <select name="fornecedor_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Selecione</option>
                            @foreach($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id }}" {{ old('fornecedor_id') == $fornecedor->id ? 'selected' : '' }}>{{ $fornecedor->razao_social }}</option>
                            @endforeach
                        </select>
                        @error('fornecedor_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Localização no Estoque</label>
                        <input type="text" name="localizacao" value="{{ old('localizacao') }}" placeholder="Ex: Prateleira A, Corredor 1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('localizacao') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                        <textarea name="descricao" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('descricao') }}</textarea>
                        @error('descricao') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-200">
                        <i class="fas fa-save mr-2"></i>Salvar Produto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection