<header class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center justify-between h-16">
            <div class="flex-shrink-0">
                <h2 class="text-2xl font-bold text-white hover:text-gray-200 transition-colors cursor-pointer">
                    YouCommunity
                </h2>
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-8">
                    <a href="/home"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Home</a>
                    @auth
                        <a href="/profile"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Profile</a>
                        <a href="/logout">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Logout</button>
                            </form>
                        </a>
                    @else
                        <a href="/register"
                            class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                        <a href="/login"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Login</a>
                    @endauth
                </div>
            </div>
            <div class="md:hidden">
                <button class="text-gray-400 hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>
    </div>
</header>
<div class="mb-4 text-white rounded-lg bg-green-500 border-l-4 border-green-700 shadow-md">
    <p>{{ session('success') ?? '' }}</p>
</div>
<div class="mb-4 text-white rounded-lg bg-red-500 border-l-4 border-red-700 shadow-md">
    <p>{{ session('error') ?? '' }}</p>
</div>
