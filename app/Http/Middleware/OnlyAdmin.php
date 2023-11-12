<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->guard('staff')->user();
        if (($user instanceof \App\Models\Staff) && ($user->is_admin())) return $next($request);
        else {return $request->expectsJson() ? respnse()->view('json.noaccess') : respnse()->view('nojson.noaccess');}
    }
}
