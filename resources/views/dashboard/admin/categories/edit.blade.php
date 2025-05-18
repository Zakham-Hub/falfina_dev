@extends('dashboard.layouts.master')

@section('pageTitle')
    {{ $pageTitle }}
@endsection

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{ $pageTitle . ' ' . $category?->name}}</span>
                </h3>
            </div>
            <!--end::Header-->

            <!--begin::Form-->
            <div class="py-3 card-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <label for="name" class="form-label">الاسم:</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name', $category->name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">الحاله:</label>
                            <select name="status" id="status" class="form-select">
                                <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="description" class="form-label">الوصف:</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ old('description', $category->description) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="short_description" class="form-label">الوصف المختصر:</label>
                            <textarea name="short_description" id="short_description" cols="30" rows="10" class="form-control">{{ old('short_description', $category->short_description) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="parent_id">التصنيفات</label>
                            <select id="parent_id" name="parent_id" class="form-control">
                                <option value="">اختر التصنيف</option>
                                @forelse($categories as $cat)
                                    <option value="{{ $cat['id'] }}" {{ $category->parent_id == $cat['id'] ? 'selected' : '' }}>
                                        {{ $cat['name'] }}
                                    </option>
                                @empty
                                    <option value="">لا توجد تصنيفات متاحة</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-3 mb-3 text-center border rounded">
                                <label for="image" class="form-label fw-bold">الصوره</label>
                                <input class="form-control" type="file" name="category" id="categoryInput" accept="image/*">
                                <div class="mt-2">
                                        <img id="categoryPreview" src="{{ $category?->getMediaUrl('category') }}" alt="" width="100" style="cursor: pointer;" onclick="openImageModal(this.src, 'الصوره')">
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
            <!--end::Form-->
        </div>
    </div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
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
previewImage("categoryInput", "categoryPreview");
</script>
@endpush