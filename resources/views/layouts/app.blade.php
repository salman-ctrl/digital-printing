<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'CV Anugrah Murni Sejati' }}</title>

    {{-- FONT SYSTEM GLOBAL --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind = {
            config: {
                // Konfigurasi tailwind jika diperlukan
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- DESIGN SYSTEM --}}
    <style>
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338CA;

            --bg: #F8FAFC;
            --card: #FFFFFF;

            --text: #0F172A;
            --muted: #64748B;
            --border: #E2E8F0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
        }
    </style>

</head>

<body class="bg-[var(--bg)] font-sans">

    @include('partials.header')

    <main class="container mx-auto px-6 py-10">
        @yield('content')
    </main>

    @include('partials.footer')

</body>

<script src="https://unpkg.com/lucide@latest"></script>

<script>
    lucide.createIcons();
</script>
</html>