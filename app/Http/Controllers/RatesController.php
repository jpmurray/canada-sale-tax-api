<?php

namespace App\Http\Controllers;

use App\Rates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class RatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($province)
    {
        $this->authAdmin();

        $rates = Rates::where('province', $province)->orderBy('start', 'DESC')->get();

        if ($rates->count() == 0) {
            abort(404, "No entries for this province. You should add at least one.");
        }
        
        return view('rates')->with(['rates' => $rates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authAdmin();

        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->authAdmin();

        $this->validate(request(), [
            'province' => 'required',
            'pst' => 'numeric',
            'gst' => 'numeric',
            'hst' => 'numeric',
            'applicable' => 'numeric|required',
            'type' => 'required',
            'start' => 'date|required',
            'source' => 'required',
        ]);

        $rate = Rates::create(request()->only(['province', 'pst', 'gst', 'hst', 'applicable', 'type', 'start', 'source']));

        Cache::flush();

        return redirect()->route('rates.edit', ['id' => $rate->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rates  $rates
     * @return \Illuminate\Http\Response
     */
    public function show(Rates $rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rates  $rates
     * @return \Illuminate\Http\Response
     */
    public function edit(Rates $rate)
    {
        $this->authAdmin();

        return view('edit')->with(['rate' => $rate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rates  $rates
     * @return \Illuminate\Http\Response
     */
    public function update(Rates $rate)
    {
        $this->authAdmin();
        
        $this->validate(request(), [
            'province' => 'required',
            'pst' => 'numeric',
            'gst' => 'numeric',
            'hst' => 'numeric',
            'applicable' => 'numeric|required',
            'type' => 'required',
            'start' => 'date|required',
            'source' => 'required',
        ]);

        $rate->update(request()->only(['province', 'pst', 'gst', 'hst', 'applicable', 'type', 'start', 'source']));

        Cache::flush();
        
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rates  $rates
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rates $rate)
    {
        //
    }

    public function authAdmin()
    {
        if (Gate::denies('do-anything')) {
            abort(401, "I'm sorry Dave, I'm afraid I cannot let you do that.");
        }
    }
}
