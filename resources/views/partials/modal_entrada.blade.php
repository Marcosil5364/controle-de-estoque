<div id="modalEntrada" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Entrada de Estoque</h3>
            <form action="{{ route('estoque.entrada') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Produto</label>
                    <select name="produto_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Selecione um produto</option>
                        @php
                            $produtos = \App\Models\Produto::orderBy('nome')->get();
                        @endphp
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->nome }} (Estoque: {{ $produto->quantidade_atual ?? 0 }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade</label>
                    <input type="number" name="quantidade" required min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Valor Unitário (opcional)</label>
                    <input type="number" step="0.01" name="valor_unitario" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo</label>
                    <textarea name="motivo" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('entrada')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Confirmar Entrada</button>
                </div>
            </form>
        </div>
    </div>
</div>