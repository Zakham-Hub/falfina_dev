<?php

namespace App\Repositories;

use App\Dto\UserDto;
use App\Models\User;
use App\DataTables\Dashboard\Admin\UserDataTable;

class UserRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('dashboard.admin.users.index', ['pageTitle' => 'users']);
    }

    public function create(UserDto $userDto)
    {
        return $this->model->create([
            'name' => $userDto->name,
            'email' => $userDto->email,
            'password' => $userDto->password,
        ]);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'تم الحذف بنجاح!');
    }
}
