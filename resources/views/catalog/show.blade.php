@extends('layouts.app')

@section('title', $card->name)

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back button -->
    <a href="{{ route('catalog.index') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-4 transition">
        <i class="fas fa-arrow-left mr-2"></i>Volver al Catálogo
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Card Image -->
        <div class="lg:col-span-1">
            <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 sticky top-20">
                <div class="relative w-full aspect-[3/4] bg-gray-700">
                    @if($card->image_url)
                    <img src="{{ $card->image_url }}" alt="{{ $card->name }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-500">
                        <i class="fas fa-image text-4xl"></i>
                    </div>
                    @endif
                    <!-- Collected badge -->
                    <div class="absolute bottom-2 left-2">
                        @if($userCard)
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded font-bold">
                                <i class="fas fa-check mr-1"></i>En colección
                            </span>
                        @else
                            <span class="bg-gray-700 text-gray-300 text-xs px-2 py-1 rounded">
                                <i class="far fa-circle mr-1"></i>Sin coleccionar
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Quick actions -->
                <div class="p-3 border-t border-gray-700 space-y-2">
                    @auth
                    <button onclick="toggleCollected({{ $card->id }}, {{ $userCard ? 'true' : 'false' }})"
                            class="w-full py-2 rounded font-medium transition text-sm {{ $userCard ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-yellow-500 hover:bg-yellow-600 text-gray-900' }}">
                        {{ $userCard ? '✓ Quitar' : '+ Añadir' }}
                    </button>
                    @if($userCard)
                    <a href="{{ route('cards.edit', $userCard) }}" 
                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded text-center transition text-sm">
                        <i class="fas fa-edit mr-1"></i>Editar
                    </a>
                    @endif
                    @else
                    <a href="{{ route('login') }}" class="block w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded text-center transition text-sm">
                        Inicia sesión para editar
                    </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Card Details -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Header -->
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 mb-3">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $card->name }}</h1>
                        <div class="text-sm text-gray-400">{{ $card->card_number }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($card->rarity)
                        <span class="px-2 py-1 rounded text-xs font-medium"
                              style="background-color: {{ $card->rarity->color }}20; color: {{ $card->rarity->color }};">
                            {{ $card->rarity->name }}
                        </span>
                        @endif
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs">
                            <span class="w-3 h-3 rounded-full {{ $card->color_class }}"></span>
                            {{ $card->color_name }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                    <div>
                        <div class="text-gray-500 text-xs">Set</div>
                        <div class="text-white">{{ $card->set->code }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 text-xs">Tipo</div>
                        <div class="text-white">{{ $card->type }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 text-xs">Personaje</div>
                        <div class="text-white">{{ $card->character ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 text-xs">Atributo</div>
                        <div class="text-white">{{ $card->attribute ?? '—' }}</div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            @if($card->cost || $card->power || $card->health)
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <h3 class="text-sm font-medium text-gray-400 mb-3">Estadísticas</h3>
                <div class="grid grid-cols-3 gap-4">
                    @if($card->cost)
                    <div class="text-center">
                        <div class="text-gray-500 text-xs mb-1">Coste</div>
                        <div class="text-xl font-bold text-yellow-400">{{ $card->cost }}</div>
                    </div>
                    @endif
                    @if($card->power)
                    <div class="text-center">
                        <div class="text-gray-500 text-xs mb-1">Power</div>
                        <div class="text-xl font-bold text-red-400">{{ $card->power }}</div>
                    </div>
                    @endif
                    @if($card->health)
                    <div class="text-center">
                        <div class="text-gray-500 text-xs mb-1">Health</div>
                        <div class="text-xl font-bold text-blue-400">{{ $card->health }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Card text -->
            @if($card->text)
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <h3 class="text-sm font-medium text-gray-400 mb-2">Efecto</h3>
                <p class="text-white text-sm whitespace-pre-wrap">{{ $card->text }}</p>
            </div>
            @endif

            <!-- Feature -->
            @if($card->feature)
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <h3 class="text-sm font-medium text-gray-400 mb-2">Característica</h3>
                <p class="text-white text-sm">{{ $card->feature }}</p>
            </div>
            @endif

            <!-- Collection info -->
            @if($userCard)
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <h3 class="text-sm font-medium text-gray-400 mb-3">Tu Colección</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <div class="text-xs text-gray-500">Cantidad</div>
                        <div class="text-lg font-bold text-white">{{ $userCard->copies_owned }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Condición</div>
                        <div class="text-lg font-bold {{ $userCard->condition_color }}">{{ $userCard->condition_label }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Valor</div>
                        <div class="text-lg font-bold text-green-400">€{{ number_format($userCard->total_market_value, 2) }}</div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleCollected(cardId, isCollected) {
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