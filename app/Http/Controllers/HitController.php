<?php

namespace App\Http\Controllers;

use App\Models\Hit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Hit::class);

        return view('hits.index', [
            'hits' => Hit::orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Hit $hit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hit $hit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hit $hit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hit $hit)
    {
        //
    }
}
