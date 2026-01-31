<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Dashboard User' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

@include('partials.header-user')

<main class="container mx-auto px-6 py-10">
    @yield('content')
</main>

@include('partials.footer')

</body>
</html>
