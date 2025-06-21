<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        return view('auth.login', [
            'target' => $request->query('target')
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // // di localhost
        // $allowedTargets = [
        //     'http://127.0.0.1:8000', 
        //     'http://127.0.0.1:8001', 
        //     'http://127.0.0.1:8002'
        // ];
        // // di server
        // // $allowedTargets = [
        // //     'https://mokapppa.jakarta.go.id/v1', 
        // //     'http://mokapppa.jakarta.go.id/mona'
        // // ];

        // if (!in_array($request->input('target'), $allowedTargets)) {
        //     abort(403, 'Target tidak diizinkan');
        // }

        $request->authenticate();

        $request->session()->regenerate();
        if ($request->filled('target')) {
            // jika ada target, berarti ini login dari apss lain dan mau menuju apss tersebut
            $user = Auth::user();

            $token = encrypt(implode('|', [
                $user->email,
                $user->jabatan ?? '',
                $user->aktif ?? '',
                $user->deleted_at ?? '',
                now()
            ]));

            session(['sso_token' => $token]);
            
            return redirect()->route('sso.callback', [
                'target' => $request->input('target'),
                'token' => $token
            ]);
        }
        // jika tidak ada target, berarti ini login biasa
        return redirect()->intended('/dashboard');

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
