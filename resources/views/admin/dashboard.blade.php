@extends('layouts.app')

@section('content')
<div class="flex min-h-screen -mx-4 sm:-mx-6 lg:-mx-8 -mt-6">
    
    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white flex flex-col min-h-screen">
        <div class="p-6 text-center font-bold text-2xl border-b border-gray-700">
            Admin Panel
        </div>
        <nav class="flex-1 p-4 space-y-2">
            
            <p class="text-xs text-gray-500 uppercase px-2 mb-2 mt-2">General</p>
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.settings') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.settings') ? 'bg-indigo-600' : '' }}">
                Settings (Profile)
            </a>

            <p class="text-xs text-gray-500 uppercase px-2 mb-2 mt-6">Management</p>
            <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('admin/users') ? 'bg-indigo-600' : '' }}">
                All Users
            </a>
            <a href="{{ route('admin.users', 'judge') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('admin/users/judge') ? 'bg-indigo-600' : '' }}">
                Judges
            </a>
            <a href="{{ route('admin.users', 'pro') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('admin/users/pro') ? 'bg-indigo-600' : '' }}">
                Pro Persons
            </a>
            <a href="{{ route('admin.users', 'con') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->is('admin/users/con') ? 'bg-indigo-600' : '' }}">
                Con Persons
            </a>

            <p class="text-xs text-gray-500 uppercase px-2 mb-2 mt-6">Content</p>
            <a href="{{ route('admin.debates') }}" class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.debates') ? 'bg-indigo-600' : '' }}">
                Manage Debates
            </a>
        </nav>
        <div class="p-4 border-t border-gray-700">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 text-red-400 hover:text-white">Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 bg-gray-100 p-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Dashboard Overview</h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                <div class="text-gray-500 text-sm">Pending Approvals</div>
                <div class="text-3xl font-bold text-gray-800">{{ $pendingUsers }}</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                <div class="text-gray-500 text-sm">Total Users</div>
                <div class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</div>
            </div>
             <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                <div class="text-gray-500 text-sm">Active Debates</div>
                <div class="text-3xl font-bold text-gray-800">{{ $activeDebates }}</div>
            </div>
             <div class="bg-white p-6 rounded-lg shadow border-l-4 border-gray-500">
                <div class="text-gray-500 text-sm">Total Debates</div>
                <div class="text-3xl font-bold text-gray-800">{{ $totalDebates }}</div>
            </div>
        </div>
    </div>
</div>
@endsection