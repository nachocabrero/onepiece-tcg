@extends('layouts.app')

@section('title', 'Nuevo Set')

@section('content')
<div class="max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">
        <i class="fas fa-plus mr-2"></i>Nuevo Set
    </h1>

    <form action="{{ route('sets.store') }}" method="POST" class="bg-gray-800 rounded-lg p-6 border border-gray-700 space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Código *</label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="OP-01" required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Tipo *</label>
                <select name="type" required class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                    <option value="main" {{ old('type') == 'main' ? 'selected' : '' }}>Principal</option>
                    <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event Booster</option>
                    <option value="special" {{ old('type') == 'special' ? 'selected' : '' }}>Special Trainer</option>
                    <option value="promo" {{ old('type') == 'promo' ? 'selected' : '' }}>Promo</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Nombre *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="The New World" required
                   class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Serie</label>
                <input type="text" name="series" value="{{ old('series') }}" placeholder="Wano, Egghead..."
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Año de lanzamiento</label>
                <input type="number" name="release_year" value="{{ old('release_year') }}" placeholder="2022"
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Total de cartas</label>
            <input type="number" name="total_cards" value="{{ old('total_cards') }}" placeholder="50"
                   class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded transition">
                <i class="fas fa-save mr-2"></i>Guardar Set
            </button>
            <a href="{{ route('sets.index') }}" class="text-gray-400 hover:text-white">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection