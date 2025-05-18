<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('admin_guard')) {
    function admin_guard()
    {
        return auth('admin');
    }
}

if (! function_exists('manager_guard')) {
    function manager_guard()
    {
        return auth('manager');
    }
}

if (! function_exists('check_guard')) {
    function check_guard()
    {
        $guards = ['admin', 'manager'];
        foreach ($guards as $guard) {
            if (auth($guard)->check()) {
                return auth($guard);
            }
        }
        return null;
    }
}

if (! function_exists('get_user_data')) {
    function get_user_data()
    {
        $guards = ['admin', 'manager'];
        foreach ($guards as $guard) {
            if (auth($guard)->check()) {
                return auth($guard)->user();
            }
        }

        return null;
    }
}

if (! function_exists('loadDashboardRoutes')) {
    function loadDashboardRoutes()
    {
        $dashboardPath = base_path('routes/dashboard');
        $files = glob($dashboardPath.'/*.php');

        foreach ($files as $file) {
            Route::middleware('web')->group($file);
        }
    }
}

if (! function_exists('is_active')) {
    /**
     * Check if the current route matches the given route(s).
     *
     * @param  string|array  $routes
     */
    function is_active($routes): string
    {
        if (is_array($routes)) {
            foreach ($routes as $route) {
                if (request()->routeIs($route)) {
                    return 'active';
                }
            }
        } else {
            if (request()->routeIs($routes)) {
                return 'active';
            }
        }

        return '';
    }
}
