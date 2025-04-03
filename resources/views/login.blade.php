<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex flex-col justify-center items-center min-h-screen">
    <div class="w-full max-w-xs text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto mb-4 w-20">
    </div>
    <div class="w-full max-w-xs bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl text-center font-bold mb-4">Admin Panel Login</h2>
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input name="password" id="password" type="password" placeholder="********"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('password')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex w-full">
                <button type="submit"
                    class="bg-gradient-to-b from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-2 px-4 w-full rounded focus:outline-none focus:shadow-outline">
                    Login
                </button>
            </div>
        </form>
    </div>
    <footer class="text-center text-gray-500 mt-8">
        © {{ date('Y') }} GWM Nepal. All rights reserved.
    </footer>
</body>
</html>

