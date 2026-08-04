@extends('layouts.app')

@section('title', 'Sets')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold text-yellow-400">
        <i class="fas fa-layer-group mr-2"></i>Sets
    </h1>
    <a href="{{ route('sets.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-4 rounded transition">
        <i class="fas fa-plus mr-2"></i>Nuevo Set
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($sets as $set)
    <div class="bg-gray-800 rounded-lg p-5 border border-gray-700 hover:border-gray-500 transition">
        <div class="flex items-start justify-between mb-3">
            <div>
                <h3 class="text-lg font-bold text-white">{{ $set->code }}</h3>
                <p class="text-gray-400 text-sm">{{ $set->name }}</p>
            </div>
            <span class="px-2 py-1 rounded text-xs font-medium bg-blue-900 text-blue-300">{{ $set->type }}</span>
        </div>
        <div class="text-sm text-gray-500 mb-3">
            Serie: {{ $set->series }}
            @if($set->release_year) · {{ $set->release_year }}@endif
        </div>
        <div class="text-sm text-gray-400">
            <i class="fas fa-id-card mr-1"></i>{{ $set->cards_count }} cartas
        </div>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-700">
            <a href="{{ route('sets.edit', $set) }}" class="text-blue-400 hover:text-blue-300 text-sm">
                <i class="fas fa-edit mr-1"></i>Editar
            </a>
            <form action="{{ route('sets.destroy', $set) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-300 text-sm" onclick="return confirm('¿Eliminar este set?')">
                    <i class="fas fa-trash mr-1"></i>Eliminar
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

@if($sets->count() === 0)
<div class="text-center py-12">
    <i class="fas fa-layer-group text-6xl text-gray-600 mb-4"></i>
    <p class="text-gray-400 mb-4">No hay sets creados</p>
    <a href="{{ route('sets.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded transition">
        <i class="fas fa-plus mr-2"></i>Añadir primer set
    </a>
</div>
@endif
@endsection