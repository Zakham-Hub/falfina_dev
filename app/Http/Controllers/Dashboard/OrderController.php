<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\OrderDataTable;
use App\Services\Contracts\OrderInterface;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct(protected OrderDataTable $orderDataTable, protected OrderInterface $orderInterface)
    {
        $this->orderInterface = $orderInterface;
        $this->orderDataTable = $orderDataTable;
    }

    // public function index(OrderDataTable $orderDataTable)
    // {
    //     return $this->orderInterface->index($this->orderDataTable);
    // }

    public function create()
    {
        return $this->orderInterface->create();
    }

    public function store(Request $request)
    {
        return $this->orderInterface->store($request);
    }
    public function show($id)
    {
        $order = Order::with(['products', 'details', 'extras'])->findOrFail($id);
        return $this->orderInterface->show($order);
    }

    public function edit(Order $order)
    {
        return $this->orderInterface->edit($order);
    }

    public function update(Request $request, Order $order)
    {
        return $this->orderInterface->update($request, $order);
    }
}
