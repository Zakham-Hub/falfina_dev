<div class="d-flex justify-content-center">
    <!-- Edit Button -->
    {{-- <a href="{{ route('admin.orders.edit', $order->id) }}" class="mx-1 btn btn-primary btn-sm" title="Edit">
        <i class="fas fa-edit"></i> <!-- Font Awesome edit icon -->
    </a> --}}
            <a href="{{ route('admin.orders.viewPdf', $order->id) }}" class="mx-1 btn btn-primary btn-sm" title="Edit">
                <i class="fas fa-download"></i> <!-- Font Awesome edit icon -->
            </a>
    <a href="{{ route('admin.orders.show', $order->id) }}" class="mx-1 btn btn-success btn-sm" title="Show">
        <i class="fas fa-eye"></i> <!-- Font Awesome edit icon -->
    </a>
    <button type="button" class="mx-1 btn btn-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#deleteModal{{ $order->id }}">
        <i class="fas fa-trash"></i>
    </button>
    <div class="modal fade" id="deleteModal{{ $order->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="text-center modal-body">
                    <p>هل أنت متأكد من حذف "<strong>{{ $order->name }}</strong>"؟</p>
                    <p class="text-danger">هذا الإجراء لا يمكن التراجع عنه.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">نعم، حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
