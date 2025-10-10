<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;

class LocationPolicy
{
    /**
     * Determine if the user can view any locations.
     */
    public function viewAny(User $user): bool
    {
        // La mayoría de roles pueden ver ubicaciones
        return $user->hasAnyPermission(['locations.view', 'projects.view', 'beneficiaries.view']);
    }

    /**
     * Determine if the user can view the location.
     */
    public function view(User $user, Location $location): bool
    {
        // La mayoría de roles pueden ver ubicaciones
        return $user->hasAnyPermission(['locations.view', 'projects.view', 'beneficiaries.view']);
    }

    /**
     * Determine if the user can create locations.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('locations.create');
    }

    /**
     * Determine if the user can update the location.
     */
    public function update(User $user, Location $location): bool
    {
        return $user->hasPermission('locations.edit');
    }

    /**
     * Determine if the user can delete the location.
     */
    public function delete(User $user, Location $location): bool
    {
        // Solo roles administrativos pueden eliminar
        return $user->hasAnyRole(['super-admin', 'admin']) 
               && $user->hasPermission('locations.delete');
    }
}

