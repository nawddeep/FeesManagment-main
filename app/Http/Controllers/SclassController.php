<?php

namespace App\Http\Controllers;

use App\Models\sclass;
use Illuminate\Http\Request;

class SclassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       $sclasses = Sclass::all();
        return view('sclass.index', compact('sclasses'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('sclass.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
         $validated = $request->validate([
            'c_name'   => 'required|string|max:255',
            'fees'     => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'status'   => 'required|boolean',
        ]);

        Sclass::create($validated);

        return redirect()->route('sclass.index')->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(sclass $sclass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sclass $sclass)
    {
        //
        return view('sclass.edit', compact('sclass'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sclass $sclass)
    {
        //
         $validated = $request->validate([
            'c_name'   => 'required|string|max:255',
            'fees'     => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'status'   => 'required|boolean',
        ]);

        $sclass->update($validated);

        return redirect()->route('sclass.index')->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sclass $sclass)
    {
        //
         $sclass->delete();

        return redirect()->route('sclass.index')->with('success', 'Class deleted successfully.');
    }
}
