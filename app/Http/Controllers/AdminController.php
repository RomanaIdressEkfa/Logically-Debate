<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Debate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard Overview
    public function dashboard()
    {
        $pendingUsers = User::where('is_approved', false)->where('role', '!=', 'admin')->count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $activeDebates = Debate::where('status', 'active')->count();
        $totalDebates = Debate::count();

        return view('admin.dashboard', compact('pendingUsers', 'totalUsers', 'activeDebates', 'totalDebates'));
    }

    // Users List (With Filter)
    public function users($role = null)
    {
        $query = User::where('role', '!=', 'admin')->latest();

        if ($role) {
            // Map 'pro' and 'con' URL params to database enum values if necessary
            // Assuming DB roles are: 'user', 'judge', 'pro_person', 'con_person'
            if($role == 'pro') $role = 'pro_person';
            if($role == 'con') $role = 'con_person';
            
            $query->where('role', $role);
        }

        $users = $query->paginate(20);
        $currentFilter = $role ? ucfirst(str_replace('_person', '', $role)) : 'All';

        return view('admin.users', compact('users', 'currentFilter'));
    }

    public function approveUser($id) {
        User::findOrFail($id)->update(['is_approved' => true]);
        return back()->with('success', 'User approved.');
    }

    public function rejectUser($id) {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted.');
    }

    // Debates
    public function debates() {
        $debates = Debate::with(['proUser', 'conUser', 'judge'])->latest()->paginate(20);
        return view('admin.debates', compact('debates'));
    }
    
    public function deleteDebate($id) {
        Debate::findOrFail($id)->delete();
        return back()->with('success', 'Debate deleted.');
    }

    // Settings View
    public function settings()
    {
        return view('admin.settings');
    }

    // Update Settings
    public function updateSettings(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8|confirmed'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}