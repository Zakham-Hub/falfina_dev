@extends('dashboard.layouts.master')

@section('pageTitle')
    {{ trans('dashboard/admin.product.edit_product') }}
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="mb-5 card card-xxl-stretch mb-xl-8">
        <div class="pt-5 border-0 card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="mb-1 card-label fw-bolder fs-3">{{ trans('dashboard/admin.product.edit_product') }}</span>
            </h3>
        </div>

        <div class="py-3 card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Product Basic Info --}}
                <div class="row">
                    <div class="col-md-4">
                        <label for="name" class="form-label">الاسم:</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="loyalty_points" class="form-label">نقاط الولاء</label>
                        <input type="text" name="loyalty_points" class="form-control" value="{{ $product->loyalty_points }}">
                    </div>
                    <div class="col-md-4">
                        <label for="price" class="form-label">السعر:</label>
                        <input type="text" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
                    </div>
                </div>

                <br>

                {{-- Categories, Types, Extras --}}
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">التصنيفات:</label>
                        <select name="categories[]" class="form-control select2" multiple required>
                            @foreach($data['categories'] as $category)
                                <option value="{{ $category->id }}" {{ $product->categories->contains($category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الأنواع:</label>
                        <select name="types[]" class="form-control select2" multiple>
                            @foreach($data['types'] as $type)
                                <option value="{{ $type->id }}" {{ $product->types->contains($type->id) ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الاضافات و الصوصات:</label>
                        <select name="extras[]" class="form-control select2" multiple required>
                            @foreach($data['extras'] as $extra)
                                <option value="{{ $extra->id }}" {{ $product->extras->contains($extra->id) ? 'selected' : '' }}>
                                    {{ ' (' . ($extra->type == 'addon' ? 'إضافة' : 'صوص') . ') - ' . $extra->name . ' - ' . $extra->price . ' ' . $settings->currency }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>

                {{-- Descriptions --}}
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">الوصف:</label>
                        <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الوصف المختصر:</label>
                        <textarea name="short_description" class="form-control">{{ $product->short_description }}</textarea>
                    </div>
                </div>

                <br>

                {{-- Sizes Repeater --}}
                <div class="form-group">
                    <label>الأحجام</label>
                    @if($product->sizes->count() > 0)
                    <div id="size-repeater">
                        <div data-repeater-list="sizes">
                                @foreach($product->sizes as $productSize)
                                    <div data-repeater-item class="row mb-3 mt-3 p-2 border rounded">
                                        <div class="col-md-5">
                                            <select name="size_id" class="form-control">
                                                <option value="">اختر الحجم</option>
                                                @foreach($data['sizes'] as $size)
                                                    <option value="{{ $size->id }}" {{ $size->id == $productSize->id ? 'selected' : '' }}>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" name="price" class="form-control price-input" value="{{ $productSize->pivot->price }}" placeholder="السعر">
                                            <small class="text-danger price-error d-none">يجب أن يكون السعر أكبر من 0</small>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger" data-repeater-delete>حذف</button>
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                        <button type="button" class="btn btn-success mt-2" data-repeater-create>إضافة حجم</button>
                    </div>
                    @else
                        <div id="size-repeater">
                            <div data-repeater-list="sizes">
                                <div data-repeater-item class="row">
                                    <div class="col-md-5">
                                        <select name="size_id" class="form-control">
                                            <option value="">اختر الحجم</option>
                                            @foreach($data['sizes'] as $size)
                                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="number" name="price" class="form-control price-input" placeholder="السعر">
                                        <small class="text-danger price-error d-none">يجب أن يكون السعر أكبر من 0</small>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger" data-repeater-delete>حذف</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success mt-2" data-repeater-create>إضافة حجم</button>
                        </div>
                    @endif

                </div>

                <br>

                {{-- Image Upload --}}
                <div class="row">
                    <div class="col-md-12">
                        <label for="product" class="form-label">الصوره</label>
                        <input class="form-control" type="file" name="product" id="productInput" accept="image/*">
                        <div class="mt-2">
                            <img id="productPreview" src="{{ $product?->getMediaUrl('product') }}" width="100">
                        </div>
                    </div>
                </div>

                <hr>

                <button type="submit" class="btn btn-success w-100">حفظ</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2({ width: '100%' });

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

    $('#productInput').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#productPreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
