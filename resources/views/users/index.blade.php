@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Usuários do Sistema</h1>
            <a href="{{ route('users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                <i class="fas fa-plus mr-2"></i>Novo Usuário
            </a>
        </div>
        
        <!-- Tabela de Usuários -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-mail</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verificado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cadastro</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <i class="fas fa-user text-indigo-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->email_verified_at)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Verificado
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>Pendente
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 inline-block mx-1" title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 inline-block mx-1" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->id !== auth()->id())
                                <button type="button" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" 
                                        class="text-red-600 hover:text-red-900 inline-block mx-1" title="Excluir">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @else
                                <span class="text-gray-400 inline-block mx-1" title="Não pode excluir próprio usuário">
                                    <i class="fas fa-trash-alt"></i>
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Nenhum usuário cadastrado.
                            <a href="{{ route('users.create') }}" class="text-indigo-600 hover:text-indigo-900 ml-2">
                                Clique aqui para criar um
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<script>
function confirmDelete(userId, userName) {
    if (confirm('Tem certeza que deseja excluir o usuário "' + userName + '"? Esta ação não pode ser desfeita.')) {
        document.getElementById('delete-form-' + userId).submit();
    }
}
</script>
@endsection