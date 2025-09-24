<?php

namespace App\Observers;

use App\Models\Admin;
use Carbon\Carbon;

class AdminObservers
{
    /**
     * Handle the User "created" event.
     */
    public function creating(Admin $user): void
    {
        if (empty($user->email_verified_at)) {
            $user->email_verified_at = Carbon::now();
        }
    }
}
