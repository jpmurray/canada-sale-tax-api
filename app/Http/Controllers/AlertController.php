<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Alert::class);

        return view('alerts.index')->with([
            'alerts' => Alert::orderBy('created_at', 'DESC')->paginate('10'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Alert::class);

        return view('alerts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Alert::class);

        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        $alert = new Alert();
        $alert->type = $validated['type'];
        $alert->message = $validated['message'];
        $alert->active = isset($validated['active']) ? true : false;
        $alert->save();

        return redirect()->route('alerts.index')->with('success', 'Alert created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alert $alert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alert $alert)
    {
        return view('alerts.edit')->with([
            'alert' => $alert,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alert $alert)
    {
        Gate::authorize('update', $alert);

        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'active' => 'nullable',
        ]);

        $alert->type = $validated['type'];
        $alert->message = $validated['message'];
        $alert->active = isset($validated['active']) ? true : false;
        $alert->save();

        return redirect()->route('alerts.index')->with('success', 'Alert updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alert $alert)
    {
        //
    }
}
