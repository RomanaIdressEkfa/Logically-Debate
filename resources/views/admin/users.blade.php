@extends('layouts.app')

@section('content')
<div class="flex min-h-screen -mx-4 sm:-mx-6 lg:-mx-8 -mt-6">
     <div class="w-64 bg-gray-900 text-white p-6 hidden md:block">
        <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white mb-4 block">← Back to Dashboard</a>
    </div>

    <div class="flex-1 bg-gray-100 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Users Management</h1>
            <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-semibold">Filter: {{ $currentFilter ?? 'All' }}</span>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-5 py-3 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Approved?</th>
                        <th class="px-5 py-3 bg-gray-50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-5 py-5 text-sm">{{ $user->name }}</td>
                        <td class="px-5 py-5 text-sm">{{ $user->email }}</td>
                        <td class="px-5 py-5 text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td class="px-5 py-5 text-sm">
                            @if($user->is_approved)
                                <span class="text-green-600 font-bold">Yes</span>
                            @else
                                <span class="text-red-500 font-bold animate-pulse">Pending</span>
                            @endif
                        </td>
                        <td class="px-5 py-5 text-sm text-right">
                            @if(!$user->is_approved)
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">Approve</button>
                                </form>
                                <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" class="inline ml-2">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600" onclick="return confirm('Delete user?')">Reject</button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 text-xs font-bold" onclick="return confirm('Ban/Delete this user?')">Ban/Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-5 text-center text-gray-500">No users found for this filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection