@extends('layouts.app')

@section('title', 'Rarezas')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold text-yellow-400">
        <i class="fas fa-star mr-2"></i>Rarezas
    </h1>
    <a href="{{ route('rarities.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-4 rounded transition">
        <i class="fas fa-plus mr-2"></i>Nueva Rareza
    </a>
</div>

<div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-750 border-b border-gray-700">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Color</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Nombre</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Cartas</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
            @foreach($rarities as $rarity)
            <tr class="hover:bg-gray-750">
                <td class="px-4 py-3">
                    <span class="w-6 h-6 rounded-full inline-block" style="background-color: {{ $rarity->color }};"></span>
                </td>
                <td class="px-4 py-3 font-medium text-white">{{ $rarity->name }}</td>
                <td class="px-4 py-3 text-gray-400">{{ $rarity->cards_count }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('rarities.edit', $rarity) }}" class="text-blue-400 hover:text-blue-300">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('rarities.destroy', $rarity) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Eliminar esta rareza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection