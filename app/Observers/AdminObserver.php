<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Admin;

class AdminObserver
{
    public function created(Admin $admin): void
    {
        $admin->profile()->create([]);
    }
}
