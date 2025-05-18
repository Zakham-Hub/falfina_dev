@extends('dashboard.layouts.master')

@section('pageTitle')
    {{ $pageTitle }}
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')

    <div id="kt_content_container" class="container-xxl">
        <div class="card card-xxl-stretch mb-5 mb-xl-8">
            <div class="card-header pt-5 border-0">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">{{ $pageTitle }}</span>
                    <span class="text-muted fw-bold fs-7 mt-1">{{ $pageTitle }} (إضافة)</span>
                </h3>
            </div>

            <div class="card-body py-3">
                <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">الاسم:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="price" class="form-label">السعر:</label>
                            <input type="text" id="price" name="price" class="form-control" required>
                        </div>


                        <div class="col-md-4">
                            <label for="desc" class="form-label">الوصف:</label>
                            <textarea id="desc" name="desc" class="form-control" required></textarea>
                        </div>

                        <div class="col-md-12">
                            <label for="types" class="form-label">اختر من المنتجات:</label>
                            <select id="types" name="product_id[]" class="form-control select2" multiple>
                                @foreach ($products as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <div class="border rounded p-3 text-center mb-3">
                                <label for="image" class="form-label fw-bold">الصوره</label>
                                <input type="file" class="form-control" name="image" id="image"
                                    accept="image/*">
                                <div class="mt-2">
                                    <img id="productPreview" src="" width="100" style="cursor:pointer;"
                                        onclick="openImageModal(this.src, 'الصوره')">
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel">عرض الصورة</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img id="popupImage" src="" class="img-fluid rounded"
                                            style="max-width: 100%; max-height: 80vh;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-success w-100">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                dropdownAutoWidth: true
            });
        });
        </script>
@endpush
