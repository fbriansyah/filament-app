<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    /**
     * Helper to check if user has admin or staff role.
     */
    private function isAdminOrStaff(User $user): bool
    {
        $roles = $user->roles->pluck("slug")->toArray();
        return in_array("admin", $roles) || in_array("staff", $roles);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->isAdminOrStaff($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Service $service): bool
    {
        return $this->isAdminOrStaff($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->isAdminOrStaff($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        return $this->isAdminOrStaff($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        return $this->isAdminOrStaff($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        return $this->isAdminOrStaff($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        return $this->isAdminOrStaff($user);
    }
}
