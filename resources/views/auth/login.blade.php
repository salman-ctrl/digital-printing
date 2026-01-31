<x-guest-layout>
    <x-auth-card>

        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo.png') }}" class="h-14" alt="CV Anugrah Murni Sejati">
        </div>

        <!-- Title -->
        <h1 class="text-xl font-semibold text-center text-gray-800">
            CV. Anugrah Murni Sejati
        </h1>
        <p class="text-sm text-center text-gray-500 mb-6">
            Sistem Informasi Digital Printing
        </p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    class="block w-full mt-1 rounded-md"
                    required autofocus />
            </div>

            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    class="block w-full mt-1 rounded-md"
                    required />
            </div>

            <button
                type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-md font-semibold transition">
                Login
            </button>
        </form>

        <p class="text-xs text-center text-gray-400 mt-6">
            © {{ date('Y') }} CV. Anugrah Murni Sejati
        </p>

    </x-auth-card>
</x-guest-layout>
