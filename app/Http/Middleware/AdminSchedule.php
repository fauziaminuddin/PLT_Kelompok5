<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSchedule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //check user id dari yang login
        if (auth()->check() && auth()->user()->id !== 1) {
            // Jika tidak sesuai, arahkan ke halaman lain dan tampilkan pesan kesalahan
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke menu ini.');
        }
        
        return $next($request);
    }
}
