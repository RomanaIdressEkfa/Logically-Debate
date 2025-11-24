@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $debate->title }}</h1>
            <p class="mt-2 text-gray-600">{{ $debate->description }}</p>
            <div class="mt-2 text-sm text-gray-500">
                Judge: <span class="font-semibold">{{ $debate->judge->name }}</span> | 
                Status: <span class="uppercase font-bold {{ $debate->status == 'active' ? 'text-green-600' : 'text-gray-600' }}">{{ $debate->status }}</span>
            </div>
        </div>
        <!-- Join Buttons -->
        <div class="flex gap-2">
            @if($debate->status == 'pending')
                @if(Auth::check() && Auth::user()->role == 'pro_person' && !$debate->pro_user_id)
                    <form action="{{ route('debates.join', $debate) }}" method="POST">@csrf <button class="bg-blue-600 text-white px-4 py-2 rounded">Join as PRO</button></form>
                @endif
                @if(Auth::check() && Auth::user()->role == 'con_person' && !$debate->con_user_id)
                    <form action="{{ route('debates.join', $debate) }}" method="POST">@csrf <button class="bg-red-600 text-white px-4 py-2 rounded">Join as CON</button></form>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Arguments Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- PRO SIDE -->
    <div class="bg-blue-50 border border-blue-200 rounded p-4 min-h-[400px]">
        <h3 class="text-xl font-bold text-blue-800 border-b border-blue-200 pb-2 mb-4">PRO SIDE ({{ $debate->proUser->name ?? 'Vacant' }})</h3>
        <div class="space-y-4">
            @foreach($debate->arguments->where('side', 'pro') as $arg)
                <div class="bg-white p-3 rounded shadow text-sm">
                    <p>{{ $arg->argument }}</p>
                    <div class="text-xs text-gray-400 mt-1">{{ $arg->created_at->format('H:i') }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- CON SIDE -->
    <div class="bg-red-50 border border-red-200 rounded p-4 min-h-[400px]">
        <h3 class="text-xl font-bold text-red-800 border-b border-red-200 pb-2 mb-4">CON SIDE ({{ $debate->conUser->name ?? 'Vacant' }})</h3>
        <div class="space-y-4">
            @foreach($debate->arguments->where('side', 'con') as $arg)
                <div class="bg-white p-3 rounded shadow text-sm">
                    <p>{{ $arg->argument }}</p>
                    <div class="text-xs text-gray-400 mt-1">{{ $arg->created_at->format('H:i') }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Controls -->
@auth
<div class="mt-8 bg-gray-100 p-6 rounded">
    @if($debate->status == 'active')
        <!-- Argument Form -->
        @if((Auth::id() == $debate->pro_user_id) || (Auth::id() == $debate->con_user_id))
            <h3 class="font-bold mb-2">Submit Argument</h3>
            <form action="{{ route('debates.argument', $debate) }}" method="POST">
                @csrf
                <textarea name="argument" class="w-full border rounded p-2" rows="3" required placeholder="Type your argument..."></textarea>
                <button class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded">Post Argument</button>
            </form>
        @endif
    @endif

    <!-- Judge Control -->
    @if(Auth::id() == $debate->judge_id && $debate->status != 'completed')
        <div class="border-t mt-4 pt-4">
            <h3 class="font-bold text-purple-700">Judge Controls</h3>
            <form action="{{ route('debates.winner', $debate) }}" method="POST" class="mt-2 flex gap-4 items-center">
                @csrf
                <label>Declare Winner:</label>
                <select name="winner_id" class="border p-2 rounded">
                    @if($debate->pro_user_id) <option value="{{ $debate->pro_user_id }}">Pro: {{ $debate->proUser->name }}</option> @endif
                    @if($debate->con_user_id) <option value="{{ $debate->con_user_id }}">Con: {{ $debate->conUser->name }}</option> @endif
                </select>
                <button class="bg-purple-600 text-white px-4 py-2 rounded">End Debate</button>
            </form>
        </div>
    @endif

    @if($debate->status == 'completed')
        <div class="text-center p-4 bg-yellow-100 border border-yellow-400 rounded text-yellow-800 font-bold text-xl">
            WINNER: {{ $debate->winner->name }} ({{ $debate->winner_id == $debate->pro_user_id ? 'PRO' : 'CON' }})
        </div>
    @endif
</div>
@endauth

@endsection