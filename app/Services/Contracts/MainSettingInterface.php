<?php

namespace App\Services\Contracts;

use App\Http\Requests\MainSettingRequest;
use App\DataTables\Dashboard\History\HistoryDataTable;
interface MainSettingInterface
{
    public function index();
    public function save(MainSettingRequest $request);
    public function history(HistoryDataTable $historyDataTable);
}
