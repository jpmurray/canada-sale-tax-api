<?php

namespace App\Http\Controllers\API\v3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function show(Request $request)
    {
        $request->user()->tokenCan('read');

        return $request->user();
    }
}
