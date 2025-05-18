<div class="d-flex justify-content-center">
    <!-- Edit Button -->
    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm mx-1" title="Edit">
        <i class="fas fa-edit"></i> <!-- Font Awesome edit icon -->
    </a>

    <button type="button" class="mx-1 btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">
        <i class="fas fa-trash"></i>
    </button>

    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="text-center modal-body">
                    <p>هل أنت متأكد من حذف "<strong>{{ $category->name }}</strong>"؟</p>
                    <p class="text-danger">هذا الإجراء لا يمكن التراجع عنه.</p>
                    @php
                        $subCategories = \App\Models\Category::where('parent_id', $category->id)->get();
                    @endphp
                    @if($subCategories->isNotEmpty())
                        <div class="alert alert-warning">
                            <p><strong>تنبيه:</strong> لا يمكنك حذف هذا التصنيف لأنه يحتوي على التصنيفات الفرعية التالية:</p>
                            <ul>
                                @foreach($subCategories as $sub)
                                    <li>{{ $sub->name }}</li>
                                @endforeach
                            </ul>
                            <p>يجب حذف التصنيفات الفرعية أولًا.</p>
                        </div>
                    @else
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">نعم، حذف</button>
                            </form>
                        </div>
                    @endif
                </div>

                {{--<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">نعم، حذف</button>
                    </form>
                </div>--}}
            </div>
        </div>
    </div>
</div>
