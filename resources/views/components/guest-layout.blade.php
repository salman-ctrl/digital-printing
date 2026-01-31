<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Digital Printing' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

{{-- Header --}}
<header class="bg-white shadow flex items-center justify-between px-6 py-4">
    <div class="flex items-center space-x-4">
        <img src="{{ asset('images/logo-cv.png') }}" alt="CV Anugrah Mandiri" class="h-12">
        <h1 class="text-xl font-bold text-gray-800">CV Anugrah Mandiri</h1>
    </div>

    {{-- Tombol Login/Register --}}
    <div class="space-x-4">
        @guest
        <a href="{{ route('login') }}" 
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">
            Login
        </a>
        <a href="{{ route('register') }}" 
           class="bg-white border border-red-600 text-red-600 px-4 py-2 rounded font-semibold hover:bg-red-50">
            Register
        </a>
        @else
        <span class="text-gray-700 font-semibold">{{ auth()->user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">
                Logout
            </button>
        </form>
        @endguest
    </div>
</header>

{{-- Main Content --}}
<main class="p-6">
    {{ $slot }} {{-- <--- PENTING: slot menampung konten public.blade / login / register --}}
</main>

{{-- Footer --}}
<footer class="h-12 bg-white text-center text-gray-500 flex items-center justify-center">
    © {{ date('Y') }} CV Anugrah Mandiri
</footer>

</body>
</html>
