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
        // Super admin y admin pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }

        // Project coordinator, beneficiary coordinator, consultant, volunteer - necesitan permiso
        if ($user->hasAnyRole(['project-coordinator', 'beneficiary-coordinator', 'consultant', 'volunteer'])) {
            return $user->hasPermission('beneficiaries.view') || $user->hasPermission('beneficiaries.view.own');
        }

        // Beneficiarios pueden ver sus propios datos
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
        // Super admin y admin pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }

        // Project coordinator - solo ve beneficiarios de sus proyectos asignados
        if ($user->hasRole('project-coordinator')) {
            return $user->assignedProjects()
                ->where('ng_projects.id', $beneficiary->project_id)
                ->exists();
        }

        // Beneficiary coordinator y consultant - pueden ver todos
        if ($user->hasAnyRole(['beneficiary-coordinator', 'consultant'])) {
            return $user->hasPermission('beneficiaries.view');
        }

        // Volunteer - solo ve beneficiarios de sus proyectos asignados
        if ($user->hasRole('volunteer')) {
            return $user->assignedProjects()
                ->where('ng_projects.id', $beneficiary->project_id)
                ->exists();
        }

        // Un beneficiario solo puede ver sus propios datos
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
        // Super admin puede editar todos
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Admin puede editar todos si tiene el permiso
        if ($user->hasRole('admin')) {
            return $user->hasPermission('beneficiaries.edit');
        }

        // Project coordinator - solo edita beneficiarios de sus proyectos
        if ($user->hasRole('project-coordinator')) {
            return $user->assignedProjects()
                ->where('ng_projects.id', $beneficiary->project_id)
                ->exists() 
                && $user->hasPermission('beneficiaries.edit');
        }

        // Beneficiary coordinator - puede editar todos
        if ($user->hasRole('beneficiary-coordinator')) {
            return $user->hasPermission('beneficiaries.edit');
        }

        // Un beneficiario puede editar sus propios datos limitados
        if ($user->hasRole('beneficiary')) {
            $userBeneficiary = $user->beneficiary;
            return $userBeneficiary && $userBeneficiary->id === $beneficiary->id && $user->hasPermission('profile.edit.own');
        }

        // Voluntario y consultor no pueden editar
        return false;
    }

    /**
     * Determine if the user can delete the beneficiary.
     */
    public function delete(User $user, Beneficiary $beneficiary): bool
    {
        // Super admin puede eliminar
        if ($user->hasRole('super-admin')) {
            return $user->hasPermission('beneficiaries.delete');
        }

        // Admin NO puede eliminar (según la nueva estructura)
        if ($user->hasRole('admin')) {
            return false;
        }

        // Solo beneficiary coordinator puede eliminar
        if ($user->hasRole('beneficiary-coordinator')) {
            return $user->hasPermission('beneficiaries.delete');
        }

        return false;
    }

    /**
     * Scope query to filter beneficiaries based on user role.
     */
    public static function scopeForUser(User $user, $query)
    {
        // Super admin y admin ven todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return $query;
        }

        // Project coordinator - solo ve beneficiarios de sus proyectos asignados
        if ($user->hasRole('project-coordinator')) {
            return $query->whereIn('project_id', $user->assignedProjects()->pluck('ng_projects.id'));
        }

        // Beneficiary coordinator y consultant - ven todos
        if ($user->hasAnyRole(['beneficiary-coordinator', 'consultant'])) {
            return $query;
        }

        // Volunteer - solo ve beneficiarios de sus proyectos asignados
        if ($user->hasRole('volunteer')) {
            return $query->whereIn('project_id', $user->assignedProjects()->pluck('ng_projects.id'));
        }

        // Beneficiarios solo ven su propio registro
        if ($user->hasRole('beneficiary')) {
            $userBeneficiary = $user->beneficiary;
            if ($userBeneficiary) {
                return $query->where('id', $userBeneficiary->id);
            }
            return $query->whereRaw('1 = 0');
        }

        // Por defecto, no retorna nada
        return $query->whereRaw('1 = 0');
    }
}