@extends('layouts.app')

@section('title', 'Nueva Rareza')

@section('content')
<div class="max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">
        <i class="fas fa-plus mr-2"></i>Nueva Rareza
    </h1>

    <form action="{{ route('rarities.store') }}" method="POST" class="bg-gray-800 rounded-lg p-6 border border-gray-700 space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Nombre *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="C, R, UR, SSR..." required
                       class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Color</label>
                <input type="color" name="color" value="{{ old('color', '#6b7280') }}"
                       class="w-full h-10 bg-gray-700 border border-gray-600 rounded px-1 py-1 cursor-pointer">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Orden de prioridad</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                   class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded transition">
                <i class="fas fa-save mr-2"></i>Guardar Rareza
            </button>
            <a href="{{ route('rarities.index') }}" class="text-gray-400 hover:text-white">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection