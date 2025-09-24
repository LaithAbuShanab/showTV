<?php

namespace App\Policies;

use App\Models\Show;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShowPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $user): bool
    {
        return $user->can('view_any_show');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $user, Show $show): bool
    {
        return $user->can('view_show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $user): bool
    {
        return $user->can('create_show');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $user, Show $show): bool
    {
        return $user->can('update_show');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $user, Show $show): bool
    {
        return $user->can('delete_show');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(Admin $user): bool
    {
        return $user->can('delete_any_show');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(Admin $user, Show $show): bool
    {
        return $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(Admin $user): bool
    {
        return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(Admin $user, Show $show): bool
    {
        return $user->can('{{ Restore }}');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(Admin $user): bool
    {
        return $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(Admin $user, Show $show): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(Admin $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}
