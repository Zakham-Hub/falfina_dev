@extends('dashboard.layouts.master')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('pageTitle')
    {{$pageTitle}}
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{$pageTitle}}</span>
                    <span class="mt-1 text-muted fw-bold fs-7">{{$pageTitle}} ( )</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="py-3 card-body">
                <form action="{{ route('admin.extras.update', $extra->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name" class="form-label">الاسم:</label>
                            <input type="text" id="name" name="name" value="{{$extra->name}}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="phone" class="form-label">النوع:</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="addon" {{ $extra->type == 'addon' ? 'selected' : '' }}>إضافة</option>
                                <option value="sauce" {{ $extra->type == 'sauce' ? 'selected' : '' }}>صوص</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="phone" class="form-label">السعر:</label>
                            <input type="text" step="0.01" id="price" name="price" value="{{$extra->price}}" class="form-control" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-3 mb-3 text-center border rounded">
                                <label for="image" class="form-label fw-bold">الصوره</label>
                                <input class="form-control" type="file" name="extra" id="extraInput" accept="image/*">
                                <div class="mt-2">
                                        <img id="extraPreview" src="{{ $extra?->getMediaUrl('extra') }}" alt="" width="100" style="cursor: pointer;" onclick="openImageModal(this.src, 'الصوره')">
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">عرض الصورة</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="text-center modal-body">
                                    <img id="popupImage" src="" class="rounded img-fluid" style="max-width: 100%; max-height: 80vh;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success w-100">حفظ</button>
                </form>
            </div>
            <!--begin::Body-->
        </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let priceInput = document.getElementById("price");
    let warningMessage = document.createElement("small");
    warningMessage.style.color = "red";
    warningMessage.style.display = "none";
    warningMessage.innerText = "يجب أن يكون السعر رقمًا موجبًا أكبر من 0";
    priceInput.parentNode.appendChild(warningMessage);

    priceInput.addEventListener("input", function () {
        let value = parseFloat(priceInput.value);
        
        if (isNaN(value) || value <= 0) {
            priceInput.classList.add("is-invalid");
            warningMessage.style.display = "block";
        } else {
            priceInput.classList.remove("is-invalid");
            warningMessage.style.display = "none";
        }
    });
});
function previewImage(inputId, previewId) {
    let input = document.getElementById(inputId);
    let preview = document.getElementById(previewId);

    input.addEventListener("change", function () {
        let file = input.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.style.display = "none";
        }
    });
}
function openImageModal(src, title) {
    if (src) {
        let popupImage = document.getElementById("popupImage");
        let modalTitle = document.getElementById("imageModalLabel");
        popupImage.src = src;
        modalTitle.innerText = title;
        let imageModal = new bootstrap.Modal(document.getElementById("imageModal"));
        imageModal.show();
    }
}
previewImage("extraInput", "extraPreview");
</script>
@endpush
