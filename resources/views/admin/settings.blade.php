@extends('layouts.app')

@section('content')
<div class="flex min-h-screen -mx-4 sm:-mx-6 lg:-mx-8 -mt-6">
    <!-- REPEAT SIDEBAR (Or make a layout component) - For simplicity, pasting simplified sidebar link -->
    <div class="w-64 bg-gray-900 text-white p-6 hidden md:block">
        <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white mb-4 block">← Back to Dashboard</a>
    </div>

    <div class="flex-1 bg-gray-100 p-8">
        <h1 class="text-2xl font-bold mb-6">Admin Settings</h1>

        <div class="bg-white p-6 rounded shadow max-w-2xl">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Admin Name</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <hr class="my-6">
                <h3 class="font-bold text-lg mb-4">Change Password</h3>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">New Password (Optional)</label>
                    <input type="password" name="password" class="border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <button class="bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700">Update Profile</button>
            </form>
        </div>
    </div>
</div>
@endsection