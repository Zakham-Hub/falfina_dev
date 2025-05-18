<?php

namespace App\Http\Controllers\Dashboard\Manager;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard.manager.dashboard', ['PageTitle' => trans('dashboard/header.main_dashboard')]);
    }
}
