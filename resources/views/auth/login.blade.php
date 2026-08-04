@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-gray-800 rounded-lg p-4 sm:p-6 border border-gray-700">
        <h1 class="text-xl sm:text-2xl font-bold text-yellow-400 mb-6 text-center">
            <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
        </h1>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white" placeholder="admin@onepiece-tcg.com">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Contraseña</label>
                    <input type="password" name="password" required
                           class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white" placeholder="••••••••">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded bg-gray-700 border-gray-600">
                    <label for="remember" class="text-sm text-gray-400">Recordarme</label>
                </div>
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-4 rounded transition">
                    <i class="fas fa-sign-in-alt mr-2"></i>Entrar
                </button>
            </div>
        </form>

        <div class="mt-4 p-3 bg-gray-700/50 rounded text-xs text-gray-400">
            <p class="font-medium mb-1">Credenciales de prueba:</p>
            <p>Email: admin@onepiece-tcg.com</p>
            <p>Pass: admin123</p>
        </div>
    </div>
</div>
@endsection