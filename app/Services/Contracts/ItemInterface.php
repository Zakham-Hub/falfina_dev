<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\ItemDataTable;
use App\Dto\ItemDto;
use Illuminate\Http\Request;
interface ItemInterface
{
    public function index(ItemDataTable $itemDataTable);
    public function store(Request $request,ItemDto $itemDto);
    public function update(Request $request,ItemDto $itemDto, $id);
    public function find($id);
    public function destroy($id);
}
