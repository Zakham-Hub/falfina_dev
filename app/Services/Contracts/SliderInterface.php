<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\SliderDataTable;
use Illuminate\Http\Request;

interface SliderInterface
{
    public function index(SliderDataTable $sliderDataTable);
    public function create();
    public function store(Request $request);
}
