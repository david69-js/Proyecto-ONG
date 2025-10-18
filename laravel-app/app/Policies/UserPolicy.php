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
        return $user->hasPermission('users.view');
    }

    /**
     * Determine if the user can view the user.
     */
    public function view(User $user, User $model): bool
    {
        // Super admin puede ver a todos
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Un usuario siempre puede ver su propio perfil
        if ($user->id === $model->id) {
            return true;
        }

        // Admin puede ver a todos
        if ($user->hasRole('admin')) {
            return true;
        }

        // Otros roles necesitan el permiso específico
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

        // Un usuario siempre puede editar su propio perfil
        if ($user->id === $model->id) {
            return $user->hasPermission('profile.edit.own');
        }

        // Admin puede editar a todos EXCEPTO super-admin
        if ($user->hasRole('admin')) {
            return !$model->hasRole('super-admin') && $user->hasPermission('users.edit');
        }

        // Otros roles no pueden editar a otros usuarios
        return false;
    }

    /**
     * Determine if the user can delete the user.
     */
    public function delete(User $user, User $model): bool
    {
        // Nadie puede eliminarse a sí mismo
        if ($user->id === $model->id) {
            return false;
        }

        // Super admin puede eliminar a todos excepto a sí mismo
        if ($user->hasRole('super-admin')) {
            return $user->hasPermission('users.delete');
        }

        // Admin NO PUEDE eliminar (según la nueva estructura)
        if ($user->hasRole('admin')) {
            return false;
        }

        // Otros roles no pueden eliminar
        return false;
    }

    /**
     * Determine if the user can restore a soft-deleted user.
     */
    public function restore(User $user, User $model): bool
    {
        // Solo super admin puede restaurar
        return $user->hasRole('super-admin');
    }

    /**
     * Determine if the user can permanently delete a user.
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Solo super admin puede eliminar permanentemente
        return $user->hasRole('super-admin');
    }
}