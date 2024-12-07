<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $staff = User::all();
            return view('staff.index', compact('staff'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching staff.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $roles = Role::all();
            return view('staff.create', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching roles.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required'
            ]);


            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password)
                ]);

                $user->assignRole($request->role);
            }); // Used DB transaction to rollback if any error occurs

            return redirect()->route('staff.index')->with('success', 'Staff created successfully with role: ' . $request->role);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating staff.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $staff = User::findOrFail($id);
            return view('staff.show', compact('staff'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching staff.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        try {
            $roles = Role::all();
            return view('staff.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching staff.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required',
            ]);

            $user->update($request->only('name', 'email'));
            $user->syncRoles($request->role);

            return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating staff.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting staff.');
        }
    }
}
