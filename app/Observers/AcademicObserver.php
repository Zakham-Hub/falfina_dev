<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Academic;

class AcademicObserver
{
    public function created(Academic $academic): void
    {
        $academic->profile()->create([]);
    }
}
