<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'One Piece TCG') - Collection Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #0f172a; }
        .card-gradient { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(234, 179, 8, 0.15); }
    </style>
</head>
<body class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gray-900 border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
            <div class="flex items-center justify-between h-14">
                <div class="flex items-center gap-3">
                    <a href="/" class="text-yellow-400 font-bold text-lg sm:text-xl flex items-center gap-2">
                        <i class="fas fa-crown"></i>
                        <span class="hidden sm:inline">One Piece TCG</span>
                    </a>
                </div>
                <div class="flex items-center gap-1 sm:gap-2">
                    <a href="{{ route('catalog.index') }}" class="text-gray-300 hover:text-white px-2 py-1.5 rounded text-xs sm:text-sm transition">
                        <i class="fas fa-book mr-1"></i><span class="hidden sm:inline">Catálogo</span>
                    </a>
                    @auth
                    <a href="{{ route('cards.index') }}" class="text-gray-300 hover:text-white px-2 py-1.5 rounded text-xs sm:text-sm transition">
                        <i class="fas fa-id-card mr-1"></i><span class="hidden sm:inline">Mis Cartas</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-white px-2 py-1.5 rounded text-xs sm:text-sm transition">
                            <i class="fas fa-sign-out-alt mr-1"></i><span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-medium px-2 sm:px-3 py-1.5 rounded text-xs sm:text-sm transition">
                        <i class="fas fa-sign-in-alt mr-1"></i><span class="hidden sm:inline">Login</span>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6">
        @if(session('success'))
        <div class="bg-green-900/50 border border-green-700 text-green-300 px-3 sm:px-4 py-2 sm:py-3 rounded-lg mb-4 text-sm">
            <i class="fas fa-check mr-2"></i>{{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="bg-red-900/50 border border-red-700 text-red-300 px-3 sm:px-4 py-2 sm:py-3 rounded-lg mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-700 mt-8 py-4 text-center text-gray-500 text-xs">
        One Piece TCG Collection Manager
    </footer>
</body>
</html>