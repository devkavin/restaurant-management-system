<?php

namespace App\Http\Controllers;

use App\Models\Concession;
use Illuminate\Http\Request;
use Storage;

class ConcessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $concessions = Concession::paginate(10);
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
                'description' => 'nullable|string',
                'image' => 'required|image',
                'price' => 'required|numeric'
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images/concessions', 'public');
            } else {
                // Set default image if no image is uploaded
                $path = 'placeholder.svg';
            }

            Concession::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $path,
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
                'description' => 'nullable|string',
                'image' => 'required|image',
                'price' => 'required|numeric'
            ]);

            $concession->update(request()->only('name', 'description', 'price'));

            if ($request->hasFile('image')) {
                // delete the old image file
                if ($concession->image != 'placeholder.svg') {
                    Storage::disk('public')->delete($concession->image);
                }
                $path = $request->file('image')->store('images/concessions', 'public');
                $concession->update(['image' => $path]);
            } else {
                // default image if no image is uploaded
                $concession->update(['image' => 'placeholder.svg']);
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

            // Delete the image file
            if ($concession->image != 'placeholder.svg') {
                Storage::disk('public')->delete($concession->image);
            }
            return redirect()->route('concessions.index')->with('success', 'Concession deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting concession. ' . $e->getMessage());
        }
    }
}
