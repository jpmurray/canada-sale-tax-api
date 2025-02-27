<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Rate::class);

        return view('rates.index', [
            'rates' => Rate::orderBy('start', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Rate::class);

        return view('rates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Rate::class);

        $validated = $request->validate([
            'province' => 'required|string|max:2',
            'start' => 'required|date',
            'pst' => 'required|numeric|min:0',
            'gst' => 'required|numeric|min:0',
            'hst' => 'required|numeric|min:0',
            'applicable' => 'required|numeric|min:0',
            'type' => 'required|string',
            'source' => 'required|string',
        ]);

        Rate::create($validated);

        return redirect()->route('dashboard')->with('success', 'Rate added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rate $rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rate $rate)
    {
        Gate::authorize('update', $rate);

        return view('rates.edit', compact('rate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rate $rate)
    {
        Gate::authorize('update', $rate);

        $validated = $request->validate([
            'province' => 'required|string|max:2',
            'start' => 'required|date',
            'pst' => 'required|numeric|min:0',
            'gst' => 'required|numeric|min:0',
            'hst' => 'required|numeric|min:0',
            'applicable' => 'required|numeric|min:0',
            'type' => 'required|string',
            'source' => 'required|string',
        ]);

        $rate->update($validated);

        return redirect()->route('dashboard')->with('success', 'Rate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rate $rate)
    {
        //
    }
}
