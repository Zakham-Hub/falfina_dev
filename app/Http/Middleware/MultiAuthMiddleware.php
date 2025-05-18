<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MultiAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (check_guard())
            return $next($request);

        $loginRoute = $request->is('admin/*') ? route('admin.login') : route('manager.login');
        return redirect($loginRoute);
    }
}
