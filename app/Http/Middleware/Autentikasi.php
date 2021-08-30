<?php

namespace App\Http\Middleware;

use App\Models\DriverLoginLogs;
use Closure;
use Illuminate\Http\Request;

class Autentikasi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $statusLogin = DriverLoginLogs::where('token', $request->session()->get('token'))
            ->where('status', 1)
            ->where('id_driver', $request->session()->get('id_driver'))
            ->first();
        if ($statusLogin) {
            return $next($request);
        } else {
            return redirect('/login');
        }
    }
}
