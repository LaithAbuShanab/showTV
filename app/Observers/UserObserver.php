<?php

namespace App\Observers;

use App\Models\User;
use Carbon\Carbon;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function creating(User $user): void
    {
        if (empty($user->email_verified_at)) {
            $user->email_verified_at = Carbon::now();
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
