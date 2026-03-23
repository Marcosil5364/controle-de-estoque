@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Editar Usuário</h1>
            <div class="space-x-2">
                <a href="{{ route('users.show', $user) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-eye mr-2"></i>Ver Detalhes
                </a>
                <a href="{{ route('users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
            </div>
        </div>
        
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('name') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('email') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nova Senha (deixe em branco para manter a atual)</label>
                        <input type="password" name="password" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('password') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nova Senha</label>
                        <input type="password" name="password_confirmation" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-2">
                    <a href="{{ route('users.show', $user) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-200">
                        <i class="fas fa-save mr-2"></i>Atualizar Usuário
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection