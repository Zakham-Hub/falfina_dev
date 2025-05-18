<?php

namespace App\Repositories;

use App\DataTables\Dashboard\Admin\AdminDataTable;
use App\Dto\AdminDto;
use App\Models\Admin;

class AdminRepository
{
    protected $model;

    // Inject the Admin model dynamically
    public function __construct()
    {
        $this->model = new Admin;
    }

    public function index(AdminDataTable $adminDataTable)
    {
        return $adminDataTable->render('dashboard.admin.admins.index', ['pageTitle' => trans('dashboard/admin.admins')]);
    }

    public function store(AdminDto $adminDto)
    {
        return $this->model->create([
            'name' => $adminDto->name,
            'email' => $adminDto->email,
            'password' => $adminDto->password,
            'phone' => $adminDto->phone,
            'status' => $adminDto->status,
            'type' => $adminDto->type,
            'link_password_status' => $adminDto->link_password_status,
            'link_password_protection' => $adminDto->link_password_protection,
        ]);
    }

    public function update(AdminDto $adminDto, $id)
    {
        $admin = $this->model->findOrFail($id);
        $data = [
            'name' => $adminDto->name,
            'email' => $adminDto->email,
            'phone' => $adminDto->phone,
            'status' => $adminDto->status,
            'type' => $adminDto->type,
        ];

        if ($adminDto->password) {
            $data['password'] = $adminDto->password;
        }

        $admin->update($data);

        return $admin;
    }

    public function destroy($id)
    {
        $admin = $this->find($id);

        return $admin->delete();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
}
