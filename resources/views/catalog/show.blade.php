@extends('layouts.app')

@section('title', $card->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back button -->
    <a href="{{ route('catalog.index') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-6 transition">
        <i class="fas fa-arrow-left mr-2"></i>Volver al catálogo
    </a>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Image -->
        <div class="md:col-span-1">
            <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden sticky top-4">
                <div class="relative aspect-[2.5/3.5] bg-gray-900">
                    @if($card->image_url)
                        <img src="{{ $card->image_url }}" alt="{{ $card->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-600">
                            <i class="fas fa-id-card text-6xl"></i>
                        </div>
                    @endif

                    <!-- Color indicator -->
                    @if($card->color)
                    <div class="absolute top-2 left-2 w-6 h-6 rounded-full {{ $card->color_class }} border-2 border-white shadow-lg"></div>
                    @endif

                    <!-- Rarity badge -->
                    @if($card->rarity)
                    <div class="absolute top-2 right-2">
                        <span class="text-sm font-bold px-2 py-1 rounded shadow-lg" 
                              style="background-color: {{ $card->rarity->color }}; color: white;">
                            {{ $card->rarity->name }}
                        </span>
                    </div>
                    @endif

                    <!-- Collected badge -->
                    <div class="absolute bottom-2 left-2">
                        @if($card->is_collected)
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
                    <button onclick="toggleCollected({{ $card->id }}, {{ $card->is_collected ? 'true' : 'false' }})"
                            class="w-full py-2 rounded font-medium transition {{ $card->is_collected ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-yellow-500 hover:bg-yellow-600 text-gray-900' }}">
                        {{ $card->is_collected ? '✓ Quitar de colección' : '+ Añadir a colección' }}
                    </button>
                    <a href="{{ route('cards.edit', $card) }}" 
                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded text-center transition">
                        <i class="fas fa-edit mr-1"></i>Editar
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Details -->
        <div class="md:col-span-2 space-y-4">
            <!-- Header -->
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-white mb-1">{{ $card->name }}</h1>
                        <div class="text-sm text-gray-400">{{ $card->card_number }}</div>
                    </div>
                    @if($card->rarity)
                    <span class="text-lg font-bold px-3 py-1 rounded" 
                          style="background-color: {{ $card->rarity->color }}20; color: {{ $card->rarity->color }};">
                        {{ $card->rarity->name }}
                    </span>
                    @endif
                </div>

                <!-- Stats grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @if($card->cost)
                    <div class="bg-gray-750 rounded p-3 text-center">
                        <div class="text-xs text-gray-400 mb-1">Coste/Vida</div>
                        <div class="text-xl font-bold text-yellow-400">{{ $card->cost }}</div>
                    </div>
                    @endif
                    @if($card->power)
                    <div class="bg-gray-750 rounded p-3 text-center">
                        <div class="text-xs text-gray-400 mb-1">Power</div>
                        <div class="text-xl font-bold text-red-400">{{ number_format($card->power) }}</div>
                    </div>
                    @endif
                    @if($card->type)
                    <div class="bg-gray-750 rounded p-3 text-center">
                        <div class="text-xs text-gray-400 mb-1">Tipo</div>
                        <div class="text-sm font-bold text-white">{{ $card->type }}</div>
                    </div>
                    @endif
                    @if($card->block_icon)
                    <div class="bg-gray-750 rounded p-3 text-center">
                        <div class="text-xs text-gray-400 mb-1">Bloque</div>
                        <div class="text-xl font-bold text-blue-400">{{ $card->block_icon }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Set info -->
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <h3 class="text-sm font-medium text-gray-400 mb-2">Información del Set</h3>
                <div class="flex items-center gap-4">
                    <a href="{{ route('catalog.index', ['set_id' => $card->set_id]) }}" class="text-yellow-400 hover:text-yellow-300 font-medium">
                        {{ $card->set->code }} - {{ $card->set->name }}
                    </a>
                    <span class="text-gray-500">|</span>
                    <span class="text-gray-400 text-sm">Serie: {{ $card->set->series }}</span>
                    @if($card->set->release_year)
                    <span class="text-gray-500">|</span>
                    <span class="text-gray-400 text-sm">{{ $card->set->release_year }}</span>
                    @endif
                </div>
            </div>

            <!-- Attributes -->
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <h3 class="text-sm font-medium text-gray-400 mb-3">Atributos</h3>
                <div class="flex flex-wrap gap-3">
                    @if($card->color)
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full {{ $card->color_class }}"></div>
                        <span class="text-gray-300 text-sm">{{ $card->color_name }}</span>
                    </div>
                    @endif
                    @if($card->attribute)
                    <span class="bg-gray-700 text-gray-300 text-sm px-2 py-1 rounded">
                        <i class="fas fa-tag mr-1"></i>{{ $card->attribute }}
                    </span>
                    @endif
                    @if($card->feature)
                    <span class="bg-gray-700 text-gray-300 text-sm px-2 py-1 rounded">
                        <i class="fas fa-star mr-1"></i>{{ $card->feature }}
                    </span>
                    @endif
                    @if($card->is_alt)
                    <span class="bg-purple-900 text-purple-300 text-sm px-2 py-1 rounded">
                        <i class="fas fa-exchange-alt mr-1"></i>Alternativa
                    </span>
                    @endif
                </div>
            </div>

            <!-- Effect/Text -->
            @if($card->text)
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <h3 class="text-sm font-medium text-gray-400 mb-2">
                    <i class="fas fa-scroll mr-1"></i>Efecto
                </h3>
                <div class="text-gray-200 text-sm leading-relaxed whitespace-pre-wrap">{{ $card->text }}</div>
            </div>
            @endif

            <!-- Notes -->
            @if($card->notes)
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <h3 class="text-sm font-medium text-gray-400 mb-2">
                    <i class="fas fa-sticky-note mr-1"></i>Notas
                </h3>
                <div class="text-gray-300 text-sm">{{ $card->notes }}</div>
            </div>
            @endif

            <!-- Collection info -->
            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                <h3 class="text-sm font-medium text-gray-400 mb-2">Tu Colección</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <div class="text-xs text-gray-500">Cantidad</div>
                        <div class="text-lg font-bold text-white">{{ $card->quantity }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Condición</div>
                        <div class="text-lg font-bold {{ $card->condition_color }}">{{ $card->condition_label }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Valor</div>
                        <div class="text-lg font-bold text-green-400">€{{ number_format($card->value, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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