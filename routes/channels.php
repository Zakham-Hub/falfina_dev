<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('admins', function ($user) {
    \Log::info('Admin channel auth attempt', ['user' => $user]);
    return auth()->guard('admin')->check();
});

Broadcast::channel('manager_branch.{branchId}', function ($user, $branchId) {
    \Log::info('Manager channel auth attempt', ['user' => $user, 'branch' => $branchId]);
    return auth()->guard('manager')->check() && $user->branch_id == $branchId;
});
