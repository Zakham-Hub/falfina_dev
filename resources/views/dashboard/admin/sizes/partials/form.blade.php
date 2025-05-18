<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="row">
        <!-- Name Field -->
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">{{ trans('dashboard/admin.size.name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $size->name ?? '') }}" required>
        </div>

        <!-- Gram Field -->
        <div class="col-md-6 mb-3">
            <label for="gram" class="form-label">{{ trans('dashboard/admin.size.gram') }}</label>
            <input type="number" name="gram" id="gram" class="form-control" value="{{ old('gram', $size->gram ?? '') }}">
        </div>
    </div>

    <!-- Submit Button -->
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            {{ trans('dashboard/general.save') }}
        </button>
    </div>
</form>