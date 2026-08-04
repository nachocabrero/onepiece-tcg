@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-yellow-400 mb-2">
        <i class="fas fa-crown mr-2"></i>One Piece TCG Collection
    </h1>
    <p class="text-gray-400">Gestiona tu colección de cartas del TCG de One Piece</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <div class="text-gray-400 text-sm mb-1">Total Cartas</div>
        <div class="text-3xl font-bold text-white">{{ $totalCards }}</div>
    </div>
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <div class="text-gray-400 text-sm mb-1">Sets</div>
        <div class="text-3xl font-bold text-blue-400">{{ $totalSets }}</div>
    </div>
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <div class="text-gray-400 text-sm mb-1">Valor Total</div>
        <div class="text-3xl font-bold text-green-400">€{{ number_format($totalValue, 2) }}</div>
    </div>
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <div class="text-gray-400 text-sm mb-1">Cartas Únicas</div>
        <div class="text-3xl font-bold text-purple-400">{{ $uniqueCards }}</div>
    </div>
</div>

<!-- Progress por set -->
<div class="bg-gray-800 rounded-lg p-6 border border-gray-700 mb-6">
    <h2 class="text-xl font-semibold mb-4 text-yellow-400">
        <i class="fas fa-tasks mr-2"></i>Progreso por Set
    </h2>
    <div class="space-y-3">
        @foreach($setCompletion as $set)
        <div>
            <div class="flex items-center justify-between mb-1">
                <span class="text-sm font-medium text-gray-300">{{ $set->code }} - {{ $set->name }}</span>
                <span class="text-sm text-gray-400">{{ $set->collected_cards }} / {{ $set->total_cards }} ({{ $set->percentage }}%)</span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-2.5">
                <div class="bg-yellow-500 h-2.5 rounded-full transition-all" style="width: {{ $set->percentage }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Series breakdown -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <h2 class="text-xl font-semibold mb-4 text-yellow-400">
            <i class="fas fa-layer-group mr-2"></i>Cartas por Serie
        </h2>
        <div class="space-y-2">
            @foreach($seriesStats as $stat)
            <div class="flex items-center justify-between">
                <span class="text-gray-300">{{ $stat->series }}</span>
                <span class="text-gray-400">{{ $stat->total_cards }} cartas</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <h2 class="text-xl font-semibold mb-4 text-yellow-400">
            <i class="fas fa-star mr-2"></i>Cartas por Rareza
        </h2>
        <div class="space-y-2">
            @foreach($rarityStats as $stat)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $stat->color }};"></span>
                    <span class="text-gray-300">{{ $stat->name }}</span>
                </div>
                <span class="text-gray-400">{{ $stat->total_cards }} cartas</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <h2 class="text-xl font-semibold mb-4 text-yellow-400">
            <i class="fas fa-layer-group mr-2"></i>Cartas por Set
        </h2>
        <div class="space-y-2">
            @foreach($setStats as $stat)
            <div class="flex items-center justify-between">
                <span class="text-gray-300">{{ $stat->code }} - {{ $stat->name }}</span>
                <span class="text-gray-400">{{ $stat->total_cards }} cartas</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <h2 class="text-xl font-semibold mb-4 text-yellow-400">
            <i class="fas fa-exclamation-triangle mr-2"></i>Acciones Rápidas
        </h2>
        <div class="space-y-2">
            <a href="{{ route('cards.create') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded text-center transition">
                <i class="fas fa-plus mr-2"></i>Añadir Carta
            </a>
            <a href="{{ route('sets.create') }}" class="block w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded text-center transition">
                <i class="fas fa-plus mr-2"></i>Añadir Set
            </a>
            <a href="{{ route('cards.index') }}" class="block w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded text-center transition">
                <i class="fas fa-list mr-2"></i>Ver Todas las Cartas
            </a>
        </div>
    </div>
</div>
@endsection