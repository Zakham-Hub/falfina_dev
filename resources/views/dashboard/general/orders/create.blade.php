@extends('dashboard.layouts.master')

@section('pageTitle', 'إنشاء طلب جديد')

@section('content')
@include('dashboard.layouts.common._partial.messages')

<div class="container-xxl" id="kt_content_container">
    <div class="mb-5 card card-xxl-stretch">
        <div class="pt-5 border-0 card-header">
            <h3 class="card-title fw-bolder fs-3">{{ $pageTitle }}</h3>
        </div>

        <div class="py-3 card-body">
            <form action="{{ route('general.orders.store') }}" method="POST" id="orderForm">
                @csrf

                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label>الفرع:</label>
                        <select name="branch_id" class="form-select" required>
                            <option value="">اختر الفرع</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>نوع الطلب:</label>
                        <select name="is_delivery" class="form-select" required>
                            <option value="0">استلام من الفرع</option>
                            <option value="1">توصيل</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>العميل:</label>
                        <select name="user_id" class="form-select select2" required>
                            <option value="">اختر العميل</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>عنوان التوصيل (إذا كان توصيل):</label>
                    <input type="text" name="order_location" class="form-control">
                </div>

                <hr>
                <h5>المنتجات</h5>
                <div id="product-list">
                    <!-- Product rows will be added here -->
                </div>

                <button type="button" id="addProduct" class="mb-3 btn btn-primary">إضافة منتج</button>

                <div class="mb-3">
                    <label>السعر الإجمالي:</label>
                    <input type="text" name="total_price" class="form-control" id="totalPrice" value="0" readonly>
                </div>

                <button type="submit" class="btn btn-success">إنشاء الطلب</button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('.select2').select2({
        width: '100%',
        dropdownAutoWidth: true
    });
    let products = @json($products);
    let sizes = @json($sizes);
    let types = @json($types);
    let extras = @json($extras);
    let productIndex = 0;

    function recalculateTotal() {
        let total = 0;
        document.querySelectorAll('.product-row').forEach(row => {
            let price = parseFloat(row.querySelector('.product-price').value) || 0;
            let quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            let subtotal = price * quantity;

            // Size price only if selected
            let sizeSelect = row.querySelector('.size-select');
            if (sizeSelect && sizeSelect.value) {
                let sizePrice = parseFloat(row.querySelector('.size-price').value) || 0;
                subtotal += sizePrice * quantity;
            }

            // Type price (if needed)
            let typePrice = parseFloat(row.querySelector('.type-price').value) || 0;
            subtotal += typePrice * quantity;

            // Extras
            row.querySelectorAll('.extra-row').forEach(extraRow => {
                let extraPrice = parseFloat(extraRow.querySelector('.extra-price').value) || 0;
                let extraQuantity = parseFloat(extraRow.querySelector('.extra-quantity').value) || 0;
                subtotal += extraPrice * extraQuantity;
            });

            total += subtotal;
        });

        document.getElementById('totalPrice').value = total.toFixed(2);
    }

    function updateProductDetails(row) {
        let productId = row.querySelector('.product-select').value;
        let product = products.find(p => p.id == productId);

        // Update product price
        row.querySelector('.product-price').value = product ? product.price : 0;

        // Size
        let sizeSelect = row.querySelector('.size-select');
        let sizeInput = row.querySelector('.size-price');
        sizeSelect.innerHTML = '<option value="">اختر الحجم</option>';
        sizeSelect.required = false;
        if (product && product.sizes && product.sizes.length > 0) {
            sizeSelect.required = true;
            product.sizes.forEach(size => {
                let option = document.createElement('option');
                option.value = size.id;
                option.textContent = size.name + ' (' + size.pivot.price + ' ر.س)';
                option.dataset.price = size.pivot.price;
                sizeSelect.appendChild(option);
            });
        } else {
            sizeInput.value = 0; // Reset if no size
        }

        // Type
        let typeSelect = row.querySelector('.type-select');
        typeSelect.innerHTML = '<option value="">اختر النوع</option>';
        if (product && product.types) {
            product.types.forEach(type => {
                let option = document.createElement('option');
                option.value = type.id;
                option.textContent = type.name;
                typeSelect.appendChild(option);
            });
        }

        // Extras
        let extraSelect = row.querySelector('.extra-select');
        if (extraSelect) {
            extraSelect.innerHTML = '<option value="">اختر إضافة</option>';
            if (product && product.extras) {
                product.extras.forEach(extra => {
                    let option = document.createElement('option');
                    option.value = extra.id;
                    option.textContent = extra.name + ' (' + extra.pivot.price + ' ر.س)';
                    option.dataset.price = extra.pivot.price;
                    extraSelect.appendChild(option);
                });
            }
        }

        recalculateTotal();
    }

    document.getElementById('addProduct').addEventListener('click', function () {
        let row = `
        <div class="mb-3 row product-row">
            <div class="col-md-3">
                <label>المنتج</label>
                <select name="products[${productIndex}][product_id]" class="form-select product-select" required>
                    <option value="">اختر المنتج</option>
                    ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                </select>
                <input type="hidden" name="products[${productIndex}][price]" class="product-price" value="0">
            </div>
            <div class="col-md-2">
                <label>الكمية</label>
                <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity-input" value="1" min="1" required>
            </div>
            <div class="col-md-2">
                <label>الحجم</label>
                <select name="products[${productIndex}][size_id]" class="form-select size-select"></select>
                <input type="hidden" name="products[${productIndex}][size_price]" class="size-price" value="0">
            </div>
            <div class="col-md-2">
                <label>النوع</label>
                <select name="products[${productIndex}][type_id]" class="form-select type-select">
                    <option value="">اختر النوع</option>
                </select>
                <input type="hidden" name="products[${productIndex}][type_price]" class="type-price" value="0">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-product">حذف</button>
            </div>
            <div class="mt-3 col-12">
                <h6>الإضافات</h6>
                <div class="extras-container-${productIndex}"></div>
                <button type="button" class="btn btn-sm btn-secondary add-extra" data-index="${productIndex}">إضافة إضافات</button>
            </div>
        </div>`;

        document.getElementById('product-list').insertAdjacentHTML('beforeend', row);
        updateProductDetails(document.querySelector('.product-row:last-child'));
        productIndex++;
    });

    document.addEventListener('change', function (e) {
        let row = e.target.closest('.product-row');
        if (e.target.classList.contains('product-select')) updateProductDetails(row);
        if (e.target.classList.contains('size-select')) {
            let selected = e.target.selectedOptions[0];
            let priceInput = row.querySelector('.size-price');
            priceInput.value = selected ? (selected.dataset.price || 0) : 0;
            recalculateTotal();
        }
        if (e.target.classList.contains('quantity-input') || e.target.classList.contains('type-price') || e.target.classList.contains('product-price') || e.target.classList.contains('extra-quantity')) {
            recalculateTotal();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-product')) {
            e.target.closest('.product-row').remove();
            recalculateTotal();
        }

        if (e.target.classList.contains('add-extra')) {
            let index = e.target.dataset.index;
            let extraId = `extra-${index}-${Date.now()}`;
            let extraRow = `
            <div class="mb-2 row extra-row">
                <div class="col-md-4">
                    <select name="products[${index}][extras][${extraId}][extra_id]" class="form-select extra-select">
                        <option value="">اختر إضافة</option>
                        ${extras.map(e => `<option value="${e.id}" data-price="${e.price}">${e.name} (${e.price} ر.س)</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="products[${index}][extras][${extraId}][quantity]" class="form-control extra-quantity" value="1" min="1">
                </div>
                <div class="col-md-2">
                    <input type="number" name="products[${index}][extras][${extraId}][price]" class="form-control extra-price" readonly>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger remove-extra">حذف</button>
                </div>
            </div>`;
            document.querySelector(`.extras-container-${index}`).insertAdjacentHTML('beforeend', extraRow);
        }

        if (e.target.classList.contains('remove-extra')) {
            e.target.closest('.extra-row').remove();
            recalculateTotal();
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('extra-select')) {
            let selected = e.target.selectedOptions[0];
            let price = selected ? selected.dataset.price : 0;
            let priceInput = e.target.closest('.extra-row').querySelector('.extra-price');
            priceInput.value = price;
            recalculateTotal();
        }
    });

    document.getElementById('addProduct').click();
</script>
@endpush
