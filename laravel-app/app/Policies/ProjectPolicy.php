<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine if the user can view any projects.
     */
    public function viewAny(User $user): bool
    {
        // Super admin y admin pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }

        // Coordinadores, consultores, donantes y voluntarios pueden ver proyectos
        if ($user->hasAnyRole(['project-coordinator', 'beneficiary-coordinator', 'consultant', 'donor', 'volunteer'])) {
            return $user->hasPermission('projects.view');
        }

        // Beneficiarios solo pueden ver proyectos asignados
        if ($user->hasRole('beneficiary')) {
            return $user->hasPermission('projects.view.own');
        }

        return false;
    }

    /**
     * Determine if the user can view the project.
     */
    public function view(User $user, Project $project): bool
    {
        // Super admin y admin pueden ver todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }

        // El responsable del proyecto puede verlo
        if ($project->responsable_id === $user->id) {
            return true;
        }

        // Coordinador de proyecto solo ve proyectos asignados
        if ($user->hasRole('project-coordinator')) {
            return $user->assignedProjects()->where('projects.id', $project->id)->exists();
        }

        // Voluntario solo ve proyectos asignados
        if ($user->hasRole('volunteer')) {
            return $user->assignedProjects()->where('projects.id', $project->id)->exists();
        }

        // Beneficiarios solo pueden ver si están asignados al proyecto
        if ($user->hasRole('beneficiary')) {
            $beneficiary = $user->beneficiary;
            return $beneficiary && $beneficiary->project_id === $project->id;
        }

        // Consultores, donantes y coordinadores de beneficiarios pueden ver todos con permiso
        if ($user->hasAnyRole(['beneficiary-coordinator', 'consultant', 'donor'])) {
            return $user->hasPermission('projects.view');
        }

        return false;
    }

    /**
     * Determine if the user can create projects.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('projects.create');
    }

    /**
     * Determine if the user can update the project.
     */
    public function update(User $user, Project $project): bool
    {
        // Super admin puede editar todos sin necesidad de permiso explícito
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Admin puede editar si tiene el permiso
        if ($user->hasRole('admin')) {
            return $user->hasPermission('projects.edit');
        }

        // El responsable del proyecto puede editarlo si tiene el permiso
        if ($project->responsable_id === $user->id && $user->hasPermission('projects.edit')) {
            return true;
        }

        // Coordinador solo puede editar SUS proyectos asignados
        if ($user->hasRole('project-coordinator')) {
            return $user->assignedProjects()->where('projects.id', $project->id)->exists() 
                   && $user->hasPermission('projects.edit');
        }

        return false;
    }

    /**
     * Determine if the user can delete the project.
     */
    public function delete(User $user, Project $project): bool
    {
        // Solo super admin puede eliminar sin permiso explícito
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Admin puede eliminar si tiene el permiso
        if ($user->hasRole('admin')) {
            return $user->hasPermission('projects.delete');
        }

        return false;
    }

    /**
     * Scope query to filter projects based on user role.
     */
    public static function scopeForUser(User $user, $query)
    {
        // Super admin y admin ven todos
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return $query;
        }

        // Coordinador de proyecto solo ve proyectos asignados o donde es responsable
        if ($user->hasRole('project-coordinator')) {
            return $query->where(function($q) use ($user) {
                $q->where('responsable_id', $user->id)
                  ->orWhereIn('id', $user->assignedProjects()->pluck('projects.id'));
            });
        }

        // Voluntario solo ve proyectos asignados
        if ($user->hasRole('volunteer')) {
            return $query->whereIn('id', $user->assignedProjects()->pluck('projects.id'));
        }

        // Beneficiarios solo ven su proyecto
        if ($user->hasRole('beneficiary')) {
            $beneficiary = $user->beneficiary;
            if ($beneficiary) {
                return $query->where('id', $beneficiary->project_id);
            }
            return $query->whereRaw('1 = 0');
        }

        // Consultores, donantes y coordinadores de beneficiarios ven todos
        if ($user->hasAnyRole(['beneficiary-coordinator', 'consultant', 'donor'])) {
            return $query;
        }

        // Por defecto, no retorna nada
        return $query->whereRaw('1 = 0');
    }
}