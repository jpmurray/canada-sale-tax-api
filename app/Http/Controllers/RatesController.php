<?php

namespace App\Http\Controllers;

use App\Rates;
use Illuminate\Http\Request;

class RatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($province)
    {
        $rates = Rates::where('province', $province)->orderBy('start', 'DESC')->get();
        
        return view('rates')->with(['rates' => $rates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
}
