@extends('layouts.app')

@section('title', 'Catálogo de Cartas')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h1 class="text-2xl sm:text-3xl font-bold text-yellow-400">
            <i class="fas fa-book mr-2"></i>Catálogo de Cartas
        </h1>
        <div class="flex items-center gap-2 text-sm">
            <span class="text-gray-400">{{ $totalCards }} cartas</span>
            <span class="text-gray-600">|</span>
            <span class="text-green-400">{{ $collectedCount }} en colección</span>
            <span class="text-gray-600">|</span>
            <span class="text-gray-300">{{ $notCollectedCount }} sin coleccionar</span>
        </div>
    </div>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('catalog.index') }}" class="mb-6 bg-gray-800 rounded-lg p-3 border border-gray-700">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-3">
        <div class="sm:col-span-2">
            <label class="block text-xs text-gray-400 mb-1">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, número..." class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white text-sm">
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
        <div>
            <label class="block text-xs text-gray-400 mb-1">Atributo</label>
            <select name="attribute" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white text-sm">
                <option value="">Todos</option>
                @foreach($attributes as $attr)
                    @if($attr)
                    <option value="{{ $attr }}" {{ request('attribute') == $attr ? 'selected' : '' }}>{{ $attr }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 rounded transition text-sm">
                <i class="fas fa-search mr-1"></i>Filtrar
            </button>
            <a href="{{ route('catalog.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-3 rounded transition" title="Limpiar filtros">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
</form>

<!-- Cards Grid -->
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 sm:gap-3">
    @foreach($cards as $card)
    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 card-hover transition-all duration-200 relative group">
        <!-- Card image -->
        <a href="{{ route('catalog.show', $card) }}" class="block">
            <div class="relative w-full aspect-[3/4] bg-gray-700 overflow-hidden">
                @if($card->image_url)
                <img src="{{ $card->image_url }}" alt="{{ $card->name }}" 
                     class="w-full h-full object-cover" loading="lazy"
                     onerror="this.src='https://via.placeholder.com/300x420/334155/94a3b8?text={{ urlencode($card->card_number) }}'">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-500">
                    <i class="fas fa-image text-2xl"></i>
                </div>
                @endif
            </div>
        </a>
        
        <!-- Card info -->
        <div class="p-2">
            <div class="text-[10px] sm:text-xs text-gray-500 mb-0.5">{{ $card->card_number }}</div>
            <div class="text-xs font-medium text-white truncate">{{ $card->name }}</div>
            @if($card->character)
            <div class="text-[10px] text-gray-400 truncate">{{ $card->character }}</div>
            @endif
            <div class="flex items-center gap-1 mt-1">
                <span class="w-2 h-2 rounded-full {{ $card->color_class }}"></span>
                <span class="text-[10px] text-gray-400">{{ $card->color_name }}</span>
                @if($card->rarity)
                <span class="text-[10px] text-gray-500 ml-auto">{{ $card->rarity->name }}</span>
                @endif
            </div>
        </div>

        <!-- Collected indicator -->
        <div class="absolute top-0.5 right-0.5">
            @if(auth()->check() && $collectedIds->contains($card->id))
                <span class="bg-green-500 text-white text-xs px-1 py-0 rounded font-bold">✓</span>
            @else
                <span class="bg-gray-700 text-gray-400 text-xs px-1 py-0 rounded">○</span>
            @endif
        </div>

        <!-- Quick toggle -->
        @auth
        <button onclick="toggleCollected({{ $card->id }}, {{ $collectedIds->contains($card->id) ? 'true' : 'false' }})"
                class="w-full mt-1.5 text-[10px] sm:text-xs py-1 rounded transition {{ $collectedIds->contains($card->id) ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-700 hover:bg-gray-600 text-gray-300' }}">
            {{ $collectedIds->contains($card->id) ? '✓' : '+' }}
        </button>
        @endauth
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $cards->appends(request()->except('page'))->links() }}
</div>

<script>
function toggleCollected(cardId, isCollected) {
    @guest
    window.location.href = '{{ route('login') }}';
    return;
    @endguest
    
    fetch(`/catalog/${cardId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection