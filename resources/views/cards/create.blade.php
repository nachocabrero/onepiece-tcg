@extends('layouts.app')

@section('title', 'Añadir Carta')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-yellow-400 mb-6">
        <i class="fas fa-plus mr-2"></i>Añadir Carta
    </h1>

    <form action="{{ route('cards.store') }}" method="POST" class="bg-gray-800 rounded-lg p-4 border border-gray-700 space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-400 mb-1">Buscar carta del catálogo *</label>
            <input type="text" id="searchCard" placeholder="Escribe para buscar..." 
                   class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white mb-2">
            <select name="card_id" id="cardSelect" required class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                <option value="">Seleccionar carta...</option>
                @foreach($catalogCards as $c)
                <option value="{{ $c->id }}" data-name="{{ $c->name }}" data-number="{{ $c->card_number }}" data-set="{{ $c->set->code }}"
                    {{ old('card_id', $selectedCardId ?? '') == $c->id ? 'selected' : '' }}>
                    {{ $c->set->code }} - {{ $c->card_number }} - {{ $c->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Cantidad *</label>
                <input type="number" name="copies_owned" value="{{ old('copies_owned', 1) }}" min="1" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Condición *</label>
                <select name="condition" required class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                    <option value="MT" {{ old('condition') == 'MT' ? 'selected' : '' }}>Mint (MT)</option>
                    <option value="LP" {{ old('condition') == 'LP' ? 'selected' : '' }}>Lightly Played (LP)</option>
                    <option value="MP" {{ old('condition') == 'MP' ? 'selected' : '' }}>Moderately Played (MP)</option>
                    <option value="HP" {{ old('condition') == 'HP' ? 'selected' : '' }}>Heavily Played (HP)</option>
                    <option value="DR" {{ old('condition') == 'DR' ? 'selected' : '' }}>Damaged (DR)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Precio pagado (€)</label>
                <input type="number" name="price_paid" value="{{ old('price_paid', 0) }}" step="0.01" min="0"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Valor mercado (€)</label>
                <input type="number" name="value" value="{{ old('value', 0) }}" step="0.01" min="0"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Copias deseadas</label>
            <input type="number" name="copies_wanted" value="{{ old('copies_wanted', 0) }}" min="0"
                   class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Notas</label>
            <textarea name="notes" rows="2" placeholder="Notas..."
                      class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">{{ old('notes') }}</textarea>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded transition">
                <i class="fas fa-save mr-2"></i>Guardar
            </button>
            <a href="{{ route('cards.index') }}" class="text-gray-400 hover:text-white">Cancelar</a>
        </div>
    </form>
</div>

<script>
document.getElementById('searchCard').addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    const select = document.getElementById('cardSelect');
    for (let i = 1; i < select.options.length; i++) {
        select.options[i].style.display = select.options[i].text.toLowerCase().includes(filter) ? '' : 'none';
    }
});

// Scroll al select si hay carta pre-seleccionada
@if($selectedCardId ?? false)
document.getElementById('cardSelect').scrollIntoView({ behavior: 'smooth', block: 'center' });
document.getElementById('cardSelect').classList.add('ring-2', 'ring-yellow-500');
setTimeout(() => document.getElementById('cardSelect').classList.remove('ring-2', 'ring-yellow-500'), 3000);
@endif
</script>
@endsection