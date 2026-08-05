@extends('layouts.app')

@section('title', 'Mi Colección')

@section('content')
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
    <h1 class="text-2xl sm:text-3xl font-bold text-yellow-400">
        <i class="fas fa-id-card mr-2"></i>Mi Colección
    </h1>
    <a href="{{ route('cards.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-4 rounded transition text-sm whitespace-nowrap">
        <i class="fas fa-plus mr-2"></i>Añadir Carta
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
    <div class="bg-gray-800 rounded-lg p-3 border border-gray-700 text-center">
        <div class="text-xl font-bold text-white">{{ $collectedCards }}</div>
        <div class="text-xs text-gray-400">En colección</div>
    </div>
    <div class="bg-gray-800 rounded-lg p-3 border border-gray-700 text-center">
        <div class="text-xl font-bold text-orange-400">{{ $totalDuplicates }}</div>
        <div class="text-xs text-gray-400">Duplicados</div>
    </div>
    <div class="bg-gray-800 rounded-lg p-3 border border-gray-700 text-center">
        <div class="text-xl font-bold text-yellow-400">€{{ number_format($totalSpent, 2) }}</div>
        <div class="text-xs text-gray-400">Gastado</div>
    </div>
    <div class="bg-gray-800 rounded-lg p-3 border border-gray-700 text-center">
        <div class="text-xl font-bold text-blue-400">€{{ number_format($totalMarketValue, 2) }}</div>
        <div class="text-xs text-gray-400">Valor</div>
    </div>
    <div class="bg-gray-800 rounded-lg p-3 border border-gray-700 text-center col-span-2 md:col-span-1">
        <div class="text-xl font-bold text-gray-400">{{ $totalCards }}</div>
        <div class="text-xs text-gray-400">Catálogo total</div>
    </div>
</div>

