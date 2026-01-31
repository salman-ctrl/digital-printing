<header class="bg-white shadow">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
        <h1 class="font-bold">Dashboard User</h1>

        <div class="flex items-center space-x-4">
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-600 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
