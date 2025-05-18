<?php

namespace App\Repositories;

use App\Dto\UserDto;
use App\Models\User;
use App\Services\Contracts\AdminUserInterface;
use App\DataTables\Dashboard\Admin\UserDataTable;

class AdminUserRepository implements AdminUserInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('dashboard.admin.users.index', ['pageTitle' => 'المستخدمين']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'تم الحذف بنجاح!');
    }
}
