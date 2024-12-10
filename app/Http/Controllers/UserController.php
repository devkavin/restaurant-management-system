<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::with('roles')->paginate(10);
            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching users. ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $roles = Role::all();
            return view('users.create', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching roles. ' . $e->getMessage());
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

            return redirect()->route('users.index')->with('success', 'user created successfully with role: ' . $request->role);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating user. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     try {
    //         $users = User::findOrFail($id);
    //         return view('users.show', compact('user'));
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'An error occurred while fetching user.');
    //     }
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        try {
            $roles = Role::all();
            return view('users.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching user. ' . $e->getMessage());
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
                'role' => 'required'
            ]);

            $user->update($request->only('name', 'email'));

            $user->syncRoles($request->role);

            return redirect()->route('users.index')->with('success', 'user updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating user. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'user deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting user. ' . $e->getMessage());
        }
    }
}
