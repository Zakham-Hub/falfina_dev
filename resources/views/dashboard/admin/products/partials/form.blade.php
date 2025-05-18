<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="row">
        <!-- Image Upload Field -->
        <div class="col-md-12 mb-3">
            <label for="image" class="form-label">{{ trans('dashboard/admin.item.image') }}</label>
            <input type="file" name="image" id="image" class="dropify" data-default-file="{{ $product?->getFirstMediaUrl('images') }}">
        </div>

        <!-- Name Field -->
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">{{ trans('dashboard/admin.product.name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
        </div>

        <!-- Description Field -->
        <div class="col-md-6 mb-3">
            <label for="description" class="form-label">{{ trans('dashboard/admin.product.description') }}</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <!-- Category Field -->
        <div class="col-md-4 mb-3">
            <label for="category_id" class="form-label">{{ trans('dashboard/admin.product.category') }}</label>
            <select name="category_id" id="category_id" class="form-control select2" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Type Field -->
        <div class="col-md-4 mb-3">
            <label for="type" class="form-label">{{ trans('dashboard/admin.product.type') }}</label>
            <select name="type" id="type" class="form-control select2" required>
                <option value="new" {{ old('type', $product->type ?? '') == 'new' ? 'selected' : '' }}>New</option>
                <option value="old" {{ old('type', $product->type ?? '') == 'old' ? 'selected' : '' }}>Old</option>
            </select>
        </div>

        <!-- Price Field -->
        <div class="col-md-4 mb-3">
            <label for="price" class="form-label">{{ trans('dashboard/admin.product.price') }}</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
        </div>

        <!-- Item Types (Multi-select) -->
        <div class="col-md-12 mb-3">
            <label for="item_types" class="form-label">{{ trans('dashboard/admin.product.item_types') }}</label>
            <select name="item_types[]" id="item_types" class="form-control select2" multiple>
                @foreach ($itemTypes as $itemType)
                    <option value="{{ $itemType->id }}" {{ in_array($itemType->id, old('item_types', $product?->itemTypes->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                        {{ $itemType->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Items Section -->
        <div class="col-md-12 mb-3">
            <label class="form-label">{{ trans('dashboard/admin.product.items') }}</label>
            <div id="items-container"></div>
        </div>

        <!-- Sizes Section -->
        <div class="col-md-12 mb-3">
            <label class="form-label">{{ trans('dashboard/admin.product.sizes') }}</label>
            <div id="sizes-container">
                @if (isset($product) && $product->sizes->count() > 0)
                    @foreach ($product->sizes as $size)
                        <div class="size-row mb-2 d-flex">
                            <select name="sizes[{{ $size->id }}][size_id]" class="form-control select2">
                                @foreach ($sizes as $sizeOption)
                                    <option value="{{ $sizeOption->id }}" {{ $size->id == $sizeOption->id ? 'selected' : '' }}>
                                        {{ $sizeOption->name }} {{ $sizeOption->gram != null ? ' -- ' . $sizeOption->gram : ''}}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" step="0.01" name="sizes[{{ $size->id }}][price]" class="form-control ms-2" placeholder="Price" value="{{ $size->pivot->price }}">
                            <button type="button" class="btn btn-danger remove-size ms-2">Remove</button>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" id="add-size" class="btn btn-secondary mt-2">Add Size</button>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            {{ trans('dashboard/general.save') }}
        </button>
    </div>
</form>

<script>
    $(document).ready(function () {
        // Initialize Select2
        $('.select2').select2({
            width: '100%',
            placeholder: "Select an option"
        });

        // Function to load items for selected item types
        function loadItemsForSelectedItemTypes(selectedItemTypes, productItems) {
            let itemsContainer = $('#items-container');
            itemsContainer.empty(); // Clear previous items

            if (selectedItemTypes.length > 0) {
                selectedItemTypes.forEach(itemTypeId => {
                    $.ajax({
                        url: `/api/items?item_type_id=${itemTypeId}`,
                        type: 'GET',
                        success: function (data) {
                            let itemSection = `
                                <div class="item-section mb-3">
                                    <label class="form-label">Items for ${$('#item_types option[value="' + itemTypeId + '"]').text()}</label>
                                    <select name="items[${itemTypeId}][]" class="form-control select2" multiple="multiple">
                                        ${data.map(item => `
                                            <option value="${item.id}" ${productItems.includes(item.id) ? 'selected' : ''}>${item.name}</option>
                                        `).join('')}
                                    </select>
                                </div>
                            `;
                            itemsContainer.append(itemSection);
                            $('.select2').select2({ width: '100%' }); // Reinitialize Select2
                        }
                    });
                });
            }
        }

        // Get pre-selected item types and items
        let selectedItemTypes = $('#item_types').val();
        let productItems = @json($product?->items->pluck('id')->toArray() ?? []);

        // Load items for pre-selected item types
        if (selectedItemTypes && selectedItemTypes.length > 0) {
            loadItemsForSelectedItemTypes(selectedItemTypes, productItems);
        }

        // Load items when item types change
        $('#item_types').on('change', function () {
            let selectedItemTypes = $(this).val();
            loadItemsForSelectedItemTypes(selectedItemTypes, []);
        });

        // Add Size Row
        $('#add-size').on('click', function () {
            let newSizeRow = `
                <div class="size-row mb-2 d-flex">
                    <select name="sizes[new][size_id]" class="form-control select2">
                        @foreach ($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }} {{$size->gram != null ? ' -- ' . $size->gram .' GRAM' : ''}}</option>
                        @endforeach
                    </select>
                    <input type="number" step="0.01" name="sizes[new][price]" class="form-control ms-2" placeholder="Price">
                    <button type="button" class="btn btn-danger remove-size ms-2">Remove</button>
                </div>
            `;
            $('#sizes-container').append(newSizeRow);
            $('.select2').select2({ width: '100%' }); // Reinitialize Select2
        });

        // Remove Size Row
        $(document).on('click', '.remove-size', function () {
            $(this).closest('.size-row').remove();
        });
    });
</script>
