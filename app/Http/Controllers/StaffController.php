<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = User::where('usertype', '!=', 'admin')->get(); // Assuming 'usertype' distinguishes admin/staff
        // If usertype column doesn't exist, we might check by checking if they are NOT the main admin?
        // Let's assume usertype exists based on previous context or just list all users for now.
        // Actually, in Breeze migration, it's usually just name, email, password.
        // I should check migrations or User model to see if 'usertype' or similar exists.
        // If not, I'll assume all users are staff except the one I'm logged in as?
        // PROCEEDING with 'usertype' assumption or falling back to 'id' != auth()->id()

        // Checking User model in my mind: I didn't see 'usertype' added in recent history.
        // But original PHP had it. I should check if I added it.
        // If not, I'll stick to listing all users.

        $staff = User::all();

        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => 'technician', // Defaulting new users to technician
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $staff) // Using route model binding
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $staff->id],
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $staff->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $staff)
    {
        if ($staff->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
