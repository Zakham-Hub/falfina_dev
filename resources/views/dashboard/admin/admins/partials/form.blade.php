<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="row">
        <!-- Name Field -->
        <div class="mb-3 col-md-6">
            <label for="name" class="form-label">{{ trans('dashboard/admin.name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $admin->name ?? '') }}" required>
        </div>

        <!-- Email Field -->
        <div class="mb-3 col-md-6">
            <label for="email" class="form-label">{{ trans('dashboard/admin.email') }}</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $admin->email ?? '') }}" required>
        </div>

        <!-- Password Field -->
        <div class="mb-3 col-md-6">
            <label for="password" class="form-label">{{ trans('dashboard/admin.password') }}</label>
            <input type="password" name="password" id="password" class="form-control" {{ $method === 'POST' ? 'required' : '' }}>
            @if ($method === 'PUT')
                <small class="text-muted">{{ trans('dashboard/admin.leave_blank_password') }}</small>
            @endif
        </div>

        <!-- Password Confirmation Field -->
        <div class="mb-3 col-md-6">
            <label for="password_confirmation" class="form-label">{{ trans('dashboard/admin.password_confirmation') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <!-- Phone Field -->
        <div class="mb-3 col-md-6">
            <label for="phone" class="form-label">{{ trans('dashboard/admin.phone') }}</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $admin->phone ?? '') }}">
        </div>

        <!-- Status Field -->
        <div class="mb-3 col-md-6">
            <label for="status" class="form-label">{{ trans('dashboard/general.status') }}</label>
            <select name="status" id="status" class="form-select" required>
                <option value="active" {{ old('status', $admin->status ?? '') === 'active' ? 'selected' : '' }}>{{ trans('dashboard/general.active') }}</option>
                <option value="inactive" {{ old('status', $admin->status ?? '') === 'inactive' ? 'selected' : '' }}>{{ trans('dashboard/general.inactive') }}</option>
            </select>
        </div>

        <!-- Type Field -->
        <div class="mb-3 col-md-12">
            <label for="type" class="form-label">{{ trans('dashboard/admin.type') }}</label>
            <select name="type" id="type" class="form-select" required>
                <option value="admin" {{ old('type', $admin->type ?? '') === 'admin' ? 'selected' : '' }}>مدير</option>
                <option value="supervisor" {{ old('type', $admin->type ?? '') === 'supervisor' ? 'selected' : '' }}>{{ trans('dashboard/admin.supervisor') }}</option>
            </select>
        </div>
    </div>

    <!--Start Status & Link Protection Group-->
    <div class="mb-5 row">
        <!-- Start Link Protection Switch -->
        <div class="col-md-12 fv-row form-check form-switch form-check-custom form-check-solid">
            <label class="mb-2 form-check-label fs-5 fw-bold" for="link_protection">
                حالة حماية الروابط
            </label>
            <input class="form-check-input link_protection" name="link_password_status" type="checkbox" value="1" />
            <span class="form-control-feedback text-danger" id="link_protectionError" data-field="link_protection"></span>
        </div>
        <!-- End Link Protection Switch -->
    </div>
    <!--End Status & Link Protection Group-->

    <!-- Start Link Protection Password-->
    <div class="mb-5 row">
        <!--Start Name Filed -->
        <div class="col-md-6 fv-row"></div>
        <!--End Name Filed-->
        <!--Start Password Protcetion Filed-->
        <div class="col-md-6 fv-row" id="password_protection_field" style="display:none;">
            <label class="mb-2 required fs-5 fw-bold">كلمة مرور حماية الروابط</label>
            <input type="password" class="form-control form-control-solid link_password_protection" placeholder="دخل كلمة مرور حماية الروابط" name="link_password_protection" />
            <span class="form-control-feedback text-danger" id="link_password_protectionError" data-field="link_password_protection"></span>
        </div>
        <!--End Password Protcetion Filed-->
    </div>
    <!-- End Link Protection Password-->

    <!-- Submit Button -->
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            {{ trans('dashboard/general.save') }}
        </button>
    </div>
</form>
