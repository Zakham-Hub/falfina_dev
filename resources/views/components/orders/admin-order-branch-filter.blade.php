{{--<form id="filter-form" class="row mb-4">
    <div class="col-md-3">
        <label>من تاريخ</label>
        <input type="date" name="from" id="from" class="form-control">
    </div>
    <div class="col-md-3">
        <label>إلى تاريخ</label>
        <input type="date" name="to" id="to" class="form-control">
    </div>
    <div class="col-md-3">
        <label>الفرع</label>
        <select name="branch_id" id="branch_id" class="form-control">
            <option value="">كل الفروع</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 mt-4">
        <button type="button" id="filter" class="btn btn-primary mt-2">فلترة</button>
        <button type="button" id="reset" class="btn btn-light mt-2">إعادة تعيين</button>
    </div>
</form>--}}

@if(auth('admin')->check())
    <form id="filter-form" class="row mb-4">
        <div class="col-md-3">
            <label>من تاريخ</label>
            <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-3">
            <label>إلى تاريخ</label>
            <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-3">
            <label>الفرع</label>
            <select name="branch_id" id="branch_id" class="form-control">
                <option value="">كل الفروع</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mt-4">
            <button type="submit" class="btn btn-primary mt-2">فلترة</button>
            <a href="{{ url()->current() }}" class="btn btn-light mt-2">إعادة تعيين</a>
        </div>
    </form>
@endif
