@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Detalhes do Usuário</h1>
            <div class="space-x-2">
                <a href="{{ route('users.edit', $user) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="{{ route('users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
            </div>
        </div>
        
        <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <div class="flex items-center">
                    <div class="h-20 w-20 rounded-full bg-white flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-indigo-600"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                        <p class="text-white text-opacity-90">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ID do Usuário</label>
                        <p class="mt-1 text-sm text-gray-900">#{{ $user->id }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status do E-mail</label>
                        <p class="mt-1">
                            @if($user->email_verified_at)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Verificado em {{ $user->email_verified_at->format('d/m/Y H:i') }}
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>Não verificado
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Data de Cadastro</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Última Atualização</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection