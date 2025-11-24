@extends('layouts.app')

@section('content')
<div class="flex">
    <div class="w-64 bg-white shadow-md rounded-lg p-4 mr-6 min-h-screen">
         <ul class="space-y-2">
            <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Dashboard</a></li>
            <li><a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded bg-indigo-50 text-indigo-700">User Approvals</a></li>
            <li><a href="{{ route('admin.debates') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Manage Debates</a></li>
        </ul>
    </div>

    <div class="flex-1">
        <h1 class="text-2xl font-bold mb-6">User Management</h1>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $user->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $user->email }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-bold">{{ strtoupper($user->role) }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            @if($user->is_approved)
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Approved</span>
                                </span>
                            @else
                                <span class="relative inline-block px-3 py-1 font-semibold text-yellow-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-yellow-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Pending</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex gap-2">
                            @if(!$user->is_approved)
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs">Approve</button>
                                </form>
                                <form action="{{ route('admin.users.reject', $user->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Reject</button>
                                </form>
                            @else
                                <button class="text-gray-400 cursor-not-allowed">Active</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection