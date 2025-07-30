@extends('dashboard.layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('pageTitle')
    {{ $pageTitle }}
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="mb-5 card card-xxl-stretch mb-xl-8">
        <div class="pt-5 border-0 card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="mb-1 card-label fw-bolder fs-3">{{ $pageTitle }}</span>
            </h3>
        </div>
        <div class="py-3 card-body">
            <form action="{{ route('admin.branches.update', $branch->id) }}" method="POST" id="branch-form">
                @csrf
                @method('PUT')

                <!-- Basic Branch Info -->
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">اسم الفرع:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $branch->name) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="phone" class="form-label">هاتف الفرع:</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $branch->phone) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="coordinate" class="form-label">المسافة:</label>
                        <input type="text" id="coordinate" name="coordinate" class="form-control" value="{{ old('coordinate', $branch->coordinate) }}">
                    </div>
                </div>

                <!-- Location Map -->
                <div class="mb-3 mt-3">
                    <label for="search" class="form-label">ابحث عن الموقع:</label>
                    <input type="text" id="search" class="form-control" placeholder="اكتب اسم الشارع أو المنطقة" value="{{ old('address', $branch->address) }}">
                </div>
                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $branch->latitude) }}">
                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $branch->longitude) }}">
                <input type="hidden" id="address" name="address" value="{{ old('address', $branch->address) }}">
                <div class="mt-4" style="width: 100%; max-width: 100%; height: 400px; overflow: hidden; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
                    <div id="map" style="width: 100%; height: 100%;"></div>
                </div>

                <!-- Daily Schedules -->
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="card-title">مواعيد العمل لكل يوم</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-primary" id="copy-schedule-btn">
                                نسخ المواعيد من يوم لآخر
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                        @php
                            $daySchedule = $branch->dailySchedules->where('day', $day)->first();
                            $oldShifts = old("daily_schedules.$day.shifts", []);
                        @endphp
                        <div class="row mb-4 day-schedule" id="day-{{ $day }}">
                            <div class="col-md-12">
                                <h4>{{ trans('dashboard/days.'.$day) }}</h4>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input holiday-switch" type="checkbox"
                                           name="daily_schedules[{{ $day }}][is_holiday]"
                                           id="holiday-{{ $day }}"
                                           @if(old("daily_schedules.$day.is_holiday", $daySchedule->is_holiday ?? false)) checked @endif>
                                    <label class="form-check-label" for="holiday-{{ $day }}">إجازة</label>
                                </div>
                            </div>

                            <div class="col-md-10 shifts-container" id="shifts-container-{{ $day }}">
                                @if(count($oldShifts) > 0)
                                    @foreach($oldShifts as $index => $shift)
                                    <div class="row shift-row mb-3 border p-2">
                                        <div class="col-md-2">
                                            <label>اسم الشفت:</label>
                                            <input type="text" name="daily_schedules[{{ $day }}][shifts][{{ $index }}][name]"
                                                   class="form-control" value="{{ $shift['name'] ?? '' }}" placeholder="اختياري">
                                        </div>
                                        <div class="col-md-2">
                                            <label>بداية التوصيل:</label>
                                            <input type="time" name="daily_schedules[{{ $day }}][shifts][{{ $index }}][delivery_start_time]"
                                                   class="form-control" value="{{ $shift['delivery_start_time'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>نهاية التوصيل:</label>
                                            <input type="time" name="daily_schedules[{{ $day }}][shifts][{{ $index }}][delivery_end_time]"
                                                   class="form-control" value="{{ $shift['delivery_end_time'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>بداية الاستلام:</label>
                                            <input type="time" name="daily_schedules[{{ $day }}][shifts][{{ $index }}][pickup_start_time]"
                                                   class="form-control" value="{{ $shift['pickup_start_time'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>نهاية الاستلام:</label>
                                            <input type="time" name="daily_schedules[{{ $day }}][shifts][{{ $index }}][pickup_end_time]"
                                                   class="form-control" value="{{ $shift['pickup_end_time'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-shift-btn">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @elseif($daySchedule && !$daySchedule->is_holiday)
                                    @foreach($daySchedule->shifts as $index => $shift)
                                    <div class="row shift-row mb-3 border p-2">
                                        <div class="col-md-2">
                                            <label>اسم الشفت:</label>
                                            <input type="text" name="daily_schedules[{{ $day }}][shifts][{{ $index }}][name]"
                                                   class="form-control" value="{{ $shift->name }}" placeholder="اختياري">
                                        </div>
                                        <div class="col-md-2">
                                            <label>بداية التوصيل:</label>
                                            <input type="time" name="daily_schedules[{{ $day }}][shifts][{{ $index }}][delivery_start_time]"
                                                   class="form-control" value="{{ \Carbon\Carbon::parse($shift->delivery_start_time)->format('H:i') }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>نهاية التوصيل:</label>
                                            <input type="time" name="daily_schedules[{{ $day }}][shifts][{{ $index }}][delivery_end_time]"
                                                   class="form-control" value="{{ \Carbon\Carbon::parse($shift->delivery_end_time)->format('H:i') }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>بداية الاستلام:</label>
                                            <input type="time" name="daily_schedules[{{ $day }}][shifts][{{ $index }}][pickup_start_time]"
                                                   class="form-control" value="{{ \Carbon\Carbon::parse($shift->pickup_start_time)->format('H:i') }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>نهاية الاستلام:</label>
                                            <input type="time" name="daily_schedules[{{ $day }}][shifts][{{ $index }}][pickup_end_time]"
                                                   class="form-control" value="{{ \Carbon\Carbon::parse($shift->pickup_end_time)->format('H:i') }}" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-shift-btn">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="col-md-12">
                                <button type="button" class="btn btn-sm btn-success add-shift-btn" data-day="{{ $day }}">
                                    <i class="fas fa-plus"></i> إضافة شفت
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Exceptional Holidays -->
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="card-title">الإجازات الاستثنائية</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-success" id="add-holiday-btn">
                                إضافة إجازة
                            </button>
                        </div>
                    </div>
                    <div class="card-body" id="holidays-container">
                        @if(old('exceptional_holidays'))
                            @foreach(old('exceptional_holidays') as $index => $holiday)
                            <div class="row mb-4 holiday-item" id="holiday-{{ $index }}">
                                <div class="col-md-3">
                                    <label>عنوان الإجازة:</label>
                                    <input type="text" name="exceptional_holidays[{{ $index }}][title]"
                                           class="form-control" value="{{ $holiday['title'] }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label>تاريخ البدء:</label>
                                    <input type="text" name="exceptional_holidays[{{ $index }}][start_date]"
                                           class="form-control datepicker" value="{{ $holiday['start_date'] }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label>تاريخ الانتهاء (اختياري):</label>
                                    <input type="text" name="exceptional_holidays[{{ $index }}][end_date]"
                                           class="form-control datepicker" value="{{ $holiday['end_date'] ?? '' }}">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check mt-6">
                                        <input class="form-check-input" type="checkbox"
                                               name="exceptional_holidays[{{ $index }}][is_recurring]"
                                               id="recurring-{{ $index }}"
                                               @if(isset($holiday['is_recurring']) && $holiday['is_recurring']) checked @endif>
                                        <label class="form-check-label" for="recurring-{{ $index }}">يتكرر سنوياً</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>الوصف:</label>
                                    <textarea name="exceptional_holidays[{{ $index }}][description]"
                                              class="form-control" rows="1">{{ $holiday['description'] ?? '' }}</textarea>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-holiday-btn" data-target="holiday-{{ $index }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @else
                            @foreach($branch->exceptionalHolidays as $index => $holiday)
                            <div class="row mb-4 holiday-item" id="holiday-{{ $index }}">
                                <div class="col-md-3">
                                    <label>عنوان الإجازة:</label>
                                    <input type="text" name="exceptional_holidays[{{ $index }}][title]"
                                           class="form-control" value="{{ $holiday->title }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label>تاريخ البدء:</label>
                                    <input type="text" name="exceptional_holidays[{{ $index }}][start_date]"
                                           class="form-control datepicker" value="{{ $holiday->start_date }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label>تاريخ الانتهاء (اختياري):</label>
                                    <input type="text" name="exceptional_holidays[{{ $index }}][end_date]"
                                           class="form-control datepicker" value="{{ $holiday->end_date }}">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check mt-6">
                                        <input class="form-check-input" type="checkbox"
                                               name="exceptional_holidays[{{ $index }}][is_recurring]"
                                               id="recurring-{{ $index }}"
                                               @if($holiday->is_recurring) checked @endif>
                                        <label class="form-check-label" for="recurring-{{ $index }}">يتكرر سنوياً</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>الوصف:</label>
                                    <textarea name="exceptional_holidays[{{ $index }}][description]"
                                              class="form-control" rows="1">{{ $holiday->description }}</textarea>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-holiday-btn" data-target="holiday-{{ $index }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Special Occasions -->
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="card-title">المناسبات الخاصة</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-info" id="add-occasion-btn">
                                إضافة مناسبة
                            </button>
                        </div>
                    </div>
                    <div class="card-body" id="occasions-container">
                        @if(old('special_occasions'))
                            @foreach(old('special_occasions') as $index => $occasion)
                            <div class="row mb-4 occasion-item" id="occasion-{{ $index }}">
                                <div class="col-md-2">
                                    <label>اسم المناسبة:</label>
                                    <input type="text" name="special_occasions[{{ $index }}][occasion_name]"
                                           class="form-control" value="{{ $occasion['occasion_name'] }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label>تاريخ المناسبة:</label>
                                    <input type="text" name="special_occasions[{{ $index }}][date]"
                                           class="form-control datepicker" value="{{ $occasion['date'] }}" required>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-check mt-6">
                                        <input class="form-check-input holiday-switch-occasion" type="checkbox"
                                               name="special_occasions[{{ $index }}][is_holiday]"
                                               id="holiday-occasion-{{ $index }}"
                                               @if(isset($occasion['is_holiday']) && $occasion['is_holiday']) checked @endif>
                                        <label class="form-check-label" for="holiday-occasion-{{ $index }}">إجازة</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label>وقت الفتح:</label>
                                    <input type="time" class="form-control occasion-time"
                                           name="special_occasions[{{ $index }}][opening_time]"
                                           value="{{ $occasion['opening_time'] ?? '' }}"
                                           @if(isset($occasion['is_holiday']) && $occasion['is_holiday']) disabled @endif>
                                </div>
                                <div class="col-md-1">
                                    <label>وقت الإغلاق:</label>
                                    <input type="time" class="form-control occasion-time"
                                           name="special_occasions[{{ $index }}][closing_time]"
                                           value="{{ $occasion['closing_time'] ?? '' }}"
                                           @if(isset($occasion['is_holiday']) && $occasion['is_holiday']) disabled @endif>
                                </div>
                                <div class="col-md-1">
                                    <label>بداية التوصيل:</label>
                                    <input type="time" class="form-control occasion-time"
                                           name="special_occasions[{{ $index }}][delivery_start_time]"
                                           value="{{ $occasion['delivery_start_time'] ?? '' }}"
                                           @if(isset($occasion['is_holiday']) && $occasion['is_holiday']) disabled @endif>
                                </div>
                                <div class="col-md-1">
                                    <label>نهاية التوصيل:</label>
                                    <input type="time" class="form-control occasion-time"
                                           name="special_occasions[{{ $index }}][delivery_end_time]"
                                           value="{{ $occasion['delivery_end_time'] ?? '' }}"
                                           @if(isset($occasion['is_holiday']) && $occasion['is_holiday']) disabled @endif>
                                </div>
                                <div class="col-md-2">
                                    <label>الوصف:</label>
                                    <textarea name="special_occasions[{{ $index }}][description]"
                                              class="form-control" rows="1">{{ $occasion['description'] ?? '' }}</textarea>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-occasion-btn" data-target="occasion-{{ $index }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @else
                            @foreach($branch->specialOccasions as $index => $occasion)
                            <div class="row mb-4 occasion-item" id="occasion-{{ $index }}">
                                <div class="col-md-2">
                                    <label>اسم المناسبة:</label>
                                    <input type="text" name="special_occasions[{{ $index }}][occasion_name]"
                                           class="form-control" value="{{ $occasion->occasion_name }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label>تاريخ المناسبة:</label>
                                    <input type="text" name="special_occasions[{{ $index }}][date]"
                                           class="form-control datepicker" value="{{ $occasion->date }}" required>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-check mt-6">
                                        <input class="form-check-input holiday-switch-occasion" type="checkbox"
                                               name="special_occasions[{{ $index }}][is_holiday]"
                                               id="holiday-occasion-{{ $index }}"
                                               @if($occasion->is_holiday) checked @endif>
                                        <label class="form-check-label" for="holiday-occasion-{{ $index }}">إجازة</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label>وقت الفتح:</label>
                                    <input type="time" class="form-control occasion-time"
                                           name="special_occasions[{{ $index }}][opening_time]"
                                           value="{{ $occasion->opening_time ? \Carbon\Carbon::parse($occasion->opening_time)->format('H:i') : '' }}"
                                           @if($occasion->is_holiday) disabled @endif>
                                </div>
                                <div class="col-md-1">
                                    <label>وقت الإغلاق:</label>
                                    <input type="time" class="form-control occasion-time"
                                           name="special_occasions[{{ $index }}][closing_time]"
                                           value="{{ $occasion->closing_time ? \Carbon\Carbon::parse($occasion->closing_time)->format('H:i') : '' }}"
                                           @if($occasion->is_holiday) disabled @endif>
                                </div>
                                <div class="col-md-1">
                                    <label>بداية التوصيل:</label>
                                    <input type="time" class="form-control occasion-time"
                                           name="special_occasions[{{ $index }}][delivery_start_time]"
                                           value="{{ $occasion->delivery_start_time ? \Carbon\Carbon::parse($occasion->delivery_start_time)->format('H:i') : '' }}"
                                           @if($occasion->is_holiday) disabled @endif>
                                </div>
                                <div class="col-md-1">
                                    <label>نهاية التوصيل:</label>
                                    <input type="time" class="form-control occasion-time"
                                           name="special_occasions[{{ $index }}][delivery_end_time]"
                                           value="{{ $occasion->delivery_end_time ? \Carbon\Carbon::parse($occasion->delivery_end_time)->format('H:i') : '' }}"
                                           @if($occasion->is_holiday) disabled @endif>
                                </div>
                                <div class="col-md-2">
                                    <label>الوصف:</label>
                                    <textarea name="special_occasions[{{ $index }}][description]"
                                              class="form-control" rows="1">{{ $occasion->description }}</textarea>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-occasion-btn" data-target="occasion-{{ $index }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <button type="submit" class="mt-5 btn btn-success w-100">تحديث الفرع</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ar.js"></script>
<script>
$(document).ready(function() {
    // Initialize holiday switches
    $('.holiday-switch').change(function() {
        const dayDiv = $(this).closest('.day-schedule');
        const shiftsContainer = dayDiv.find('.shifts-container');
        const addButton = dayDiv.find('.add-shift-btn');

        if($(this).is(':checked')) {
            shiftsContainer.hide();
            addButton.hide();
            shiftsContainer.find('input').prop('disabled', true);
        } else {
            shiftsContainer.show();
            addButton.show();
            shiftsContainer.find('input').prop('disabled', false);

            // Add a shift automatically if there are no shifts
            if (shiftsContainer.find('.shift-row').length === 0) {
                addButton.trigger('click');
            }
        }
    }).trigger('change');

    // Add shift
    $(document).on('click', '.add-shift-btn', function() {
        const day = $(this).data('day');
        const container = $(`#shifts-container-${day}`);
        const index = container.find('.shift-row').length;

        const shiftHtml = `
        <div class="row shift-row mb-3 border p-2">
            <div class="col-md-2">
                <label>اسم الشفت:</label>
                <input type="text" name="daily_schedules[${day}][shifts][${index}][name]"
                       class="form-control" placeholder="اختياري">
            </div>
            <div class="col-md-2">
                <label>بداية التوصيل:</label>
                <input type="time" name="daily_schedules[${day}][shifts][${index}][delivery_start_time]"
                       class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>نهاية التوصيل:</label>
                <input type="time" name="daily_schedules[${day}][shifts][${index}][delivery_end_time]"
                       class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>بداية الاستلام:</label>
                <input type="time" name="daily_schedules[${day}][shifts][${index}][pickup_start_time]"
                       class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>نهاية الاستلام:</label>
                <input type="time" name="daily_schedules[${day}][shifts][${index}][pickup_end_time]"
                       class="form-control" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-shift-btn">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>`;

        container.append(shiftHtml);
    });

    // Remove shift
    $(document).on('click', '.remove-shift-btn', function() {
        $(this).closest('.shift-row').remove();
        reindexShifts();
    });

    // Reindex shifts
    function reindexShifts() {
        $('.shifts-container').each(function() {
            const day = $(this).attr('id').replace('shifts-container-', '');
            $(this).find('.shift-row').each(function(index) {
                $(this).find('input').each(function() {
                    const name = $(this).attr('name')
                        .replace(/\[\d+\]\[shifts\]\[\d+\]/, `[${day}][shifts][${index}]`);
                    $(this).attr('name', name);
                });
            });
        });
    }

    // Copy schedule functionality
    $('#copy-schedule-btn').click(function() {
        Swal.fire({
            title: 'نسخ المواعيد',
            html: `
                <div class="mb-3">
                    <label class="form-label">من يوم:</label>
                    <select id="copy-from-day" class="form-select">
                        @foreach(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                        <option value="{{ $day }}">{{ trans('dashboard/days.'.$day) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">إلى أيام:</label>
                    <select id="copy-to-days" class="form-select" multiple>
                        @foreach(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                        <option value="{{ $day }}">{{ trans('dashboard/days.'.$day) }}</option>
                        @endforeach
                    </select>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'نسخ',
            cancelButtonText: 'إلغاء',
            preConfirm: () => {
                const fromDay = $('#copy-from-day').val();
                const toDays = $('#copy-to-days').val();

                if (!toDays || toDays.length === 0) {
                    Swal.showValidationMessage('يجب اختيار يوم واحد على الأقل');
                    return false;
                }

                return { fromDay, toDays };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { fromDay, toDays } = result.value;
                const sourceDiv = $(`#day-${fromDay}`);
                const isHoliday = sourceDiv.find('.holiday-switch').is(':checked');
                const shiftsHtml = sourceDiv.find('.shifts-container').html();

                toDays.forEach(day => {
                    const targetDiv = $(`#day-${day}`);
                    targetDiv.find('.holiday-switch').prop('checked', isHoliday).trigger('change');

                    if (!isHoliday) {
                        const container = targetDiv.find('.shifts-container');
                        container.html(shiftsHtml);

                        // Reindex shifts
                        container.find('.shift-row').each(function(index) {
                            $(this).find('input').each(function() {
                                const name = $(this).attr('name')
                                    .replace(new RegExp(`\\[${fromDay}\\]\\[shifts\\]\\[\\d+\\]`), `[${day}][shifts][${index}]`);
                                $(this).attr('name', name);
                            });
                        });
                    }
                });

                Swal.fire('تم النسخ', 'تم نسخ المواعيد بنجاح', 'success');
            }
        });
    });

    // Add holiday functionality
    let holidayCounter = {{ count(old('exceptional_holidays', $branch->exceptionalHolidays)) }};
    $('#add-holiday-btn').click(function() {
        const holidayId = `holiday-${holidayCounter++}`;
        const holidayHtml = `
            <div class="row mb-4 holiday-item" id="${holidayId}">
                <div class="col-md-3">
                    <label>عنوان الإجازة:</label>
                    <input type="text" name="exceptional_holidays[${holidayCounter}][title]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label>تاريخ البدء:</label>
                    <input type="text" name="exceptional_holidays[${holidayCounter}][start_date]" class="form-control datepicker" required>
                </div>
                <div class="col-md-2">
                    <label>تاريخ الانتهاء (اختياري):</label>
                    <input type="text" name="exceptional_holidays[${holidayCounter}][end_date]" class="form-control datepicker">
                </div>
                <div class="col-md-2">
                    <div class="form-check mt-6">
                        <input class="form-check-input" type="checkbox" name="exceptional_holidays[${holidayCounter}][is_recurring]" id="recurring-${holidayCounter}">
                        <label class="form-check-label" for="recurring-${holidayCounter}">يتكرر سنوياً</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <label>الوصف:</label>
                    <textarea name="exceptional_holidays[${holidayCounter}][description]" class="form-control" rows="1"></textarea>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-holiday-btn" data-target="${holidayId}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#holidays-container').append(holidayHtml);
        $(`#${holidayId} .datepicker`).flatpickr({
            locale: "ar",
            dateFormat: "Y-m-d",
        });
    });

    // Remove holiday
    $(document).on('click', '.remove-holiday-btn', function() {
        const target = $(this).data('target');
        $(`#${target}`).remove();
    });

    // Add occasion functionality
    let occasionCounter = {{ count(old('special_occasions', $branch->specialOccasions)) }};
    $('#add-occasion-btn').click(function() {
        const occasionId = `occasion-${occasionCounter++}`;
        const occasionHtml = `
            <div class="row mb-4 occasion-item" id="${occasionId}">
                <div class="col-md-2">
                    <label>اسم المناسبة:</label>
                    <input type="text" name="special_occasions[${occasionCounter}][occasion_name]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label>تاريخ المناسبة:</label>
                    <input type="text" name="special_occasions[${occasionCounter}][date]" class="form-control datepicker" required>
                </div>
                <div class="col-md-1">
                    <div class="form-check mt-6">
                        <input class="form-check-input holiday-switch-occasion" type="checkbox"
                               name="special_occasions[${occasionCounter}][is_holiday]"
                               id="holiday-occasion-${occasionCounter}">
                        <label class="form-check-label" for="holiday-occasion-${occasionCounter}">إجازة</label>
                    </div>
                </div>
                <div class="col-md-1">
                    <label>وقت الفتح:</label>
                    <input type="time" class="form-control occasion-time"
                           name="special_occasions[${occasionCounter}][opening_time]">
                </div>
                <div class="col-md-1">
                    <label>وقت الإغلاق:</label>
                    <input type="time" class="form-control occasion-time"
                           name="special_occasions[${occasionCounter}][closing_time]">
                </div>
                <div class="col-md-1">
                    <label>بداية التوصيل:</label>
                    <input type="time" class="form-control occasion-time"
                           name="special_occasions[${occasionCounter}][delivery_start_time]">
                </div>
                <div class="col-md-1">
                    <label>نهاية التوصيل:</label>
                    <input type="time" class="form-control occasion-time"
                           name="special_occasions[${occasionCounter}][delivery_end_time]">
                </div>
                <div class="col-md-2">
                    <label>الوصف:</label>
                    <textarea name="special_occasions[${occasionCounter}][description]" class="form-control" rows="1"></textarea>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-occasion-btn" data-target="${occasionId}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#occasions-container').append(occasionHtml);
        $(`#${occasionId} .datepicker`).flatpickr({
            locale: "ar",
            dateFormat: "Y-m-d",
        });

        // Initialize occasion holiday switch
        $(`#holiday-occasion-${occasionCounter}`).change(function() {
            const occasionDiv = $(this).closest('.occasion-item');
            const inputs = occasionDiv.find('.occasion-time');

            if($(this).is(':checked')) {
                inputs.prop('disabled', true).val('');
            } else {
                inputs.prop('disabled', false);
            }
        });
    });

    // Remove occasion
    $(document).on('click', '.remove-occasion-btn', function() {
        const target = $(this).data('target');
        $(`#${target}`).remove();
    });

    // Initialize datepickers
    $('.datepicker').flatpickr({
        locale: "ar",
        dateFormat: "Y-m-d",
    });

    // Initialize existing occasion holiday switches
    $('.holiday-switch-occasion').change(function() {
        const occasionDiv = $(this).closest('.occasion-item');
        const inputs = occasionDiv.find('.occasion-time');

        if($(this).is(':checked')) {
            inputs.prop('disabled', true).val('');
        } else {
            inputs.prop('disabled', false);
        }
    }).trigger('change');
});
</script>

<!-- Google Maps Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDu3WcDXdf8oGHg8GGwqrn_1iMJc9C6lAk&libraries=places&language=ar&callback=initMap"
  async
  defer
  loading="async">
</script>
<script>
    let map, marker, geocoder, autocomplete;
    function initMap() {
        // Set initial position from branch data
        const initialLat = {{ $branch->latitude ?? '30.0444' }};
        const initialLng = {{ $branch->longitude ?? '31.2357' }};
        const defaultPosition = { lat: initialLat, lng: initialLng };

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultPosition,
            zoom: 13,
        });
        geocoder = new google.maps.Geocoder();
        marker = new google.maps.Marker({
            position: defaultPosition,
            map: map,
            draggable: true,
            icon: {
                url: "https://cdn-icons-png.flaticon.com/512/2776/2776067.png",
                scaledSize: new google.maps.Size(38, 38),
            }
        });

        // Update input fields on marker drag
        marker.addListener("dragend", function () {
            const position = marker.getPosition();
            updateLocation(position.lat(), position.lng());
        });

        // Click to move marker
        map.addListener("click", function (e) {
            marker.setPosition(e.latLng);
            updateLocation(e.latLng.lat(), e.latLng.lng());
        });

        // Search box autocomplete
        const searchInput = document.getElementById("search");
        autocomplete = new google.maps.places.Autocomplete(searchInput);
        autocomplete.bindTo("bounds", map);
        autocomplete.addListener("place_changed", function () {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) {
                alert("لم يتم العثور على الموقع");
                return;
            }
            map.setCenter(place.geometry.location);
            map.setZoom(15);
            marker.setPosition(place.geometry.location);
            updateLocation(place.geometry.location.lat(), place.geometry.location.lng());
        });

        // Set address if exists
        @if($branch->address)
            document.getElementById("search").value = "{{ $branch->address }}";
        @endif
    }

    function updateLocation(lat, lng) {
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
        const latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK") {
                if (results[0]) {
                    document.getElementById("search").value = results[0].formatted_address;
                    document.getElementById("address").value = results[0].formatted_address;
                } else {
                    document.getElementById("search").value = "لم يتم العثور على عنوان";
                    document.getElementById("address").value = "";
                }
            } else {
                console.error("Geocoder failed due to: " + status);
            }
        });
    }

    // Initialize map
    window.initMap = initMap;
</script>
@endpush
