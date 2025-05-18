<?php

namespace App\Services\Services;

use App\DataTables\Dashboard\Admin\ItemDataTable;
use App\Dto\ItemDto;
use App\Repositories\ItemRepository;
use App\Services\Contracts\ItemInterface;
use Illuminate\Http\Request;
class ItemService implements ItemInterface
{
    protected ItemRepository $itemRepository;

    public function __construct()
    {
        $this->itemRepository = new ItemRepository;
    }

    public function index(ItemDataTable $itemDataTable)
    {
        return $this->itemRepository->index($itemDataTable);
    }

    public function store(Request $request, ItemDto $itemDto)
    {
        return $this->itemRepository->store($request, $itemDto);
    }

    public function update(Request $request, ItemDto $itemDto, $id)
    {
        return $this->itemRepository->update($request, $itemDto, $id);
    }


    public function find($id)
    {
        return $this->itemRepository->find($id);
    }

    public function destroy($id)
    {
        return $this->itemRepository->destroy($id);
    }
}
