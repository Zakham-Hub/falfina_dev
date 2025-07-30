<?php

namespace App\Repositories;

use App\Models\Branch;
use App\Models\BranchDailySchedule;
use App\Models\BranchExceptionalHoliday;
use App\Models\BranchSpecialOccasion;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\DataTables\Dashboard\Admin\BranchDataTable;
use App\Services\Contracts\BranchInterface;
use Carbon\Carbon;

class BranchRepository implements BranchInterface
{
    public function index(BranchDataTable $branchDataTable)
    {
        return $branchDataTable->render('dashboard.admin.branches.index', ['pageTitle' => 'الفروع']);
    }

    public function create()
    {
        return view('dashboard.admin.branches.create', ['pageTitle' => 'إضافة فرع']);
    }

    public function store(StoreBranchRequest $request)
    {
        $validated = $request->validated();
        $branch = Branch::create([
                'name' => $validated['name'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'address' => $validated['address'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'coordinate' => $validated['coordinate'] ?? null
            ]);
        $this->processDailySchedules($branch, $validated['daily_schedules']);
        if(request()->has('exceptional_holidays')) {
            $this->processExceptionalHolidays($branch, $validated['exceptional_holidays']);
        }
        if(request()->has('special_occasions')) {
            $this->processSpecialOccasions($branch, $validated['special_occasions']);
        }

        return redirect()->route('admin.branches.index')->with('success', 'تم حفظ الفرع بنجاح!');
    }

    public function edit($id)
    {
        $branch = Branch::with(['dailySchedules', 'exceptionalHolidays', 'specialOccasions'])
                      ->findOrFail($id);
        return view('dashboard.admin.branches.edit', ['branch' => $branch, 'pageTitle' => 'تعديل الفرع']);
    }

    public function update(StoreBranchRequest $request, $id)
    {
        $validated = $request->validated();
        $branch = Branch::findOrFail($id);

        $branch->update([
                'name' => $validated['name'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'address' => $validated['address'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'coordinate' => $validated['coordinate'] ?? null
            ]);

        $this->processDailySchedules($branch, $validated['daily_schedules']);
        if(request()->has('exceptional_holidays')) {
            $this->processExceptionalHolidays($branch, $validated['exceptional_holidays']);
        }
        if(request()->has('special_occasions')) {
            $this->processSpecialOccasions($branch, $validated['special_occasions']);
        }
        return redirect()->route('admin.branches.index')->with('success', 'تم تحديث الفرع بنجاح!');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('admin.branches.index')->with('success', 'تم الحذف بنجاح!');
    }


    protected function processDailySchedules(Branch $branch, array $schedules)
    {
        $branch->dailySchedules()->delete();

        foreach ($schedules as $day => $schedule) {
            $dailySchedule = $branch->dailySchedules()->create([
                'day' => $day,
                'is_holiday' => $schedule['is_holiday'] ?? false,
            ]);

            if (!($schedule['is_holiday'] ?? false)) {
                foreach ($schedule['shifts'] as $shift) {
                    $dailySchedule->shifts()->create([
                        'name' => $shift['name'] ?? null,
                        'delivery_start_time' => $this->formatTime($shift['delivery_start_time']),
                        'delivery_end_time' => $this->formatTime($shift['delivery_end_time']),
                        'pickup_start_time' => $this->formatTime($shift['pickup_start_time']),
                        'pickup_end_time' => $this->formatTime($shift['pickup_end_time']),
                    ]);
                }
            }
        }
    }

    protected function processExceptionalHolidays(Branch $branch, array $holidays)
    {
        $branch->exceptionalHolidays()->delete();

        foreach ($holidays as $holiday) {
            $branch->exceptionalHolidays()->create([
                'title' => $holiday['title'],
                'start_date' => $holiday['start_date'],
                'end_date' => $holiday['end_date'] ?? null,
                'is_recurring' => $holiday['is_recurring'] ?? false,
                'description' => $holiday['description'] ?? null,
            ]);
        }
    }

    protected function processSpecialOccasions(Branch $branch, array $occasions)
    {
        $branch->specialOccasions()->delete();

        foreach ($occasions as $occasion) {
            $branch->specialOccasions()->create([
                'occasion_name' => $occasion['occasion_name'],
                'date' => $occasion['date'],
                'is_holiday' => $occasion['is_holiday'] ?? false,
                'opening_time' => $this->formatTime($occasion['opening_time'] ?? null),
                'closing_time' => $this->formatTime($occasion['closing_time'] ?? null),
                'delivery_start_time' => $this->formatTime($occasion['delivery_start_time'] ?? null),
                'delivery_end_time' => $this->formatTime($occasion['delivery_end_time'] ?? null),
                'pickup_start_time' => $this->formatTime($occasion['pickup_start_time'] ?? null),
                'pickup_end_time' => $this->formatTime($occasion['pickup_end_time'] ?? null),
                'description' => $occasion['description'] ?? null,
            ]);
        }
    }

    protected function formatTimeForDatabase($time)
    {
        if (empty($time)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('H:i', $time)->format('H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function formatTime($time)
    {
        return $time ? Carbon::createFromFormat('H:i', $time)->format('H:i:s') : null;
    }
}
