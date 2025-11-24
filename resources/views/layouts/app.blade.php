<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LogicallyDebate') }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for interactivity (optional but recommended) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">

    <!-- Navigation -->
    <nav class="bg-white shadow mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">LogicallyDebate</a>
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('debates.index') }}" class="hover:text-indigo-600">Debates</a>
                        @auth
                            <a href="{{ route('debates.create') }}" class="hover:text-indigo-600">Start Debate</a>
                        @endauth
                    </div>
                </div>
                <div class="flex items-center">
                    @auth
                        <span class="mr-4 text-sm text-gray-600">
                            {{ Auth::user()->name }} 
                            <span class="px-2 py-1 bg-gray-200 rounded text-xs">{{ strtoupper(Auth::user()->role) }}</span>
                        </span>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 font-bold mr-4">Admin Panel</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
                        </form>
                    @else
                        <span class="text-sm text-gray-500 italic">Guest (Wait 1 min for login)</span>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>