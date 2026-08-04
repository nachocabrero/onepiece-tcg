<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'One Piece TCG Collection')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <nav class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-yellow-400">
                        <i class="fas fa-crown mr-2"></i>One Piece TCG
                    </a>
                    <div class="hidden sm:flex items-center gap-1">
                        <a href="{{ route('catalog.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('catalog.*') ? 'bg-gray-900 text-yellow-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-book mr-1"></i>Catálogo
                        </a>
                        <a href="{{ route('cards.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('cards.*') ? 'bg-gray-900 text-yellow-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-id-card mr-1"></i>Mis Cartas
                        </a>
                        <a href="{{ route('sets.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('sets.*') ? 'bg-gray-900 text-yellow-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-layer-group mr-1"></i>Sets
                        </a>
                        <a href="{{ route('rarities.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('rarities.*') ? 'bg-gray-900 text-yellow-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-star mr-1"></i>Rarezas
                        </a>
                    </div>
                </div>
                <div class="text-sm text-gray-400">
                    <i class="fas fa-database mr-1"></i>{{ \App\Models\Card::count() }} cartas
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-900 border border-green-700 text-green-200 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 border-t border-gray-700 mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            One Piece TCG Collection Manager
        </div>
    </footer>
</body>
</html>