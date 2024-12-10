<?php

namespace App\Http\Controllers;

use App\Models\Concession;
use Illuminate\Http\Request;

class ConcessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $concessions = Concession::all();
            return view('concessions.index', compact('concessions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching concessions. ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('concessions.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching concessions. ' . $e->getMessage());
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
                'description' => 'required|string',
                'image' => 'required|image',
                'price' => 'required|numeric'
            ]);

            $image = $request->file('image');
            $image_name = time() . '.' . $image->extension();
            $image->move(public_path('images'), $image_name);

            Concession::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $image_name,
                'price' => $request->price
            ]);

            return redirect()->route('concessions.index')->with('success', 'Concession created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating concession. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Concession $concession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Concession $concession)
    {
        try {
            return view('concessions.edit', compact('concession'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching concession. ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Concession $concession)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric'
            ]);

            $concession->update(request()->only('name', 'description', 'price'));

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->extension();
                $image->move(public_path('images'), $image_name);
                $concession->update(['image' => $image_name]);
            }

            return redirect()->route('concessions.index')->with('success', 'Concession updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating concession. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Concession $concession)
    {
        try {
            $concession->delete();
            return redirect()->route('concessions.index')->with('success', 'Concession deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting concession. ' . $e->getMessage());
        }
    }
}
