@extends('layouts.app')

@section('title', 'Editar Rareza')

@section('content')
<div class="max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">
        <i class="fas fa-edit mr-2"></i>Editar Rareza
    </h1>

    <form action="{{ route('rarities.update', $rarity) }}" method="POST" class="bg-gray-800 rounded-lg p-6 border border-gray-700 space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $rarity->name) }}" placeholder="C, R, UR, SSR..." required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Color</label>
                <input type="color" name="color" value="{{ old('color', $rarity->color) }}"
                       class="w-full h-10 bg-gray-700 border border-gray-600 rounded px-1 py-1 cursor-pointer">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Orden de prioridad</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $rarity->sort_order) }}"
                   class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded transition">
                <i class="fas fa-save mr-2"></i>Actualizar Rareza
            </button>
            <a href="{{ route('rarities.index') }}" class="text-gray-400 hover:text-white">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection