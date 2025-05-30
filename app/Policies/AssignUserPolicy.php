<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AssignUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_assign::user');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AssignUser $assignUser): bool
    {
        return $user->can('view_assign::user');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_assign::user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AssignUser $assignUser): bool
    {
        return $user->can('update_assign::user');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AssignUser $assignUser): bool
    {
        return $user->can('delete_assign::user');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_assign::user');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, AssignUser $assignUser): bool
    {
        return $user->can('force_delete_assign::user');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_assign::user');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, AssignUser $assignUser): bool
    {
        return $user->can('restore_assign::user');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_assign::user');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, AssignUser $assignUser): bool
    {
        return $user->can('replicate_assign::user');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_assign::user');
    }
}
