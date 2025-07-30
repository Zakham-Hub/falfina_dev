@extends('dashboard.layouts.master')

@section('pageTitle')
    الاعدادات العامه
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">الاعدادات العامه</span>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover">
                        <a href="{{ route('admin.mainSettings.histories') }}" target="_blank" class="btn btn-sm btn-light btn-active-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            History
                        </a>
                    </div>
                </h3>
            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="py-3 card-body">
                <!-- Start Content -->
                <form id="mainSettings" action="{{ route('admin.mainSettings.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Start General Settings -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="input-group-text text-dark">الاسم</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $setting?->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="input-group-text text-dark">رقم الهاتف</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone', $setting?->phone) }}">
                        </div>
                    </div>
                    <div class="mt-2 form-group row">
                        <div class="col-md-12">
                            <label class="input-group-text text-dark">البريد الالكترونى</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $setting?->email) }}">
                        </div>

                    </div>
                    <div class="mt-2 form-group row">
                        <div class="col-md-4">
                            <label class="input-group-text text-dark">نطاق التوصيل</label>
                            <input type="text" class="form-control" id="delivery_range" name="delivery_range"
                                value="{{ old('delivery_range', $setting?->delivery_range) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="input-group-text text-dark">قيمه التوصيل الأساسية</label>
                            <input type="text" class="form-control" id="delivery_fees" name="delivery_fees"
                                value="{{ old('delivery_fees', $setting?->delivery_fees) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="input-group-text text-dark">سعر التوصيل لكل كيلو</label>
                            <input type="text" class="form-control" id="delivery_fee_per_km" name="delivery_fee_per_km"
                                value="{{ old('delivery_fee_per_km', $setting?->delivery_fee_per_km) }}">
                            <small class="text-danger">مثال: 2 ريال لكل كيلو</small>
                        </div>
                    </div>
                    <div class="mt-2 form-group row">
                        <div class="col-md-6">
                            <label class="input-group-text text-dark">العنوان</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $setting?->address) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="input-group-text text-dark">الوصف</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $setting?->description) }}</textarea>
                        </div>
                    </div>
                    <div class="mt-2 form-group row">
                        <div class="col-md-6">
                            <label class="input-group-text text-dark">العمله</label>
                            <input type="text" class="form-control" id="currency" name="currency"
                                value="{{ old('currency', $setting?->currency) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="input-group-text text-dark">الاصدار</label>
                            <input class="form-control" id="version" name="version" value="{{old('version',$setting?->version)}}">
                            {{-- <small class="text-danger">كل عمله = 10 نقطه</small> --}}
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="loyalty_points_range" class="mb-2 form-label text-dark d-block">
                                    نقاط الولاء
                                </label>
                                <div class="gap-3 d-flex align-items-center">
                                    <!-- Range Slider -->
                                    <input type="range" class="form-range flex-grow-1" id="loyalty_points_range"
                                        min="0" max="1000" step="10"
                                        value="{{ old('loyalty_points', $setting?->loyalty_points ?? 0) }}"
                                        oninput="updateLoyaltyPointsDisplay(this.value)">
                                    <span id="loyalty_points_display" class="p-2 badge rounded-pill bg-primary fs-6">
                                        {{ old('loyalty_points', $setting?->loyalty_points ?? 0) }}
                                    </span>
                                </div>
                                <div class="mt-1 d-flex justify-content-between">
                                    <small class="mt-1 text-danger d-block">كل عمله = {{ $setting?->loyalty_points ?? 0 }}
                                        نقطه</small>
                                </div>
                                <input type="hidden" id="loyalty_points" name="loyalty_points"
                                    value="{{ old('loyalty_points', $setting?->loyalty_points ?? 0) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Start Logo & Favicon & Banner -->
                    <div class="container p-4 mt-2 bg-white rounded shadow">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-3 mb-3 text-center border rounded">
                                    <label for="logo" class="form-label fw-bold">الشعار (Logo)</label>
                                    <input class="form-control" type="file" name="logo" id="logoInput"
                                        accept="image/*">
                                    @if ($setting->getMediaUrl('logo'))
                                        <div class="mt-2">
                                            <img id="logoPreview" src="{{ $setting?->getMediaUrl('logo') }}" alt=""
                                                width="100"
                                                style="cursor: pointer; display: {{ $setting->getMediaUrl('logo') ? 'block' : 'none' }};"
                                                onclick="openImageModal(this.src, 'الشعار (Logo)')">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 mb-3 text-center border rounded">
                                    <label for="favicon" class="form-label fw-bold">الأيقونة (Favicon)</label>
                                    <input class="form-control" type="file" name="favicon" id="faviconInput"
                                        accept="image/*">

                                    <div class="mt-2">
                                        <img id="faviconPreview" src="{{ $setting?->getMediaUrl('favicon') }}"
                                            alt="" width="100"
                                            style="cursor: pointer;display: {{ $setting->getMediaUrl('favicon') ? 'block' : 'none' }};"
                                            onclick="openImageModal(this.src, 'الأيقونة (Favicon)')">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-3 mb-3 text-center border rounded">
                                    <label for="alarm_audio" class="form-label fw-bold">ملف صوتي (Audio)</label>
                                    <input class="form-control" type="file" name="alarm_audio" id="audioInput" accept="audio/*">
                                    @if ($setting->getMediaUrl('alarm_audio'))
                                        <div class="mt-2" id="audioContainer">
                                            <audio id="audioPreview" controls style="width: 100%;">
                                                <source src="{{ $setting?->getMediaUrl('alarm_audio') }}">
                                                المتصفح لا يدعم تشغيل الصوت.
                                            </audio>
                                        </div>
                                    @else
                                        <div class="mt-2" id="audioContainer" style="display: none;"></div>
                                    @endif
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
                                    <div class="text-center modal-body">
                                        <img id="popupImage" src="" class="rounded img-fluid"
                                            style="max-width: 100%; max-height: 80vh;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Name & alert message -->
                    <hr>
                    <div class="form-row">
                        <div class="text-center col-md-12">
                            <button type="submit" class="btn btn-success btn-lg">تحديث</button>
                        </div>
                    </div>
                    <!-- End Submit Form -->
                </form>
                <!-- End Content -->
            </div>
            <!--begin::Body-->
        </div>
    </div>
@endsection

@push('js')
    <script>
        function previewImage(inputId, previewId) {
            let input = document.getElementById(inputId);
            let preview = document.getElementById(previewId);

            input.addEventListener("change", function() {
                let file = input.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
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
        previewImage("logoInput", "logoPreview");
        previewImage("faviconInput", "faviconPreview");

        function updateLoyaltyPointsDisplay(value) {
            document.getElementById('loyalty_points_display').textContent = value;
            document.getElementById('loyalty_points').value = value;
        }

        document.getElementById('audioInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const audioContainer = document.getElementById('audioContainer');
                const audio = document.createElement('audio');
                audio.setAttribute('controls', true);
                audio.style.width = '100%';
                audio.src = URL.createObjectURL(file);

                audioContainer.innerHTML = '';
                audioContainer.appendChild(audio);
                audioContainer.style.display = 'block';
            }
        });
    </script>
@endpush
