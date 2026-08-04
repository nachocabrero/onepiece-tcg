@extends('layouts.app')

@section('title', 'Cartas')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold text-yellow-400">
        <i class="fas fa-id-card mr-2"></i>Mis Cartas
    </h1>
    <a href="{{ route('cards.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-4 rounded transition">
        <i class="fas fa-plus mr-2"></i>Nueva Carta
    </a>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('cards.index') }}" class="mb-6 bg-gray-800 rounded-lg p-4 border border-gray-700">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm text-gray-400 mb-1">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, número..." class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Set</label>
            <select name="set_id" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                <option value="">Todos</option>
                @foreach($sets as $set)
                    <option value="{{ $set->id }}" {{ request('set_id') == $set->id ? 'selected' : '' }}>{{ $set->code }} - {{ $set->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Rareza</label>
            <select name="rarity_id" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                <option value="">Todas</option>
                @foreach($rarities as $rarity)
                    <option value="{{ $rarity->id }}" {{ request('rarity_id') == $rarity->id ? 'selected' : '' }}>{{ $rarity->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition">
                <i class="fas fa-search mr-2"></i>Filtrar
            </button>
        </div>
    </div>
</form>

<!-- Cards table -->
<div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
    @if($cards->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-750 border-b border-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Carta</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Set</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Rareza</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Condición</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Cant.</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Valor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($cards as $card)
                <tr class="hover:bg-gray-750">
                    <td class="px-4 py-3">
                        <div class="font-medium text-white">{{ $card->name }}</div>
                        <div class="text-xs text-gray-500">{{ $card->card_number }}</div>
                        @if($card->character)
                        <div class="text-xs text-gray-400">{{ $card->character }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-300 text-sm">
                        {{ $card->set->code }}
                    </td>
                    <td class="px-4 py-3">
                        @if($card->rarity)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
                              style="background-color: {{ $card->rarity->color }}20; color: {{ $card->rarity->color }};">
                            {{ $card->rarity->name }}
                        </span>
                        @else
                        <span class="text-gray-500 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="{{ $card->condition_color }}">{{ $card->condition_label }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-300">{{ $card->quantity }}</td>
                    <td class="px-4 py-3 text-green-400">€{{ number_format($card->value, 2) }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('cards.edit', $card) }}" class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('cards.destroy', $card) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Eliminar esta carta?')">
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

    <!-- Pagination -->
    <div class="px-4 py-3 border-t border-gray-700">
        {{ $cards->links() }}
    </div>
    @else
    <div class="text-center py-12">
        <i class="fas fa-id-card text-6xl text-gray-600 mb-4"></i>
        <p class="text-gray-400 mb-4">No hay cartas en la colección</p>
        <a href="{{ route('cards.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded transition">
            <i class="fas fa-plus mr-2"></i>Añadir primera carta
        </a>
    </div>
    @endif
</div>
@endsection