<?php

namespace App\Services\Contracts;

use App\Dto\UserDto;
use App\models\User;
use App\DataTables\Dashboard\Admin\UserDataTable;

interface AdminUserInterface
{
    // public function register(UserDto $userDto);
    // public function login(UserDto $userDto);
    public function index(UserDataTable $userDataTable);
    public function destroy(User $user);
}
