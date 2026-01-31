<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin/dashboard">
                        @elseif(auth()->user()->role === 'owner')
                            <a href="/owner/dashboard">
                        @else
                            <a href="/user/dashboard">
                        @endif
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                        </a>
                    @endauth
                </div>

                <!-- Nav Links -->
                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->role === 'admin')
                        <x-nav-link href="/admin/dashboard">
                            Dashboard Admin
                        </x-nav-link>
                    @elseif(auth()->user()->role === 'owner')
                        <x-nav-link href="/owner/dashboard">
                            Dashboard Owner
                        </x-nav-link>
                    @else
                        <x-nav-link href="/user/dashboard">
                            Dashboard User
                        </x-nav-link>
                    @endif
                </div>
                @endauth
            </div>

            <!-- RIGHT -->
             @guest
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}"
                class="text-sm font-medium text-gray-600 hover:text-gray-900">
                    Login
                </a>

                <a href="{{ route('register') }}"
                class="text-sm font-medium text-gray-600 hover:text-gray-900">
                    Register
                </a>
            </div>
            @endguest

            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-md hover:text-gray-700">
                            <div>{{ auth()->user()->name }}</div>
                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4z"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('profile.edit') }}">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-gray-400">
                    ☰
                </button>
            </div>
        </div>
    </div>
</nav>
