<?php

namespace App\Http\Controllers;

use App\Models\Ssubject;
use Illuminate\Http\Request;

class SsubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ssubjects = Ssubject::all();
        return view('ssubject.index', compact('ssubjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ssubject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'fees' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        Ssubject::create($validated);

        return redirect()->route('ssubject.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ssubject $ssubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ssubject $ssubject)
    {
        return view('ssubject.edit', compact('ssubject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ssubject $ssubject)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'fees' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $ssubject->update($validated);

        return redirect()->route('ssubject.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ssubject $ssubject)
    {
        $ssubject->delete();

        return redirect()->route('ssubject.index')->with('success', 'Subject deleted successfully.');
    }
}