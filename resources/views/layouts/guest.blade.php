<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Digital Printing | CV Anugrah Murni Sejati' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-cv2.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

@include('partials.header-guest')

@yield('hero')

<main class="container mx-auto px-6 py-12">
    @yield('content')
</main>

@include('partials.footer')

</body>
</html>
