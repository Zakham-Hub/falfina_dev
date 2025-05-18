@extends('dashboard.layouts.master')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/multiSelect/css/serchSelect.css') }}" />
@endsection

@section('pageTitle')
    {{ $pageTitle }}
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')

    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{ $pageTitle }}</span>
                    <span class="mt-1 text-muted fw-bold fs-7">{{ $pageTitle }} ( )</span>
                </h3>
            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="py-3 card-body">
                <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-4">
                            <label for="name" class="form-label">الاسم:</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $package->name) }}"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="price" class="form-label">السعر:</label>
                            <input type="text" id="price" name="price" value="{{ old('price', $package->price) }}"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="desc" class="form-label">الوصف:</label>
                            <input type="text" id="desc" name="desc" value="{{ old('desc', $package->desc) }}"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <label for="types" class="form-label">اختر من المنتجات:</label>
                            <select id="types" name="product_id[]" class="form-control select2" multiple>
                                @foreach ($products as $type)
                                    <option value="{{ $type->id }}"
                                        @selected(in_array($type->id, $package->products->pluck('id')->toArray()))>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="p-3 text-center border rounded">
                                <label for="image" class="form-label fw-bold">الصورة:</label>
                                <input class="form-control" type="file" name="image" id="imageInput" accept="image/*">
                                <div class="mt-2">
                                    <img id="imagePreview" src="{{ $package?->getMediaUrl('package') ?? '' }}" alt="Preview"
                                         width="100" style="cursor: pointer;"
                                         onclick="openImageModal(this.src, 'الصوره')">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success w-100">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--end::Body-->
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">عرض الصورة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="text-center modal-body">
                    <img id="popupImage" src="" class="rounded img-fluid" style="max-width: 100%; max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2({ width: '100%',dropdownAutoWidth: true });

    $('#size-repeater').repeater({
        initEmpty: false,
        defaultValues: {},
        show: function() { $(this).slideDown(); },
        hide: function(deleteElement) {
            if(confirm('هل تريد حذف هذا الحجم؟')) {
                $(this).slideUp(deleteElement);
            }
        }
    });

    $(document).on('input', '.price-input', function () {
        let price = parseFloat($(this).val());
        let error = $(this).siblings('.price-error');
        if (isNaN(price) || price <= 0) {
            error.removeClass('d-none');
            $(this).addClass('is-invalid');
        } else {
            error.addClass('d-none');
            $(this).removeClass('is-invalid');
        }
    });

    $('#imageInput').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
