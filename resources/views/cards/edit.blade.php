@extends('layouts.app')

@section('title', 'Editar Carta')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">
        <i class="fas fa-edit mr-2"></i>Editar Carta
    </h1>

    <form action="{{ route('cards.update', $card) }}" method="POST" class="bg-gray-800 rounded-lg p-6 border border-gray-700 space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Set *</label>
                <select name="set_id" required class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                    <option value="">Seleccionar set...</option>
                    @foreach($sets as $set)
                        <option value="{{ $set->id }}" {{ old('set_id', $card->set_id) == $set->id ? 'selected' : '' }}>
                            {{ $set->code }} - {{ $set->name }} ({{ $set->series }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Número de Carta *</label>
                <input type="text" name="card_number" value="{{ old('card_number', $card->card_number) }}" placeholder="OP-01-001" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Nombre de la Carta *</label>
            <input type="text" name="name" value="{{ old('name', $card->name) }}" placeholder="Nombre de la carta" required
                   class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Personaje</label>
                <input type="text" name="character" value="{{ old('character', $card->character) }}" placeholder="Luffy, Zoro..."
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Tipo</label>
                <select name="type" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                    <option value="">Seleccionar...</option>
                    <option value="Character" {{ old('type', $card->type) == 'Character' ? 'selected' : '' }}>Character</option>
                    <option value="Event" {{ old('type', $card->type) == 'Event' ? 'selected' : '' }}>Event</option>
                    <option value="Stage" {{ old('type', $card->type) == 'Stage' ? 'selected' : '' }}>Stage</option>
                    <option value="Leader" {{ old('type', $card->type) == 'Leader' ? 'selected' : '' }}>Leader</option>
                    <option value="Captain" {{ old('type', $card->type) == 'Captain' ? 'selected' : '' }}>Captain</option>
                    <option value="Other" {{ old('type', $card->type) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Coste</label>
                <input type="text" name="cost" value="{{ old('cost', $card->cost) }}" placeholder="3"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Power</label>
                <input type="text" name="power" value="{{ old('power', $card->power) }}" placeholder="5000"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Health</label>
                <input type="text" name="health" value="{{ old('health', $card->health) }}" placeholder="4000"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Rareza</label>
                <select name="rarity_id" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                    <option value="">Seleccionar...</option>
                    @foreach($rarities as $rarity)
                        <option value="{{ $rarity->id }}" {{ old('rarity_id', $card->rarity_id) == $rarity->id ? 'selected' : '' }}>
                            {{ $rarity->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Condición</label>
                <select name="condition" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
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
                <label class="block text-sm text-gray-400 mb-1">Cantidad</label>
                <input type="number" name="quantity" value="{{ old('quantity', $card->quantity) }}" min="1"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Valor (€)</label>
                <input type="number" name="value" value="{{ old('value', $card->value) }}" step="0.01" min="0"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Habilidad / Efecto</label>
            <textarea name="ability" rows="3" placeholder="Descripción de la habilidad..."
                      class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">{{ old('ability', $card->ability) }}</textarea>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Notas</label>
            <textarea name="notes" rows="2" placeholder="Notas adicionales..."
                      class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">{{ old('notes', $card->notes) }}</textarea>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded transition">
                <i class="fas fa-save mr-2"></i>Actualizar Carta
            </button>
            <a href="{{ route('cards.index') }}" class="text-gray-400 hover:text-white">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection