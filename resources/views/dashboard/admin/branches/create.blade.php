@extends('dashboard.layouts.master')

@section('css')
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
                    <span class="mt-1 text-muted fw-bold fs-7">{{$pageTitle}} ( {{Branch::count();}} )</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="py-3 card-body">
                <form action="{{ route('admin.branches.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label">اسم الفرع:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">هاتف الفرع:</label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="search" class="form-label">ابحث عن الموقع:</label>
                        <input type="text" id="search" class="form-control" placeholder="اكتب اسم الشارع أو المنطقة">
                    </div>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <input type="hidden" id="address" name="address">
                    <div class="mt-4" style="width: 100%; max-width: 100%; height: 600px; overflow: hidden; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
                        <div id="map" style="width: 100%; height: 100%;"></div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">حفظ الفرع</button>
                </form>
            </div>
            <!--begin::Body-->
        </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{{--<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([30.0444, 31.2357], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    var customIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/2776/2776067.png',
        iconSize: [38, 38],
        iconAnchor: [19, 38],
        popupAnchor: [0, -38]
    });

    var marker = L.marker([30.0444, 31.2357], {
        draggable: true,
        icon: customIcon
    }).addTo(map);
    function updateLatLng(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        fetchAddress(lat, lng);
    }

    marker.on('dragend', function(event) {
        var position = marker.getLatLng();
        updateLatLng(position.lat, position.lng);
    });

    map.on('click', function(event) {
        var lat = event.latlng.lat;
        var lng = event.latlng.lng;
        marker.setLatLng([lat, lng]);
        updateLatLng(lat, lng);
    });
    function fetchAddress(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=ar`)
            .then(response => response.json())
            .then(data => {
                if (data.display_name) {
                    document.getElementById('search').value = data.display_name;
                    document.getElementById('address').value = data.display_name;
                } else {
                    document.getElementById('search').value = "لم يتم العثور على عنوان";
                    document.getElementById('address').value = "";
                }
            })
            .catch(error => console.error('خطأ في جلب العنوان:', error));
    }
    document.getElementById('search').addEventListener('change', function() {
        var location = this.value;
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${location}&accept-language=ar`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    var lat = data[0].lat;
                    var lng = data[0].lon;
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 15);
                    updateLatLng(lat, lng);
                } else {
                    alert("لم يتم العثور على الموقع");
                }
            });
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDu3WcDXdf8oGHg8GGwqrn_1iMJc9C6lAk&libraries=places&language=ar"></script>--}}
<script
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDu3WcDXdf8oGHg8GGwqrn_1iMJc9C6lAk&libraries=places&language=ar&callback=initMap"
  async
  defer
  loading="async">
</script>
<script>
    let map, marker, geocoder, autocomplete;
    function initMap() {
        const defaultPosition = { lat: 30.0444, lng: 31.2357 };
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultPosition,
            zoom: 13,
        });
        geocoder = new google.maps.Geocoder();
        marker = new google.maps.Marker({
            position: defaultPosition,
            map: map,
            draggable: true,
            icon: {
                url: "https://cdn-icons-png.flaticon.com/512/2776/2776067.png",
                scaledSize: new google.maps.Size(38, 38),
            }
        });
        // Update input fields on marker drag
        marker.addListener("dragend", function () {
            const position = marker.getPosition();
            updateLocation(position.lat(), position.lng());
        });
        // Click to move marker
        map.addListener("click", function (e) {
            marker.setPosition(e.latLng);
            updateLocation(e.latLng.lat(), e.latLng.lng());
        });
        // Search box autocomplete
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
        // Initial values
        updateLocation(defaultPosition.lat, defaultPosition.lng);
    }
    function updateLocation(lat, lng) {
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
        const latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK") {
                if (results[0]) {
                    document.getElementById("search").value = results[0].formatted_address;
                    document.getElementById("address").value = results[0].formatted_address;
                } else {
                    document.getElementById("search").value = "لم يتم العثور على عنوان";
                    document.getElementById("address").value = "";
                }
            } else {
                console.error("Geocoder failed due to: " + status);
            }
        });
    }
    // Initialize map
    window.initMap = initMap;
</script>


@endpush
