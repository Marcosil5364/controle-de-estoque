@extends('layouts.app')

@section('title', 'Novo Fornecedor')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Novo Fornecedor</h1>
            <a href="{{ route('fornecedores.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
        
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <form action="{{ route('fornecedores.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Razão Social *</label>
                        <input type="text" name="razao_social" value="{{ old('razao_social') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('razao_social') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome Fantasia</label>
                        <input type="text" name="nome_fantasia" value="{{ old('nome_fantasia') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('nome_fantasia') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CNPJ *</label>
                        <input type="text" name="cnpj" value="{{ old('cnpj') }}" placeholder="00.000.000/0000-00" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="cnpj">
                        @error('cnpj') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Inscrição Estadual</label>
                        <input type="text" name="inscricao_estadual" value="{{ old('inscricao_estadual') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('inscricao_estadual') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telefone *</label>
                        <input type="text" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 0000-0000" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="telefone">
                        @error('telefone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Celular</label>
                        <input type="text" name="celular" value="{{ old('celular') }}" placeholder="(00) 00000-0000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="celular">
                        @error('celular') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Endereço</label>
                        <textarea name="endereco" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('endereco') }}</textarea>
                        @error('endereco') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cidade</label>
                        <input type="text" name="cidade" value="{{ old('cidade') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('cidade') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select name="estado" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Selecione</option>
                            <option value="AC" {{ old('estado') == 'AC' ? 'selected' : '' }}>AC</option>
                            <option value="AL" {{ old('estado') == 'AL' ? 'selected' : '' }}>AL</option>
                            <option value="AP" {{ old('estado') == 'AP' ? 'selected' : '' }}>AP</option>
                            <option value="AM" {{ old('estado') == 'AM' ? 'selected' : '' }}>AM</option>
                            <option value="BA" {{ old('estado') == 'BA' ? 'selected' : '' }}>BA</option>
                            <option value="CE" {{ old('estado') == 'CE' ? 'selected' : '' }}>CE</option>
                            <option value="DF" {{ old('estado') == 'DF' ? 'selected' : '' }}>DF</option>
                            <option value="ES" {{ old('estado') == 'ES' ? 'selected' : '' }}>ES</option>
                            <option value="GO" {{ old('estado') == 'GO' ? 'selected' : '' }}>GO</option>
                            <option value="MA" {{ old('estado') == 'MA' ? 'selected' : '' }}>MA</option>
                            <option value="MT" {{ old('estado') == 'MT' ? 'selected' : '' }}>MT</option>
                            <option value="MS" {{ old('estado') == 'MS' ? 'selected' : '' }}>MS</option>
                            <option value="MG" {{ old('estado') == 'MG' ? 'selected' : '' }}>MG</option>
                            <option value="PA" {{ old('estado') == 'PA' ? 'selected' : '' }}>PA</option>
                            <option value="PB" {{ old('estado') == 'PB' ? 'selected' : '' }}>PB</option>
                            <option value="PR" {{ old('estado') == 'PR' ? 'selected' : '' }}>PR</option>
                            <option value="PE" {{ old('estado') == 'PE' ? 'selected' : '' }}>PE</option>
                            <option value="PI" {{ old('estado') == 'PI' ? 'selected' : '' }}>PI</option>
                            <option value="RJ" {{ old('estado') == 'RJ' ? 'selected' : '' }}>RJ</option>
                            <option value="RN" {{ old('estado') == 'RN' ? 'selected' : '' }}>RN</option>
                            <option value="RS" {{ old('estado') == 'RS' ? 'selected' : '' }}>RS</option>
                            <option value="RO" {{ old('estado') == 'RO' ? 'selected' : '' }}>RO</option>
                            <option value="RR" {{ old('estado') == 'RR' ? 'selected' : '' }}>RR</option>
                            <option value="SC" {{ old('estado') == 'SC' ? 'selected' : '' }}>SC</option>
                            <option value="SP" {{ old('estado') == 'SP' ? 'selected' : '' }}>SP</option>
                            <option value="SE" {{ old('estado') == 'SE' ? 'selected' : '' }}>SE</option>
                            <option value="TO" {{ old('estado') == 'TO' ? 'selected' : '' }}>TO</option>
                        </select>
                        @error('estado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CEP</label>
                        <input type="text" name="cep" value="{{ old('cep') }}" placeholder="00000-000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="cep">
                        @error('cep') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                        <textarea name="observacoes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('observacoes') }}</textarea>
                        @error('observacoes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-200">
                        <i class="fas fa-save mr-2"></i>Salvar Fornecedor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Máscaras para campos
    document.getElementById('cnpj').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 14) {
            value = value.replace(/^(\d{2})(\d)/, '$1.$2');
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            e.target.value = value;
        }
    });
    
    document.getElementById('telefone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 10) {
            value = value.replace(/^(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
        } else {
            value = value.replace(/^(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
        }
        e.target.value = value;
    });
    
    document.getElementById('celular').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 11) {
            value = value.replace(/^(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
        } else if (value.length >= 10) {
            value = value.replace(/^(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
        }
        e.target.value = value;
    });
    
    document.getElementById('cep').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 8) {
            value = value.replace(/^(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        }
    });
</script>
@endpush
@endsection