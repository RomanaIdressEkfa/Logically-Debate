<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Debate;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function dashboard()
    {
        $pendingUsers = User::where('is_approved', false)->where('role', '!=', 'admin')->count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $activeDebates = Debate::where('status', 'active')->count();
        $totalDebates = Debate::count();

        return view('admin.dashboard', compact('pendingUsers', 'totalUsers', 'activeDebates', 'totalDebates'));
    }

    public function users()
    {
        $users = User::where('role', '!=', 'admin')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);
        return back()->with('success', 'User approved successfully');
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User rejected and deleted');
    }

    public function debates()
    {
        $debates = Debate::with(['proUser', 'conUser', 'judge'])->latest()->paginate(20);
        return view('admin.debates', compact('debates'));
    }

    public function deleteDebate($id)
    {
        $debate = Debate::findOrFail($id);
        $debate->delete();
        return back()->with('success', 'Debate deleted successfully');
    }
}
