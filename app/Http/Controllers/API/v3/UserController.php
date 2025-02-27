<?php

namespace App\Http\Controllers\API\v3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v3\UserResource;

class UserController extends Controller
{

    public function show(Request $request)
    {
        $request->user()->tokenCan('read');

        return new UserResource($request->user());
    }
}
