@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold mb-4">Active Debates</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($activeDebates as $debate)
            <div class="bg-white rounded shadow p-6">
                <h3 class="text-xl font-bold"><a href="{{ route('debates.show', $debate) }}" class="text-indigo-600 hover:underline">{{ $debate->title }}</a></h3>
                <p class="text-gray-600 mt-2 truncate">{{ $debate->description }}</p>
                <div class="mt-4 flex justify-between text-sm text-gray-500">
                    <span>Pro: {{ $debate->proUser->name ?? 'Waiting...' }}</span>
                    <span>Con: {{ $debate->conUser->name ?? 'Waiting...' }}</span>
                </div>
            </div>
        @empty
            <p>No active debates happening right now.</p>
        @endforelse
    </div>
</div>

<div>
    <h2 class="text-2xl font-bold mb-4">Completed Debates</h2>
    <ul class="bg-white rounded shadow divide-y">
        @foreach($completedDebates as $debate)
            <li class="p-4 flex justify-between">
                <div>
                    <a href="{{ route('debates.show', $debate) }}" class="font-bold hover:text-indigo-600">{{ $debate->title }}</a>
                    <div class="text-xs text-gray-500">Winner: {{ $debate->winner->name }}</div>
                </div>
                <span class="px-2 py-1 bg-gray-200 rounded text-xs h-fit">Completed</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection