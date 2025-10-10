<?php

namespace App\Policies;

use App\Models\Beneficiary;
use App\Models\User;

class BeneficiaryPolicy
{
    /**
     * Determine if the user can view any beneficiaries.
     */
    public function viewAny(User $user): bool
    {
        // Roles administrativos pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin', 'project-coordinator', 'beneficiary-coordinator', 'consultant', 'volunteer'])) {
            return $user->hasPermission('beneficiaries.view');
        }

        // Beneficiarios pueden ver sus propios beneficios
        if ($user->hasRole('beneficiary')) {
            return $user->hasPermission('benefits.view.own');
        }

        return false;
    }

    /**
     * Determine if the user can view the beneficiary.
     */
    public function view(User $user, Beneficiary $beneficiary): bool
    {
        // Roles administrativos pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin', 'project-coordinator', 'beneficiary-coordinator', 'consultant', 'volunteer'])) {
            return $user->hasPermission('beneficiaries.view');
        }

        // Un beneficiario puede ver sus propios datos
        if ($user->hasRole('beneficiary')) {
            $userBeneficiary = $user->beneficiary;
            return $userBeneficiary && $userBeneficiary->id === $beneficiary->id;
        }

        return false;
    }

    /**
     * Determine if the user can create beneficiaries.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('beneficiaries.create');
    }

    /**
     * Determine if the user can update the beneficiary.
     */
    public function update(User $user, Beneficiary $beneficiary): bool
    {
        // Roles administrativos pueden editar todos
        if ($user->hasAnyRole(['super-admin', 'admin', 'project-coordinator', 'beneficiary-coordinator'])) {
            return $user->hasPermission('beneficiaries.edit');
        }

        // Un beneficiario puede editar sus propios datos limitados si tiene el permiso
        if ($user->hasRole('beneficiary')) {
            $userBeneficiary = $user->beneficiary;
            return $userBeneficiary && $userBeneficiary->id === $beneficiary->id && $user->hasPermission('profile.edit.own');
        }

        return false;
    }

    /**
     * Determine if the user can delete the beneficiary.
     */
    public function delete(User $user, Beneficiary $beneficiary): bool
    {
        // Solo roles específicos pueden eliminar
        return $user->hasAnyRole(['super-admin', 'admin', 'beneficiary-coordinator']) 
               && $user->hasPermission('beneficiaries.delete');
    }

    /**
     * Scope query to filter beneficiaries based on user role.
     */
    public static function scopeForUser(User $user, $query)
    {
        // Roles administrativos ven todos
        if ($user->hasAnyRole(['super-admin', 'admin', 'project-coordinator', 'beneficiary-coordinator', 'consultant', 'volunteer'])) {
            return $query;
        }

        // Beneficiarios solo ven su propio registro
        if ($user->hasRole('beneficiary')) {
            $userBeneficiary = $user->beneficiary;
            if ($userBeneficiary) {
                return $query->where('id', $userBeneficiary->id);
            }
            return $query->whereRaw('1 = 0');
        }

        return $query->whereRaw('1 = 0');
    }
}

