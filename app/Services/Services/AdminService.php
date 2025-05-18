<?php

namespace App\Services\Services;

use App\DataTables\Dashboard\Admin\AdminDataTable;
use App\Dto\AdminDto;
use App\Repositories\AdminRepository;
use App\Services\Contracts\AdminInterface;

class AdminService implements AdminInterface
{
    protected AdminRepository $adminRepository;

    public function __construct()
    {
        $this->adminRepository = new AdminRepository;
    }

    public function index(AdminDataTable $adminDataTable)
    {
        return $this->adminRepository->index($adminDataTable);
    }

    public function store(AdminDto $adminDto)
    {
        return $this->adminRepository->store($adminDto);
    }

    public function update(AdminDto $adminDto, $id)
    {
        return $this->adminRepository->update($adminDto, $id);
    }

    public function find($id)
    {
        return $this->adminRepository->find($id);
    }

    public function destroy($id)
    {
        return $this->adminRepository->destroy($id);
    }
}
