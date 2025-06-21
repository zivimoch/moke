<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function index(Request $request)
    {
        $user = Auth::user();

        $token = encrypt(implode('|', [
            $user->email,
            $user->jabatan ?? '',
            $user->aktif ?? '',
            $user->deleted_at ?? '',
            now()
        ]));

        session(['sso_token' => $token]);
        
        return view('dashboard', [
            'target' => $request->query('target')
        ]);
        
    }
}
