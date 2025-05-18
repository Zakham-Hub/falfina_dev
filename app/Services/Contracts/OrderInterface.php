<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\General\OrderDataTable;
use Illuminate\Http\Request;
use App\Models\Order;

interface OrderInterface
{
    public function index(OrderDataTable $orderDataTable);
    public function create();
    public function show(Order $order);
    public function downloadOrderInvoice(Order $order);
    public function store(Request $request);
    public function edit(Order $order);
    public function update(Request $request, Order $order);
    public function destroy(Order $order);
    public function updateStatus(Request $request, Order $order);
}
