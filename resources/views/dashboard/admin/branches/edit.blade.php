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
        <div class="pt-5 border-0 card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="mb-1 card-label fw-bolder fs-3">{{$pageTitle}}</span>
                <span class="mt-1 text-muted fw-bold fs-7">({{ $branch->name }})</span>
            </h3>
        </div>
        <div class="py-3 card-body">
            <form action="{{ route('admin.branches.update', $branch->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">اسم الفرع:</label>
                        <input type="text" id="name" name="name" value="{{ $branch->name }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">هاتف الفرع:</label>
                        <input type="text" id="phone" name="phone" value="{{ $branch->phone }}" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="search" class="form-label">ابحث عن الموقع:</label>
                    <input type="text" id="search" value="{{ $branch->address }}" class="form-control" placeholder="اكتب اسم الشارع أو المنطقة">
                </div>
                <input type="hidden" id="latitude" name="latitude" value="{{ $branch->latitude }}">
                <input type="hidden" id="longitude" name="longitude" value="{{ $branch->longitude }}">
                <input type="hidden" id="address" name="address" value="{{ $branch->address }}">
                <div class="mt-4" style="width: 100%; max-width: 100%; height: 400px; overflow: hidden; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
                    <div id="map" style="width: 100%; height: 100%;"></div>
                </div>
                <button type="submit" class="mt-3 btn btn-success w-100">تحديث الفرع</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDu3WcDXdf8oGHg8GGwqrn_1iMJc9C6lAk&libraries=places&language=ar&callback=initMap"
  async
  defer
  loading="async">
</script>
<script>
    let map, marker, geocoder, autocomplete;

    function initMap() {
        const defaultLat = parseFloat("{{ $branch->latitude ?? 30.0444 }}");
        const defaultLng = parseFloat("{{ $branch->longitude ?? 31.2357 }}");
        const defaultPosition = { lat: defaultLat, lng: defaultLng };

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultPosition,
            zoom: 15,
        });

        geocoder = new google.maps.Geocoder();

        marker = new google.maps.Marker({
            position: defaultPosition,
            map: map,
            draggable: true,
            icon: {
                url: "https://cdn-icons-png.flaticon.com/512/2776/2776067.png",
                scaledSize: new google.maps.Size(38, 38),
            },
        });

        marker.addListener("dragend", function () {
            const position = marker.getPosition();
            updateLocation(position.lat(), position.lng());
        });

        map.addListener("click", function (e) {
            marker.setPosition(e.latLng);
            updateLocation(e.latLng.lat(), e.latLng.lng());
        });

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

        // Fill initial values
        updateLocation(defaultLat, defaultLng);
    }

    function updateLocation(lat, lng) {
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
        const latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };

        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK" && results[0]) {
                document.getElementById("search").value = results[0].formatted_address;
                document.getElementById("address").value = results[0].formatted_address;
            } else {
                document.getElementById("search").value = "لم يتم العثور على عنوان";
                document.getElementById("address").value = "";
            }
        });
    }

    // ربط الدالة بتحميل Google Maps
    window.initMap = initMap;
</script>

@endpush
