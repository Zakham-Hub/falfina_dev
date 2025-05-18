<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectBasedOnUrl
{
    public function handle(Request $request, Closure $next)
    {
        $currentUrl = $request->path();
        if (str_contains($currentUrl, 'admin')) {
            if (! admin_guard()->check() && ! str_contains($currentUrl, 'admin/login')) {
                return redirect()->route('admin.login');
            }
        } elseif (str_contains($currentUrl, 'teacher')) {
            if (! teacher_guard()->check() && ! str_contains($currentUrl, 'teacher/login')) {
                return redirect()->route('teacher.login');
            }
        } elseif (str_contains($currentUrl, 'academic')) {
            if (! academic_guard()->check() && ! str_contains($currentUrl, 'academic/login')) {
                return redirect()->route('academic.login');
            }
        }

        return $next($request);
    }
}
