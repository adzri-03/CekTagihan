<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->status == 0) {
                Auth::logout();

                Session::flash('status', 'Akun anda belum diaktivasi oleh admin');

                return redirect()->route('login')->withErrors([
                    'form.email' => 'Akun anda belum diaktivasi oleh admin'
                ]);
            }
        }

        return $next($request);
    }
}
