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
        // Super admin y admin pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }

        // Coordinadores, consultores y voluntarios pueden ver ubicaciones
        if ($user->hasAnyRole(['project-coordinator', 'beneficiary-coordinator', 'consultant', 'volunteer'])) {
            return $user->hasPermission('locations.view');
        }

        // Beneficiarios pueden ver ubicaciones
        if ($user->hasRole('beneficiary')) {
            return $user->hasPermission('locations.view');
        }

        return false;
    }

    /**
     * Determine if the user can view the location.
     */
    public function view(User $user, Location $location): bool
    {
        // Super admin y admin pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }

        // Coordinadores, consultores y voluntarios pueden ver si tienen el permiso
        if ($user->hasAnyRole(['project-coordinator', 'beneficiary-coordinator', 'consultant', 'volunteer'])) {
            return $user->hasPermission('locations.view');
        }

        // Beneficiarios pueden ver ubicaciones
        if ($user->hasRole('beneficiary')) {
            return $user->hasPermission('locations.view');
        }

        return false;
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
        // Super admin puede editar todos
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Admin puede editar si tiene el permiso
        if ($user->hasRole('admin')) {
            return $user->hasPermission('locations.edit');
        }

        // Project coordinator puede editar si tiene el permiso
        if ($user->hasRole('project-coordinator')) {
            return $user->hasPermission('locations.edit');
        }

        // Beneficiary coordinator puede editar si tiene el permiso
        if ($user->hasRole('beneficiary-coordinator')) {
            return $user->hasPermission('locations.edit');
        }

        // Otros roles no pueden editar
        return false;
    }

    /**
     * Determine if the user can delete the location.
     */
    public function delete(User $user, Location $location): bool
    {
        // Super admin puede eliminar
        if ($user->hasRole('super-admin')) {
            return $user->hasPermission('locations.delete');
        }

        // Admin puede eliminar si tiene el permiso
        if ($user->hasRole('admin')) {
            return $user->hasPermission('locations.delete');
        }

        // Otros roles no pueden eliminar
        return false;
    }

    /**
     * Scope query to filter locations based on user role.
     */
    public static function scopeForUser(User $user, $query)
    {
        // Super admin y admin ven todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return $query;
        }

        // Todos los otros roles que tienen permiso ven todas las ubicaciones
        if ($user->hasPermission('locations.view')) {
            return $query;
        }

        // Por defecto, no retorna nada
        return $query->whereRaw('1 = 0');
    }
}