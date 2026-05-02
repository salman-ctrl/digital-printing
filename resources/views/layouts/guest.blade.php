<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Murni Digital Printing | CV Anugrah Murni Sejati' }}</title>
    <script>
        tailwind = {
            config: {
                // Konfigurasi tailwind jika diperlukan
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 text-gray-800">

@include('partials.header')

<!-- Global Alerts -->
@if(session('error') || session('success') || $errors->any())
<div class="fixed top-24 right-10 z-[9999] animate-fade-in-down space-y-4">
    @if($errors->any())
        @foreach($errors->all() as $error)
        <div class="bg-orange-500 text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 17c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="font-black text-xs capitalize tracking-widest">{{ $error }}</p>
        </div>
        @endforeach
    @endif
    @if(session('error'))
    <div class="bg-red-600 text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="font-black text-xs capitalize tracking-widest">{{ session('error') }}</p>
    </div>
    @endif
    @if(session('success'))
    <div class="bg-green-600 text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <p class="font-black text-xs capitalize tracking-widest">{{ session('success') }}</p>
    </div>
    @endif
</div>
@endif

<main class="container mx-auto px-6 py-12">
    {{ $slot ?? '' }}
    @yield('content')
</main>

@include('partials.footer')

<script>
    lucide.createIcons();
</script>

@stack('scripts')
</body>
</html>
