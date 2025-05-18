<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;
use Illuminate\Http\Request;

class linkPasswordProtected
{
    public function handle(Request $request, Closure $next)
    {
        $authenticatedUser = get_user_data()->id;
        $link_password_status = Admin::whereId($authenticatedUser)->first()->link_password_status;
        if ($link_password_status == 0)
            return back()->with('error', trans('dashboard/general.you_are_not_allowed_to_access_to_link'));
        //return redirect()->route('admin.PasswordLink.create_password')->with('error', trans('dashboard/general.you_are_not_allowed_to_access_to_link'));
        if (!session()->has('link_password_verified')) {
            session()->put('intended_url', $request->fullUrl());
            return redirect()->route('admin.link_password.form');
        }
        return $next($request);
    }
}
