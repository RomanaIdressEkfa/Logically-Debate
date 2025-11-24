@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-md rounded-lg p-4 mr-6 h-screen">
        <h2 class="text-xl font-bold mb-4">Super Admin</h2>
        <ul class="space-y-2">
            <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded bg-indigo-50 text-indigo-700">Dashboard</a></li>
            <li><a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded hover:bg-gray-100">User Approvals</a></li>
            <li><a href="{{ route('admin.debates') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Manage Debates</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="flex-1">
        <h1 class="text-2xl font-bold mb-6">Admin Overview</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded shadow border-l-4 border-yellow-500">
                <div class="text-gray-500">Pending Approvals</div>
                <div class="text-3xl font-bold">{{ $pendingUsers }}</div>
            </div>
            <div class="bg-white p-6 rounded shadow border-l-4 border-blue-500">
                <div class="text-gray-500">Total Users</div>
                <div class="text-3xl font-bold">{{ $totalUsers }}</div>
            </div>
            <div class="bg-white p-6 rounded shadow border-l-4 border-green-500">
                <div class="text-gray-500">Active Debates</div>
                <div class="text-3xl font-bold">{{ $activeDebates }}</div>
            </div>
             <div class="bg-white p-6 rounded shadow border-l-4 border-gray-500">
                <div class="text-gray-500">Total Debates</div>
                <div class="text-3xl font-bold">{{ $totalDebates }}</div>
            </div>
        </div>
    </div>
</div>
@endsection