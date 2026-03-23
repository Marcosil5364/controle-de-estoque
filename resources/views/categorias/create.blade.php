@extends('layouts.app')

@section('title', 'Nova Categoria')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Nova Categoria</h1>
            <a href="{{ route('categorias.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
        
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('nome') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                    <textarea name="descricao" rows="4" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('descricao') }}</textarea>
                    @error('descricao') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Ativo</span>
                    </label>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-200">
                        <i class="fas fa-save mr-2"></i>Salvar Categoria
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection