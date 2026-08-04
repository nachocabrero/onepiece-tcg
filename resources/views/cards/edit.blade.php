@extends('layouts.app')

@section('title', 'Editar Carta')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-yellow-400 mb-6">
        <i class="fas fa-edit mr-2"></i>Editar Carta
    </h1>

    <form action="{{ route('cards.update', $card) }}" method="POST" class="bg-gray-800 rounded-lg p-4 border border-gray-700 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-400 mb-1">Carta *</label>
            <div class="text-white mb-2">{{ $card->card->name }} ({{ $card->card->card_number }})</div>
            <input type="hidden" name="card_id" value="{{ $card->card_id }}">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Cantidad *</label>
                <input type="number" name="copies_owned" value="{{ old('copies_owned', $card->copies_owned) }}" min="1" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Condición *</label>
                <select name="condition" required class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                    <option value="MT" {{ old('condition', $card->condition) == 'MT' ? 'selected' : '' }}>Mint (MT)</option>
                    <option value="LP" {{ old('condition', $card->condition) == 'LP' ? 'selected' : '' }}>Lightly Played (LP)</option>
                    <option value="MP" {{ old('condition', $card->condition) == 'MP' ? 'selected' : '' }}>Moderately Played (MP)</option>
                    <option value="HP" {{ old('condition', $card->condition) == 'HP' ? 'selected' : '' }}>Heavily Played (HP)</option>
                    <option value="DR" {{ old('condition', $card->condition) == 'DR' ? 'selected' : '' }}>Damaged (DR)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Precio pagado (€)</label>
                <input type="number" name="price_paid" value="{{ old('price_paid', $card->price_paid) }}" step="0.01" min="0"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Valor mercado (€)</label>
                <input type="number" name="value" value="{{ old('value', $card->value) }}" step="0.01" min="0"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Copias deseadas</label>
            <input type="number" name="copies_wanted" value="{{ old('copies_wanted', $card->copies_wanted) }}" min="0"
                   class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Notas</label>
            <textarea name="notes" rows="2" placeholder="Notas..."
                      class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">{{ old('notes', $card->notes) }}</textarea>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded transition">
                <i class="fas fa-save mr-2"></i>Actualizar
            </button>
            <a href="{{ route('cards.index') }}" class="text-gray-400 hover:text-white">Cancelar</a>
        </div>
    </form>
</div>
@endsection