<!-- PDF Download buttons -->
<div class="flex flex-wrap gap-2 mb-6">
    <a href="{{ route('cards.missing-pdf', request()->except('page')) }}" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded transition text-sm">
        <i class="fas fa-file-pdf mr-2"></i>Descargar Faltantes (Todo)
    </a>
    <div class="flex flex-wrap gap-1">
        @foreach($sets as $set)
        <a href="{{ route('cards.set-pdf', ['setId' => $set->id, 'set_id' => $set->id]) }}"
           class="bg-gray-700 hover:bg-gray-600 text-gray-300 py-1 px-2 rounded text-xs transition border border-gray-600"
           title="Faltantes de {{ $set->code }}">
            {{ $set->code }}
        </a>
        @endforeach
    </div>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('cards.index') }}" class="mb-6 bg-gray-800 rounded-lg p-3 border border-gray-700">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
        <div>
            <label class="block text-xs text-gray-400 mb-1">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre..." class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1">Set</label>
            <select name="set_id" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                <option value="">Todos</option>
                @foreach($sets as $set)
                    <option value="{{ $set->id }}" {{ request('set_id') == $set->id ? 'selected' : '' }}>{{ $set->code }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1">Rareza</label>
            <select name="rarity_id" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                <option value="">Todas</option>
                @foreach($rarities as $rarity)
                    <option value="{{ $rarity->id }}" {{ request('rarity_id') == $rarity->id ? 'selected' : '' }}>{{ $rarity->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1">Color</label>
            <select name="color" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                <option value="">Todos</option>
                <option value="赤" {{ request('color') == '赤' ? 'selected' : '' }}>🔴</option>
                <option value="緑" {{ request('color') == '緑' ? 'selected' : '' }}>🟢</option>
                <option value="青" {{ request('color') == '青' ? 'selected' : '' }}>🔵</option>
                <option value="紫" {{ request('color') == '紫' ? 'selected' : '' }}>🟣</option>
                <option value="黒" {{ request('color') == '黒' ? 'selected' : '' }}>⚫</option>
                <option value="黄" {{ request('color') == '黄' ? 'selected' : '' }}>🟡</option>
                <option value="多色" {{ request('color') == '多色' ? 'selected' : '' }}>🌈</option>
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1">Tipo</label>
            <select name="type" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                <option value="">Todos</option>
                <option value="Character" {{ request('type') == 'Character' ? 'selected' : '' }}>Personaje</option>
                <option value="Event" {{ request('type') == 'Event' ? 'selected' : '' }}>Evento</option>
                <option value="Supporter" {{ request('type') == 'Supporter' ? 'selected' : '' }}>Supporter</option>
                <option value="Crew" {{ request('type') == 'Crew' ? 'selected' : '' }}>Tripulación</option>
                <option value="Ship" {{ request('type') == 'Ship' ? 'selected' : '' }}>Barco</option>
                <option value="Stage" {{ request('type') == 'Stage' ? 'selected' : '' }}>Escenario</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 rounded transition text-sm">
                <i class="fas fa-search mr-1"></i>Filtrar
            </button>
            <a href="{{ route('cards.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-3 rounded transition" title="Limpiar filtros">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
    <div class="mt-3 flex flex-wrap gap-3">
        <label class="inline-flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="duplicates" value="1" {{ request('duplicates') ? 'checked' : '' }} class="rounded bg-gray-700 border-gray-600 text-yellow-500">
            <span class="text-xs text-gray-300">Solo duplicados</span>
        </label>
        <label class="inline-flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="no_duplicates" value="1" {{ request('no_duplicates') ? 'checked' : '' }} class="rounded bg-gray-700 border-gray-600 text-yellow-500">
            <span class="text-xs text-gray-300">Sin duplicados</span>
        </label>
    </div>
</form>

<!-- Cards -->
<div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
    @if($cards->count() > 0)
    <!-- Desktop table -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-750 border-b border-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Carta</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Set</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Rareza</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Color</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Condición</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Cant.</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Precio</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Valor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($cards as $userCard)
                <tr class="hover:bg-gray-750 {{ $userCard->copies_owned > 1 ? 'bg-yellow-900/10' : '' }}">
                    <td class="px-4 py-3">
                        <div class="font-medium text-white">{{ $userCard->card->name }}</div>
                        @if($userCard->card->name_es)
                        <div class="text-xs text-yellow-400">{{ $userCard->card->name_es }}</div>
                        @endif
                        <div class="text-xs text-gray-500">{{ $userCard->card->card_number }}</div>
                        @if($userCard->card->character)
                        <div class="text-xs text-gray-400">{{ $userCard->card->character }}</div>
                        @endif
                        @if($userCard->card->character_es)
                        <div class="text-xs text-gray-500">{{ $userCard->card->character_es }}</div>
                        @endif
                        @if($userCard->copies_owned > 1)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-500/20 text-yellow-400 mt-1">
                            <i class="fas fa-copy mr-1"></i>{{ $userCard->copies_owned }}x
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-300 text-sm">{{ $userCard->card->set->code }}</td>
                    <td class="px-4 py-3">
                        @if($userCard->card->rarity)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
                              style="background-color: {{ $userCard->card->rarity->color }}20; color: {{ $userCard->card->rarity->color }};">
                            {{ $userCard->card->rarity->name }}
                        </span>
                        @else
                        <span class="text-gray-500 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center gap-1">
                            <span class="w-3 h-3 rounded-full {{ $userCard->card->color_class }}"></span>
                            <span class="text-xs text-gray-300">{{ $userCard->card->color_name }}</span>
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="{{ $userCard->condition_color }}">{{ $userCard->condition_label }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-300">
                        {{ $userCard->copies_owned }}
                        @if($userCard->copies_wanted > 0)
                        <span class="text-xs text-gray-500">/ {{ $userCard->copies_wanted }}✦</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($userCard->price_paid > 0)
                        <div class="text-gray-300">€{{ number_format($userCard->price_paid, 2) }}</div>
                        <div class="text-xs text-gray-500">Total: €{{ number_format($userCard->total_spent, 2) }}</div>
                        @else
                        <span class="text-gray-600 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-green-400">€{{ number_format($userCard->total_market_value, 2) }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('cards.edit', $userCard) }}" class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('cards.destroy', $userCard) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Eliminar de la colección?')">
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

    <!-- Mobile cards -->
    <div class="md:hidden divide-y divide-gray-700">
        @foreach($cards as $userCard)
        <div class="p-3 {{ $userCard->copies_owned > 1 ? 'bg-yellow-900/10' : '' }}">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <div class="font-medium text-white">{{ $userCard->card->name }}</div>
                    <div class="text-xs text-gray-500">{{ $userCard->card->card_number }} · {{ $userCard->card->set->code }}</div>
                    @if($userCard->card->character)
                    <div class="text-xs text-gray-400">{{ $userCard->card->character }}</div>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    @if($userCard->card->rarity)
                    <span class="text-xs font-medium px-1.5 py-0.5 rounded"
                          style="background-color: {{ $userCard->card->rarity->color }}20; color: {{ $userCard->card->rarity->color }};">
                        {{ $userCard->card->rarity->name }}
                    </span>
                    @endif
                    <a href="{{ route('cards.edit', $userCard) }}" class="text-blue-400 hover:text-blue-300">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('cards.destroy', $userCard) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('¿Eliminar?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 text-xs text-gray-400">
                <span class="inline-flex items-center gap-1">
                    <span class="w-3 h-3 rounded-full {{ $userCard->card->color_class }}"></span> {{ $userCard->card->color_name }}
                </span>
                <span>{{ $userCard->condition_label }}</span>
                <span>Cant: {{ $userCard->copies_owned }}</span>
                @if($userCard->price_paid > 0)
                <span class="text-green-400">€{{ number_format($userCard->total_market_value, 2) }}</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="px-4 py-3 border-t border-gray-700">
        {{ $cards->appends(request()->except('page'))->links() }}
    </div>
    @else
    <div class="text-center py-12">
        <i class="fas fa-id-card text-6xl text-gray-600 mb-4"></i>
        <p class="text-gray-400 mb-4">Tu colección está vacía</p>
        <p class="text-gray-500 text-sm mb-4">Ve al catálogo y pulsa "+" para añadir cartas</p>
        <a href="{{ route('catalog.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded transition">
            <i class="fas fa-book mr-2"></i>Ir al Catálogo
        </a>
    </div>
    @endif
</div>
@endsection