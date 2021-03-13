<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;

class PublicController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }
}
