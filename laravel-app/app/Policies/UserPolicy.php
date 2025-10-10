<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view any users.
     */
    public function viewAny(User $user): bool
    {
        // Solo roles administrativos pueden ver lista de usuarios
        return $user->hasPermission('users.view');
    }

    /**
     * Determine if the user can view the user.
     */
    public function view(User $user, User $model): bool
    {
        // Super admin y admin pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }

        // Un usuario puede ver su propio perfil
        if ($user->id === $model->id) {
            return $user->hasAnyPermission(['users.view', 'profile.view.own']);
        }

        // Coordinadores pueden ver otros usuarios si tienen el permiso
        return $user->hasPermission('users.view');
    }

    /**
     * Determine if the user can create users.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('users.create');
    }

    /**
     * Determine if the user can update the user.
     */
    public function update(User $user, User $model): bool
    {
        // Super admin puede editar a todos
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Un usuario puede editar su propio perfil
        if ($user->id === $model->id) {
            return $user->hasAnyPermission(['users.edit', 'profile.edit.own']);
        }

        // Admin puede editar a todos excepto super admin
        if ($user->hasRole('admin')) {
            return !$model->hasRole('super-admin') && $user->hasPermission('users.edit');
        }

        // Otros roles necesitan el permiso específico y no pueden editar admins
        return $user->hasPermission('users.edit') && !$model->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Determine if the user can delete the user.
     */
    public function delete(User $user, User $model): bool
    {
        // No se puede eliminar a sí mismo
        if ($user->id === $model->id) {
            return false;
        }

        // Super admin puede eliminar a todos excepto a sí mismo
        if ($user->hasRole('super-admin')) {
            return $user->hasPermission('users.delete');
        }

        // Admin puede eliminar solo a no-admins
        if ($user->hasRole('admin')) {
            return !$model->hasAnyRole(['super-admin', 'admin']) && $user->hasPermission('users.delete');
        }

        return false;
    }

    /**
     * Determine if the user can manage permissions for another user.
     */
    public function managePermissions(User $user, User $model): bool
    {
        // Solo super admin puede gestionar permisos
        if ($user->hasRole('super-admin')) {
            return $user->hasPermission('roles.assign');
        }

        return false;
    }
}

