<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainSettingRequest;
use App\Services\Contracts\MainSettingInterface;
use App\DataTables\Dashboard\History\HistoryDataTable;
class MainSettingsController extends Controller {
    public function __construct(protected MainSettingInterface $settingRepository, protected HistoryDataTable $historyDataTable) {
        $this->settingRepository = $settingRepository;
        $this->historyDataTable = $historyDataTable;
    }
    public function index() {
        return $this->settingRepository->index();
    }

    public function history(HistoryDataTable $historyDataTable)
    {
        return $this->settingRepository->history($this->historyDataTable);
    }

    public function store(MainSettingRequest $request) {
        return $this->settingRepository->save($request);
    }
}
