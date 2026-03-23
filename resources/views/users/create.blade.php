@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Novo Usuário</h1>
            <a href="{{ route('users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
        
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('name') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('email') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Senha *</label>
                        <input type="password" name="password" required 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('password') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Senha *</label>
                        <input type="password" name="password_confirmation" required 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-200">
                        <i class="fas fa-save mr-2"></i>Criar Usuário
                    </button>
                </div>
            </form>
            
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <h3 class="text-sm font-semibold text-blue-800 mb-2">
                    <i class="fas fa-info-circle mr-1"></i>Informações:
                </h3>
                <ul class="text-xs text-blue-700 space-y-1">
                    <li>• O usuário será criado com acesso ao sistema</li>
                    <li>• A senha deve ter no mínimo 6 caracteres</li>
                    <li>• O e-mail deve ser único no sistema</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection