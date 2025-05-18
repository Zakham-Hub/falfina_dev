<select class="form-control form-control-sm order-status"
        data-id="{{ $order->id }}"
        data-url="{{ route('dashboard.orders.updateStatus', $order->id) }}">
    @foreach (['pending' => 'قيد الانتظار', 'processing' => 'قيد التنفيذ', 'completed' => 'مكتمل', 'cancelled' => 'ملغي'] as $key => $label)
        <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
                