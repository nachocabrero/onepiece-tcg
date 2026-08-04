@extends('layouts.app')

@section('title', 'Catálogo de Cartas')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-yellow-400 mb-2">
                <i class="fas fa-book mr-2"></i>Catálogo de Cartas
            </h1>
            <p class="text-gray-400">
                Total: {{ $totalCards }} cartas | 
                <span class="text-green-400">{{ $collectedCount }} en colección</span> | 
                <span class="text-red-400">{{ $notCollectedCount }} sin coleccionar</span>
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('cards.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-4 rounded transition">
                <i class="fas fa-plus mr-1"></i>Añadir
            </a>
        </div>
    </div>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('catalog.index') }}" class="mb-6 bg-gray-800 rounded-lg p-4 border border-gray-700">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div>
            <label class="block text-sm text-gray-400 mb-1">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, número..." 
                   class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Set</label>
            <select name="set_id" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                <option value="">Todos</option>
                @foreach($sets as $set)
                    <option value="{{ $set->id }}" {{ request('set_id') == $set->id ? 'selected' : '' }}>
                        {{ $set->code }} - {{ $set->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Rareza</label>
            <select name="rarity_id" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                <option value="">Todas</option>
                @foreach($rarities as $rarity)
                    <option value="{{ $rarity->id }}" {{ request('rarity_id') == $rarity->id ? 'selected' : '' }}>
                        {{ $rarity->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Color</label>
            <select name="color" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white">
                <option value="">Todos</option>
                @foreach($colors as $color)
                    <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>
                        {{ $color }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition">
                <i class="fas fa-search mr-1"></i>Filtrar
            </button>
            <a href="{{ route('catalog.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-3 rounded transition">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
</form>

<!-- Card Grid -->
@if($cards->count() > 0)
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
    @foreach($cards as $card)
    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden hover:border-yellow-500 transition group">
        <!-- Card Image -->
        <div class="relative aspect-[2.5/3.5] bg-gray-900">
            @if($card->image_url)
                <img src="{{ $card->image_url }}" alt="{{ $card->name }}" 
                     class="w-full h-full object-cover" loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-600">
                    <i class="fas fa-id-card text-3xl"></i>
                </div>
            @endif
            
            <!-- Color indicator -->
            @if($card->color)
            <div class="absolute top-1 left-1 w-4 h-4 rounded-full {{ $card->color_class }} border border-white/30"></div>
            @endif

            <!-- Collected indicator -->
            <div class="absolute top-1 right-1">
                @if($card->is_collected)
                    <span class="bg-green-500 text-white text-xs px-1.5 py-0.5 rounded font-bold">✓</span>
                @else
                    <span class="bg-gray-700 text-gray-400 text-xs px-1.5 py-0.5 rounded">○</span>
                @endif
            </div>

            <!-- Rarity badge -->
            @if($card->rarity)
            <div class="absolute bottom-1 right-1">
                <span class="text-xs font-bold px-1.5 py-0.5 rounded" 
                      style="background-color: {{ $card->rarity->color }}30; color: {{ $card->rarity->color }};">
                    {{ $card->rarity->name }}
                </span>
            </div>
            @endif
        </div>

        <!-- Card Info -->
        <div class="p-2">
            <div class="text-xs text-gray-500 mb-0.5">{{ $card->card_number }}</div>
            <div class="text-sm font-medium text-white truncate" title="{{ $card->name }}">
                {{ $card->name }}
            </div>
            <div class="text-xs text-gray-400 mt-0.5">{{ $card->set->code }}</div>
            
            @if($card->type)
            <div class="text-xs text-gray-500 mt-0.5">{{ $card->type }}</div>
            @endif

            <!-- Quick toggle -->
            <button onclick="toggleCollected({{ $card->id }}, {{ $card->is_collected ? 'true' : 'false' }})"
                    class="w-full mt-2 text-xs py-1 rounded transition {{ $card->is_collected ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-700 hover:bg-gray-600 text-gray-300' }}">
                {{ $card->is_collected ? '✓ En colección' : '+ Añadir' }}
            </button>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $cards->links() }}
</div>
@else
<div class="text-center py-12 bg-gray-800 rounded-lg border border-gray-700">
    <i class="fas fa-search text-6xl text-gray-600 mb-4"></i>
    <p class="text-gray-400">No se encontraron cartas con los filtros seleccionados</p>
</div>
@endif

<script>
function toggleCollected(cardId, isCollected) {
    fetch(`/catalog/${cardId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        location.reload();
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection