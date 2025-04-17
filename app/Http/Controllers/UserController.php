<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user', [
            'except' => ['profile', 'updateProfile'],
        ]);
    }

    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin,editor,user',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Korisnik uspešno kreiran.');
    }

    /**
     * Show the form for editing a user
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];

        // Only admin can change roles
        if (Auth::user()->isAdmin()) {
            $rules['role'] = 'required|in:admin,editor,user';
        }

        // Password is optional on update
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $validated = $request->validate($rules);

        // Build update data
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Only add role if admin is updating
        if (Auth::user()->isAdmin() && isset($validated['role'])) {
            $updateData['role'] = $validated['role'];
        }

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        // Redirect to users index if admin, otherwise to dashboard
        if (Auth::user()->isAdmin() && Auth::id() !== $user->id) {
            return redirect()->route('users.index')
                ->with('success', 'Korisnik uspešno ažuriran.');
        } else {
            return redirect()->route('dashboard')
                ->with('success', 'Vaš profil je uspešno ažuriran.');
        }
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'Korisnik uspešno obrisan.');
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        return view('users.profile', ['user' => Auth::user()]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|confirmed',
        ]);
        
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];
        
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        $user->update($updateData);
        
        return redirect()->route('profile')
            ->with('success', 'Profil uspešno ažuriran.');
    }
}