<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SSOController extends Controller
{
    public function callback(Request $request)
    {
        return view('sso.callback', [
            'token' => $request->get('token'),
            'target' => $request->get('target')
        ]);
    }
}

