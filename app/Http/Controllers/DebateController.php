<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\DebateArgument;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DebateController extends Controller
{
    public function index()
    {
        $activeDebates = Debate::where('status', 'active')
            ->with(['proUser', 'conUser', 'judge'])
            ->latest()
            ->get();
        
        $completedDebates = Debate::where('status', 'completed')
            ->with(['proUser', 'conUser', 'judge', 'winner'])
            ->latest()
            ->take(10)
            ->get();

        return view('debates.index', compact('activeDebates', 'completedDebates'));
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'Please login to create a debate');
        }

        $judges = User::where('role', 'judge')->where('is_approved', true)->get();
        $proUsers = User::where('role', 'pro_person')->where('is_approved', true)->get();
        $conUsers = User::where('role', 'con_person')->where('is_approved', true)->get();

        return view('debates.create', compact('judges', 'proUsers', 'conUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'judge_id' => 'required|exists:users,id',
        ]);

        $debate = Debate::create([
            'title' => $request->title,
            'description' => $request->description,
            'judge_id' => $request->judge_id,
            'pro_user_id' => auth()->user()->role === 'pro_person' ? auth()->id() : null,
            'con_user_id' => auth()->user()->role === 'con_person' ? auth()->id() : null,
            'status' => 'pending',
        ]);

        return redirect()->route('debates.show', $debate)->with('success', 'Debate created successfully');
    }

    public function show(Debate $debate)
    {
        $debate->load(['proUser', 'conUser', 'judge', 'arguments.user']);
        return view('debates.show', compact('debate'));
    }

    public function join(Debate $debate, Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'pro_person' && !$debate->pro_user_id) {
            $debate->update(['pro_user_id' => $user->id]);
        } elseif ($user->role === 'con_person' && !$debate->con_user_id) {
            $debate->update(['con_user_id' => $user->id]);
        } else {
            return back()->with('error', 'Cannot join this debate');
        }

        if ($debate->pro_user_id && $debate->con_user_id && $debate->status === 'pending') {
            $debate->update([
                'status' => 'active',
                'started_at' => now(),
                'ends_at' => now()->addHours(24),
            ]);
        }

        return back()->with('success', 'Joined debate successfully');
    }

    public function submitArgument(Request $request, Debate $debate)
    {
        $request->validate([
            'argument' => 'required|string',
        ]);

        $user = auth()->user();
        $side = $debate->pro_user_id === $user->id ? 'pro' : 'con';

        DebateArgument::create([
            'debate_id' => $debate->id,
            'user_id' => $user->id,
            'argument' => $request->argument,
            'side' => $side,
        ]);

        return back()->with('success', 'Argument submitted successfully');
    }

    public function declareWinner(Request $request, Debate $debate)
    {
        if (auth()->id() !== $debate->judge_id) {
            return back()->with('error', 'Only the judge can declare a winner');
        }

        $request->validate([
            'winner_id' => 'required|exists:users,id',
        ]);

        $debate->update([
            'winner_id' => $request->winner_id,
            'status' => 'completed',
        ]);

        return back()->with('success', 'Winner declared successfully');
    }
}
